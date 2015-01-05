<?php

// Journey Meta
// -------------------------
function prfx_location_meta() {
	add_meta_box('prfx_location_meta', __('Location Meta', 'prfx-textdomain'), 'prfx_location_callback', 'page');
}

add_action('add_meta_boxes', 'prfx_location_meta');

function prfx_location_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>

	<h3>Enable Location Hero</h3>
	<p>
		<div class="prfx-row-content">
			<label for="meta-location-checkbox">
				<input type="checkbox" name="meta-location-checkbox" id="meta-location-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-location-checkbox'] ) ) checked( $prfx_stored_meta['meta-location-checkbox'][0], 'yes' ); ?> />
				<?php _e( 'Show Location for this page', 'prfx-textdomain' )?>
			</label>
		</div>
	</p>

	<h3>Location</h3>
	<p>
		<label for="meta-location-latitude"><?php _e('Latitude', 'prfx-textdomain') ?></label>
		<input type="text" name="meta-location-latitude" id="meta-location-latitude" value="<?php if (isset ($prfx_stored_meta['meta-location-latitude'])) {echo $prfx_stored_meta['meta-location-latitude'][0];} ?>"/>
	</p>
	<p>
		<label for="meta-location-longitude"><?php _e('Longitude', 'prfx-textdomain') ?></label>
		<input type="text" name="meta-location-longitude" id="meta-location-longitude" value="<?php if (isset ($prfx_stored_meta['meta-location-longitude'])) {echo $prfx_stored_meta['meta-location-longitude'][0];} ?>"/>
	</p>

	<h3>Meta</h3>
	<p>
		<label for="meta-location-heading"><?php _e('Heading', 'prfx-textdomain') ?></label>
		<input type="text" name="meta-location-heading" id="meta-location-heading" value="<?php if (isset ($prfx_stored_meta['meta-location-heading'])) {echo $prfx_stored_meta['meta-location-heading'][0];} ?>"/>
	</p>
	<p>
    	<label for="meta-location-description"><?php _e('Description', 'prfx-textdomain')?></label>
    	<textarea name="meta-location-description" id="meta-location-description"><?php if ( isset ( $prfx_stored_meta['meta-location-description'] ) ) echo $prfx_stored_meta['meta-location-description'][0]; ?></textarea>
	</p>

	<?php
}


/**
 * Saves the custom meta input
 */
function save_location_meta($post_id) {

	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	if( isset( $_POST[ 'meta-location-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-location-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-location-checkbox', '' );
	}

	if( isset( $_POST[ 'meta-location-latitude' ] ) ) {
		update_post_meta( $post_id, 'meta-location-latitude', sanitize_text_field( $_POST[ 'meta-location-latitude' ] ) );
	}

	if( isset( $_POST[ 'meta-location-longitude' ] ) ) {
		update_post_meta( $post_id, 'meta-location-longitude', sanitize_text_field( $_POST[ 'meta-location-longitude' ] ) );
	}

	if( isset( $_POST[ 'meta-location-heading' ] ) ) {
		update_post_meta( $post_id, 'meta-location-heading', sanitize_text_field( $_POST[ 'meta-location-heading' ] ) );
	}

	if( isset( $_POST[ 'meta-location-description' ] ) ) {
		update_post_meta( $post_id, 'meta-location-description', $_POST[ 'meta-location-description' ] );
	}

}
add_action( 'save_post', 'save_location_meta' );

?>