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

function add_data_size_attribute ($content, $id, $size, $permalink, $icon, $text) {
	if ($permalink) {
		return $content;
	}

	$content = preg_replace("/<a/","<a data-size=\"" . 1600 . "x" . 1200 .  "\"",$content,1);
	return $content;
}
add_filter( 'wp_get_attachment_link', 'add_data_size_attribute', 10, 6);


// Custom filter function to modify default gallery shortcode output
function my_post_gallery( $output, $attr ) {

	// Initialize
	global $post, $wp_locale;

	// Gallery instance counter
	static $instance = 0;
	$instance++;

	// Validate the author's orderby attribute
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	extract( shortcode_atts( array(
								 'order'      => 'ASC',
								 'orderby'    => 'menu_order ID',
								 'id'         => $post->ID,
								 'itemtag'    => 'figure',
								 'icontag'    => 'dt',
								 'captiontag' => 'figcaption',
								 'columns'    => 3,
								 'size'       => 'thumbnail',
								 'include'    => '',
								 'exclude'    => ''
							 ), $attr ) );

	// Initialize
	$id = intval( $id );
	$attachments = array();
	if ( $order == 'RAND' ) $orderby = 'none';

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return '';

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	// Filter tags and attributes
	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";

	// Filter gallery CSS
	$output = apply_filters( 'gallery_style', "
		<style type='text/css'>
			#{$selector} .gallery-item {
				width: {$itemwidth}%;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='$selector' class='gallery galleryid-{$id}'>"
	);

	// Iterate through the attachments in this gallery instance
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		// Attachment link
		$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );

		// Start itemtag
		$output .= "<{$itemtag} class='gallery-item'>";

		// icontag
		$output .= $link;

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {

			// captiontag
			$output .= "
			<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
			</{$captiontag}>";

		}

		// End itemtag
		$output .= "</{$itemtag}>";

		// Line breaks by columns set
//		if($columns > 0 && ++$i % $columns == 0) $output .= '<br style="clear: both">';

	}

	// End gallery output
	$output .= "</div>\n";

	return $output;

}

// Apply filter to default gallery shortcode
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );