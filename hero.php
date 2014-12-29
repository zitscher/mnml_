<?php
	// check if the post has a Post Thumbnail assigned to it.
	if (has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0];
	}
	else if (function_exists('z_taxonomy_image_url')) {
		$large_image_url = z_taxonomy_image_url();
	}
	else {
		$large_image_url = get_template_directory_uri() . '/img/heroes/hero-' . rand(1, 7) . '.jpg';
	}

	echo '<div class="hero wide" style="background-image: url('. $large_image_url .')"></div>';
?>