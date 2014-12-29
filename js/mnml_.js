var mnml = mnml || {};

mnml.init = function() {
	// initialize forms
	var form = jQuery('form');
	if(form.length){
		mnml.function.modifyContactForm(form);
	};

	// init parallax hero
	mnml.function.initParallaxHero();
};


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


mnml.function.initParallaxHero = function(form) {
	var hero = jQuery('.hero');
	var header = jQuery('header');
	var parallaxDividerValue = 4;
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
			var offset = -(header.offset().top / parallaxDividerValue) + 'px';

			hero.css({
				'transform': 'translate3d(0px,' + offset + ',0px)'
			});

			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
		}
	});
};


// init application
jQuery(document).ready(function () {
	mnml.init();
});