var mnml = mnml || {};

// application variables
mnml.global = mnml.global || {};

mnml.global = {
	pageOffset: 0,
	page: false,
	hero: false,
	heroSection: false,
	heroHeight: false,
	header: false,
	logo: false
}

mnml.init = function() {
	mnml.cacheElements();

	// initialize forms
	var form = jQuery('form');
	if(form.length){
		mnml.function.modifyContactForm(form);
	};

	mnml.function.initScrollingCalculations();

	mnml.function.initPhotoswipe();
};

mnml.cacheElements = function() {
	mnml.global.page = jQuery(document);
	mnml.global.hero = jQuery('.hero');
	mnml.global.heroSection = mnml.global.hero.find('section');
	mnml.global.heroHeight = mnml.global.hero.outerHeight();
	mnml.global.header = jQuery('header');
	mnml.global.logo = mnml.global.header.find('img');
}

mnml.function = mnml.function || {};

// adds additional class for inputs and textares onFocus for styling purposes
mnml.function.modifyContactForm = function(form) {
	var css_class = 'focus';

	form.find('input, textarea').each(function() {
		var element = jQuery(this);

		element.on('focus', function() {
			jQuery(this).parent().addClass(css_class);
		});

		element.on('blur', function() {
			jQuery(this).parent().removeClass(css_class);
		});
	});
};

mnml.function.initScrollingCalculations = function() {
	var parallaxScrollEventInMs = 10;

	var scrollHandling = {
		allow: true,
		reallow: function() {
			scrollHandling.allow = true;
		},
		delay: parallaxScrollEventInMs
	};

	jQuery(document).on('scroll', function() {
		if(scrollHandling.allow) {
			// save page offset
			mnml.global.pageOffset = mnml.global.page.scrollTop();

			mnml.function.calculateHero();
			mnml.function.calculateHeader();

			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
		}
	});
}

mnml.function.calculateHero = function() {
	var heroDivider = 3;
	var heroSectionDivider = 300;

	var offsetHero = -(mnml.global.pageOffset / heroDivider) + 'px';
	var offsetHeroSection = 1 - (mnml.global.pageOffset / heroSectionDivider) ;

	mnml.global.hero.css({
		'transform': 'translate3d(0px,' + offsetHero + ',0px)'
	});

	mnml.global.heroSection.css({
		'opacity': offsetHeroSection
	});
};

mnml.function.calculateHeader = function() {
	var css_class = 'compact';

	if(mnml.global.pageOffset > (mnml.global.heroHeight)) {
		jQuery('body').addClass(css_class);
		mnml.global.header.addClass(css_class);
	}
	else {
		jQuery('body').removeClass(css_class);
		mnml.global.header.removeClass(css_class);
	}
}

mnml.function.initLocationMap = function(lat, lng, heading, description) {
	var location = new google.maps.LatLng(lat, lng);

	var mapOptions = {
		scrollwheel: false,
		panControl: false,
		mapTypeControl: false,
		streetViewControl: false,
		zoomControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE,
			position: google.maps.ControlPosition.LEFT_CENTER
		},
		zoom: 13,
		center: location,
		mapTypeId: 'satellite'
	};

	var styles = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":60}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"lightness":30}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ef8c25"},{"lightness":40}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#b6c54c"},{"lightness":40},{"saturation":-40}]},{}];
	var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

	map.mapTypes.set('map_style', styledMap);
	map.setMapTypeId('map_style');

	var contentString = '' +
		'<div class="map-window">'+
		'	<h3>' + heading + '</h3>'+
		'	<p>' + description + '</p>'+
		'</div>';

	var marker = new google.maps.Marker({
		position: location,
		map:map,

		draggable: false,
		title: "Nettebad"
	});

	marker.setMap(map);

	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	infowindow.open(map,marker);

	map.panBy(0, -30);
}


