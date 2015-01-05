<?php

// Hero Headings Meta
// -------------------------
function prfx_hero_meta() {
add_meta_box('prfx_hero_meta', __('Hero Heading Meta', 'prfx-textdomain'), 'prfx_hero_callback', 'page');
}
add_action('add_meta_boxes', 'prfx_hero_meta');

function prfx_hero_callback($post)
{
	wp_nonce_field(basename(__FILE__), 'prfx_nonce');
	$prfx_stored_meta = get_post_meta($post->ID);
	?>

	<p>
		<label for="hero-heading"><?php _e('Hero Heading', 'prfx-textdomain') ?></label>
		<input type="text" name="hero-heading" id="hero-heading"
			   value="<?php if (isset ($prfx_stored_meta['hero-heading'])) {
				   echo $prfx_stored_meta['hero-heading'][0];
			   } ?>"/>
	</p>
	<p>
		<label for="hero-description"><?php _e('Hero Description', 'prfx-textdomain') ?></label>
		<input type="text" name="hero-description" id="hero-description"
			   value="<?php if (isset ($prfx_stored_meta['hero-description'])) {
				   echo $prfx_stored_meta['hero-description'][0];
			   } ?>"/>
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

?>