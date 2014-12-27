<footer role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"" rel="generator">&copy; <?php echo date('Y'); ?> <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>