mnml.function.initPhotoswipe = function() {
	var initPhotoSwipeFromDOM = function(gallerySelector) {

		// parse slide data (url, title, size ...) from DOM elements
		// (children of gallerySelector)
		var parseThumbnailElements = function(el) {
			var thumbElements = el.childNodes,
				numNodes = thumbElements.length,
				items = [],
				figureEl,
				childElements,
				linkEl,
				size,
				item;

			for(var i = 0; i < numNodes; i++) {


				figureEl = thumbElements[i]; // <figure> element

				// include only element nodes
				if(figureEl.nodeType !== 1) {
					continue;
				}

				linkEl = figureEl.children[0]; // <a> element

				// create slide object
				item = {
					src: linkEl.getAttribute('href'),
					w: 1600,
					h: 1200
				};

				if(figureEl.children.length > 1) {
					// <figcaption> content
					item.title = figureEl.children[1].innerHTML;
				}

				if(linkEl.children.length > 0) {
					// <img> thumbnail element, retrieving thumbnail url
					item.msrc = linkEl.children[0].getAttribute('src');
				}

				item.el = figureEl; // save link to element for getThumbBoundsFn
				items.push(item);
			}

			return items;
		};

		// find nearest parent element
		var closest = function closest(el, fn) {
			return el && ( fn(el) ? el : closest(el.parentNode, fn) );
		};

		// triggers when user clicks on thumbnail
		var onThumbnailsClick = function(e) {
			e = e || window.event;
			e.preventDefault ? e.preventDefault() : e.returnValue = false;

			var eTarget = e.target || e.srcElement;

			var clickedListItem = closest(eTarget, function(el) {
				return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
			});

			if(!clickedListItem) {
				return;
			}


			// find index of clicked item
			var clickedGallery = clickedListItem.parentNode,
				childNodes = clickedListItem.parentNode.childNodes,
				numChildNodes = childNodes.length,
				nodeIndex = 0,
				index;

			for (var i = 0; i < numChildNodes; i++) {
				if(childNodes[i].nodeType !== 1) {
					continue;
				}

				if(childNodes[i] === clickedListItem) {
					index = nodeIndex;
					break;
				}
				nodeIndex++;
			}



			if(index >= 0) {
				openPhotoSwipe( index, clickedGallery );
			}
			return false;
		};

		// parse picture index and gallery index from URL (#&pid=1&gid=2)
		var photoswipeParseHash = function() {
			var hash = window.location.hash.substring(1),
				params = {};

			if(hash.length < 5) {
				return params;
			}

			var vars = hash.split('&');
			for (var i = 0; i < vars.length; i++) {
				if(!vars[i]) {
					continue;
				}
				var pair = vars[i].split('=');
				if(pair.length < 2) {
					continue;
				}
				params[pair[0]] = pair[1];
			}

			if(params.gid) {
				params.gid = parseInt(params.gid, 10);
			}

			if(!params.hasOwnProperty('pid')) {
				return params;
			}
			params.pid = parseInt(params.pid, 10);
			return params;
		};

		var openPhotoSwipe = function(index, galleryElement, disableAnimation) {
			var pswpElement = document.querySelectorAll('.pswp')[0],
				gallery,
				options,
				items;

			items = parseThumbnailElements(galleryElement);

			// define options (if needed)
			options = {
				index: index,

				// define gallery index (for URL)
				galleryUID: galleryElement.getAttribute('data-pswp-uid'),

				getThumbBoundsFn: function(index) {
					// See Options -> getThumbBoundsFn section of docs for more info
					var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
						pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
						rect = thumbnail.getBoundingClientRect();

					return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
				},

				// history & focus options are disabled on CodePen
				// remove these lines in real life:
				historyEnabled: false,
				focus: false

			};

			if(disableAnimation) {
				options.showAnimationDuration = 0;
			}

			// Pass data to PhotoSwipe and initialize it
			gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
			gallery.init();
		};

		// loop through all gallery elements and bind events
		var galleryElements = document.querySelectorAll( gallerySelector );

		for(var i = 0, l = galleryElements.length; i < l; i++) {
			galleryElements[i].setAttribute('data-pswp-uid', i+1);
			galleryElements[i].onclick = onThumbnailsClick;
		}

		// Parse URL and open gallery if it contains #&pid=3&gid=1
		var hashData = photoswipeParseHash();
		if(hashData.pid > 0 && hashData.gid > 0) {
			openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], true );
		}
	};

// execute above function
	initPhotoSwipeFromDOM('.gallery');
}

// init application
jQuery(document).ready(function () {
	mnml.init();
});