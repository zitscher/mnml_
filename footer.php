<footer role="contentinfo">
	<div class="container">
		<div class="row">
		<?php if (function_exists('contact_detail')) { ?>
			<div class="col-3">
			<?php
				contact_detail('heading', '<h3>', '</h3>');
				contact_detail('address', '<address>', '</address>');
			?>
			</div>
		<?php } ?>

		<?php if (function_exists('contact_detail')) { ?>
			<ul class="col-3">
				<li>
					<i class="fa fa-phone"></i>
					<a href="tel:<?php contact_detail('phone'); ?>"><?php contact_detail('phone'); ?></a>
				</li>
				<li>
					<i class="fa fa-envelope-o"></i>
					<a href="mailto:<?php contact_detail('email'); ?>"><?php contact_detail('email'); ?></a>
				</li>
				<li>
					<i class="fa fa-facebook"></i>
					<a href="<?php contact_detail('facebook_link'); ?>" target="_blank"><?php contact_detail('facebook_title'); ?></a>
				</li>
			</ul>
		<?php } ?>

			<div class="col-6 copyright">
				<i class="fa fa-copyright"></i>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"" rel="generator"><?php echo date('Y'); ?> <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
			</div>

		</div>
	</div>
</footer>

<?php wp_footer(); ?>