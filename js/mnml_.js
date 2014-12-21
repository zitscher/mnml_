var mnml = mnml || {};

mnml.init = function() {
	var form = jQuery('form');
	if(form.length){
		mnml.function.modifyContactForm(form);
	};
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

jQuery(document).ready(function () {
	mnml.init();
});