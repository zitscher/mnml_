var mnml = mnml || {};

// application variables
mnml.global = mnml.global || {};

mnml.global = {
	pageOffset: 0,
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
			mnml.global.pageOffset = mnml.global.hero.offset().top;

			mnml.function.calculateHero();
			mnml.function.calculateHeader();

			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
		}
	});
}

mnml.function.calculateHero = function() {
	var heroDivider = 4;
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
	var threshold = 180;
	if(mnml.global.pageOffset > (mnml.global.heroHeight - threshold)) {
		mnml.global.header.addClass('compact');
		//mnml.global.logo.slideUp();
	}
	else {
		mnml.global.header.removeClass('compact');
		//mnml.global.logo.slideDown();
	}
}


// init application
jQuery(document).ready(function () {
	mnml.init();
});