<header id="masthead" class="site-header" role="banner">
	<div class="container">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php //bloginfo( 'name' ); ?>
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo_sm.png" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
			</a>
			<?php //echo get_bloginfo( 'description' ); ?>
		</h1>

		<nav role="navigation" class="site-navigation main-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav>
	</div>
</header>
