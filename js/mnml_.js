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

// init application
jQuery(document).ready(function () {
	mnml.init();
});