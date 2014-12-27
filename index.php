<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php get_template_part('head'); ?>

<body <?php body_class(); ?>>

	<?php get_header(); ?>

	<?php get_template_part('hero'); ?>

	<div id="content" class="container" role="main">

		<div class="row">
			<div class="col-12">
			<?php
				if(is_page()) {
					get_template_part('site');
				}
				else if(is_home() || is_archive()) {
					get_template_part('posts');
				}
				else if(is_single()) {
					get_template_part('post');
				}
				else if(is_404()) {
					get_template_part('not_found');
				}
			?>
			</div>
		</div>
	</div>

	<?php get_footer(); ?>

</body>
</html>
