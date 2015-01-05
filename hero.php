<?php
	// check if hero has location set
	$location_meta_enabled = get_post_meta( get_the_ID(), 'meta-location-checkbox', true );
	if (!empty($location_meta_enabled)) {
		// Retrieves the stored value from the database
		$location_meta_lat = get_post_meta( get_the_ID(), 'meta-location-latitude', true );
		$location_meta_lng = get_post_meta( get_the_ID(), 'meta-location-longitude', true );
		$location_meta_heading = addslashes(get_post_meta( get_the_ID(), 'meta-location-heading', true ));
		$location_meta_description = preg_replace( "/\r|\n/", " <br/>", get_post_meta( get_the_ID(), 'meta-location-description', true ));
	}
	// check if the post has a Post Thumbnail assigned to it.
	else if (has_post_thumbnail()) {
		$image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$large_image_url = $image_array[0];
	}
	else if (function_exists('z_taxonomy_image_url') && is_archive()) {
		$large_image_url = z_taxonomy_image_url();
	}
	else {
		$large_image_url = get_template_directory_uri() . '/img/heroes/hero-' . rand(1, 7) . '.jpg';
	}
?>

<div class="hero wide" style="background-image: url('<?php echo $large_image_url ?>')">
	<?php if(is_page()) {
		// Retrieves the stored value from the database
		$hero_heading = get_post_meta( get_the_ID(), 'hero-heading', true );
		$hero_description = get_post_meta( get_the_ID(), 'hero-description', true );

		// Checks and displays the retrieved value
		if( !empty( $hero_heading ) ) { ?>
			<section>
				<h2><?php echo $hero_heading; ?></h2>

				<?php if( !empty( $hero_description ) ) {
					echo '<p>' . $hero_description . '</p>';
				} ?>
			</section>
		<?php
		}

		// initialize google map if meta is set
		if(!empty($location_meta_enabled) && !empty($location_meta_lat) && !empty($location_meta_lng)) {
			echo '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>';
			echo '<div id="map-canvas"></div>';
			echo '<script>
					mnml.function.initLocationMap(' . $location_meta_lat . ',' . $location_meta_lng . ', "' . $location_meta_heading . '", "' . $location_meta_description . '");
				</script>';
		}
	} ?>
</div>