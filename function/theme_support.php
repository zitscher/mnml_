<?php

// register main menu
// -------------------------
function register_header_menu() {
	register_nav_menu('header-menu',__('Header Menu'));
}
add_action('init', 'register_header_menu');


// enable post and page images
// -------------------------
add_theme_support('post-thumbnails');


// enable custom headers
// -------------------------
$custom_header_args = array(
	'width'         => 140,
	'height'        => 79,
	'default-image' => get_template_directory_uri() . '/img/logo_.png',
	'uploads'       => true,
);
add_theme_support('custom-header', $custom_header_args);

?>