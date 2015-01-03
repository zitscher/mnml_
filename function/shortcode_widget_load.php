<?php
	function my_widget_shortcode( $atts ) {

		// Configure defaults and extract the attributes into variables
		extract(
			shortcode_atts(
				array(
					'type' => '',
					'title' => '',
				),
				$atts
			)
		);

		$args = array(
			'before_widget' => '<section class="box widget">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		);

		ob_start();
		the_widget($type, $atts, $args);
		$output = ob_get_clean();

		return $output;
	}

	add_shortcode( 'widget', 'my_widget_shortcode' );
?>