<?php
// check if the post has a Post Thumbnail assigned to it.
if ( has_post_thumbnail() ) {
	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0];
	echo '<div class="hero wide" style="background-image: url('. $large_image_url .')"></div>';
}
?>