<?php
/**
 * Basic theme settings
 */
function motordev_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'main-menu' => 'Основное меню',
			'sidebar-menu' => 'Меню в сайдбаре',
			'footer-menu' => 'Меню в подвале',
			'footer-menu-2' => 'Меню в подвале 2'
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'motordev_setup' );


/**
 * Enqueue scripts and styles (front end)
 */
function motordev_scripts() {
	// CSS	
	wp_enqueue_style( 'motordev-style', get_stylesheet_uri() );
	wp_enqueue_style( 'motordev-style-main', get_theme_file_uri( 'assets/css/style-main.css' ), array(), null, 'all'  );

	// JS
	// wp_enqueue_script( 'motordev-ya-maps',        'https://api-maps.yandex.ru/2.1/?lang=ru_RU',                array(),           null, true );
	wp_enqueue_script( 'motordev-fancybox',       get_theme_file_uri( 'assets/js/libraries/fancybox.min.js' ), array( 'jquery' ), null, true );
	wp_enqueue_script( 'motordev-swiper',         get_theme_file_uri( 'assets/js/libraries/swiper.min.js' ),   array(),           null, true );
	wp_enqueue_script( 'motordev-mask',           get_theme_file_uri( 'assets/js/libraries/imask.js' ),        array(),           null, true );
	wp_enqueue_script( 'motordev-main-script',    get_theme_file_uri( 'assets/js/script-main.js' ),            array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'motordev_scripts' );


/**
 * Enqueue scripts and styles (admin)
 */
function motordev_admin_styles() {
	// CSS
	wp_enqueue_style( 'motordev-admin-styles', get_theme_file_uri( 'assets/css/style-admin.css' ) );

	// Глобальные параметры для скриптов
	// wp_localize_script( 'motordev-admin-main-script', 'themeGlobalJS', array( 
	// 	'themeUri' => get_template_directory_uri(),
	// 	'currentPage' => get_current_screen()->id,
	// ) );
}
add_action( 'admin_enqueue_scripts', 'motordev_admin_styles' );


/**
 * Custom funcs
 */
require get_template_directory() . '/includes/carbon-fields/carbon-fields-plugin.php';
require get_template_directory() . '/includes/theme-post-meta.php';
require get_template_directory() . '/includes/theme-options.php';
require get_template_directory() . '/includes/theme-functions.php';