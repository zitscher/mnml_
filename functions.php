<?php

/*-----------------------------------------------------------------------------------*/
/* Enque Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function less_scripts()  {

	// theme styles
	wp_enqueue_style( 'less-style', get_template_directory_uri() . '/style.css', '10000', 'all' );

}
//add_action( 'wp_enqueue_scripts', 'less_scripts' );

// register main menu
// -------------------------
register_nav_menus(
	array(
		'primary' => __('Primary Menu', 'less'),
	)
);


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


add_action( 'wp_enqueue_scripts', 'add_theme_script' );

function add_theme_script() {
	wp_enqueue_script(
		'mnml-script',
		get_stylesheet_directory_uri() . '/js/mnml_.js',
		array( 'jquery' )
	);
}

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

// Plugin dependencies
// -------------------------
require_once dirname(__FILE__) . '/lib/dependencies.php';
add_action('tgmpa_register', 'load_dependencies');

function load_dependencies() {

	$plugins = array(
		array(
			'name'      		=> 'W3 Total Cache',
			'slug'      		=> 'w3-total-cache',
			'required'  		=> false,
			'force_activation'	=> false,
		),
		array(
			'name'      		=> 'Contact Form 7',
			'slug'      		=> 'contact-form-7',
			'required'			=> false,
			'force_activation'	=> false,
		),
		array(
			'name'      		=> 'Advanced Excerpt',
			'slug'      		=> 'advanced-excerpt',
			'required'  		=> false,
			'force_activation'	=> false,
		),
		array(
			'name'      		=> 'Contact Details',
			'slug'      		=> 'contact',
			'required'  		=> true,
			'force_activation'	=> false,
		),
		array(
			'name'      		=> 'Categories Images',
			'slug'      		=> 'categories-images',
			'required'  		=> true,
			'force_activation'	=> false,
		),
	);

	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
			'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}

// Hero Headings Meta
// -------------------------
function prfx_hero_meta() {
	add_meta_box('prfx_meta', __('Hero Heading Meta', 'prfx-textdomain'), 'prfx_hero_callback', 'page');
}
add_action('add_meta_boxes', 'prfx_hero_meta');

function prfx_hero_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>

	<p>
		<label for="hero-heading"><?php _e( 'Hero Heading', 'prfx-textdomain' )?></label>
		<input type="text" name="hero-heading" id="hero-heading" value="<?php if ( isset ( $prfx_stored_meta['hero-heading'] ) ) echo $prfx_stored_meta['hero-heading'][0]; ?>" />
	</p>
	<p>
		<label for="hero-description"><?php _e( 'Hero Description', 'prfx-textdomain' )?></label>
		<input type="text" name="hero-description" id="hero-description" value="<?php if ( isset ( $prfx_stored_meta['hero-description'] ) ) echo $prfx_stored_meta['hero-description'][0]; ?>" />
	</p>	

<?php
}

function prfx_meta_save( $post_id ) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'hero-heading' ] ) ) {
		update_post_meta( $post_id, 'hero-heading', sanitize_text_field( $_POST[ 'hero-heading' ] ) );
	}
	if( isset( $_POST[ 'hero-description' ] ) ) {
		update_post_meta( $post_id, 'hero-description', sanitize_text_field( $_POST[ 'hero-description' ] ) );
	}

}
add_action( 'save_post', 'prfx_meta_save' );

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


add_shortcode( 'widget', 'my_widget_shortcode' );
function my_widget_shortcode( $atts ) {

	// Configure defaults and extract the attributes into variables
	extract(
		shortcode_atts(
			array(
				'type' => '',
				'title' => '',
			),
			$atts
		)
	);

	$args = array(
		'before_widget' => '<section class="box widget">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	);

	ob_start();
	the_widget($type, $atts, $args);
	$output = ob_get_clean();

	return $output;
}