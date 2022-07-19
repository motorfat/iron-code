<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- <link rel="shortcut icon" href="<?php //echo get_theme_file_uri( 'assets/img/favicons/favicon.ico' ); ?>" type="image/x-icon"> -->
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'motordev-wp' ); ?>>

<?php wp_body_open(); ?>

<!-- Page open wrap -->
<div id="page-global-wrapper" class="page-wrapper">
<?php get_template_part( 'template-parts/page', 'header' ); ?>