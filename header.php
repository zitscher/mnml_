<header id="masthead" role="banner">
	<div class="container">
		<h1><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></h1>

		<?php if(display_header_text()) { ?>
			<div class="title">
				<h2><a href=”<?php echo get_option('home'); ?>/”><?php bloginfo('name'); ?></a></h2>
				<div><?php bloginfo('description'); ?></div>
			</div>
		<?php } ?>

		<a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
		</a>

		<?php
			$defaults = array(
				'container' => 'nav',
			);

			wp_nav_menu($defaults);
		?>
	</div>
</header>

