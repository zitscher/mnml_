<?php

include_once 'function/theme_support.php';
include_once 'function/dependencies.php';
include_once 'function/shortcode_widget_load.php';
include_once 'function/hero_meta.php';
include_once 'function/location_meta.php';


// load theme javascript
// -------------------------
function add_theme_script() {
	wp_enqueue_script(
		'mnml-script',
		get_stylesheet_directory_uri() . '/js/mnml_.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'add_theme_script' );


/**
 * Adds backend stylesheet when appropriate
 */
function add_backend_styles(){
	global $typenow;
	if( $typenow == 'page' ) {
		wp_enqueue_style( 'backend_styles', get_stylesheet_directory_uri() . '/backend.css' );
	}
}
add_action( 'admin_print_styles', 'add_backend_styles' );


// custom contact fields
// -------------------------
add_filter('contact_details', function($details) {
		$details['heading'] = __('Überschrift');
		$details['facebook_title'] = __('Facebook Title');
		$details['facebook_link'] = __('Facebook Link');
		unset($details['fax']);
		unset($details['mobile']);
    return $details;
} );

// Grid stuff
// TODO
function create_start_column($atts) {
	extract(shortcode_atts(array(
							   'count' => 12
						   ), $atts));
	return '<div class="col-' . $count . '">';
}

function create_end_column() {
	return '</div>';
}

add_shortcode('column-start', 'create_start_column');
add_shortcode('column-end',   'create_end_column');