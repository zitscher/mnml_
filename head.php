<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php bloginfo('name'); ?> | <?php if( is_home() ) : echo bloginfo( 'description' ); endif; ?><?php wp_title( '', true ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/style.css' ?>">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

	<?php wp_head(); ?>
</head>