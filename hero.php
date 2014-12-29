<?php
	// check if the post has a Post Thumbnail assigned to it.
	if ( has_post_thumbnail() ) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0];
		$hero_class = 'wide';
	}
	else {
		$hero_class = 'wide fallback';
	}

	echo '<div class="hero ' . $hero_class .'" style="background-image: url('. $large_image_url .')"></div>';
?>