<?php
	// check if the post has a Post Thumbnail assigned to it.
	if (has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0];
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
		<?php } ?>
	<?php } ?>
</div>