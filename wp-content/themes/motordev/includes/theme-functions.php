<?php
/**
 * CSS-классы для body в админке
 */
function motordev_admin_body_classes( $classes ){
	$motordev_classes = 'motordev-wp-admin';

	return $classes . ' ' . $motordev_classes;
}
add_filter( 'admin_body_class', 'motordev_admin_body_classes' );


/**
 * Удаление виджетов из главной страницы консоли
 */
function motordev_admin_dashboard_widgets(){
	$dash_side   = & $GLOBALS['wp_meta_boxes']['dashboard']['side']['core'];
	$dash_normal = & $GLOBALS['wp_meta_boxes']['dashboard']['normal']['core'];

    // Удаление виджетов
	// unset( $dash_side['dashboard_quick_press'] );       // Быстрая публикация
	unset( $dash_side['dashboard_recent_drafts'] );     // Последние черновики
	unset( $dash_side['dashboard_primary'] );           // Блог WordPress
	unset( $dash_side['dashboard_secondary'] );         // Другие Новости WordPress
	unset( $dash_normal['dashboard_incoming_links'] );  // Входящие ссылки
	unset( $dash_normal['dashboard_right_now'] );       // Прямо сейчас
	unset( $dash_normal['dashboard_recent_comments'] ); // Последние комментарии
	unset( $dash_normal['dashboard_plugins'] );         // Последние Плагины
	// unset( $dash_normal['dashboard_activity'] );        // Активность
	unset( $dash_normal['dashboard_site_health'] );     // Здоровье сайта    
    remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'motordev_admin_dashboard_widgets' );
remove_action( 'welcome_panel', 'wp_welcome_panel' );


/**
 * Шрифты и скрипты в head
 */
function motordev_wp_head() {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
	<?php
}
add_action( 'wp_head', 'motordev_wp_head' );

/**
 * Настройка краткого текста
 */
/**
 * Cuts the specified text up to specified number of characters.
 * Strips any of shortcodes.
 *
 * Important changes:
 * 2.8.0 - Improved logic to work with HTML tags in cutting text.
 * 2.7.2 - Cuts direct URLs from content.
 * 2.7.0 - `sanitize_callback` parameter.
 * 2.6.5 - `ignore_more` parameter.
 * 2.6.2 - Regular to remove blocky shortcodes like: [foo]some data[/foo].
 * 2.6   - Removed the `save_format` parameter and replaced it with two parameters `autop` and `save_tags`.
 *
 * @author Kama (wp-kama.ru)
 * @version 2.8.0
 *
 * @param string|array $args {
 *     Optional. Arguments to customize output.
 *
 *     @type int       $maxchar            Max number of characters.
 *     @type string    $text               The text to be cut. The default is `post_excerpt` if there is no `post_content`.
 *                                         If the text has `<!--more-->`, then `maxchar` is ignored and everything
 *                                         up to `<!--more-->` is taken including HTML.
 *     @type bool      $autop              Replace the line breaks with `<p>` and `<br>` or not?
 *     @type string    $more_text          The text of `Read more` link.
 *     @type string    $save_tags          Tags to be left in the text. For example `<strong><b><a>`.
 *     @type string    $sanitize_callback  Text cleaning function.
 *     @type bool      $ignore_more        Whether to ignore `<!--more-->` in the content.
 *
 * }
 *
 * @return string HTML
 */
function motordev_custom_excerpt( $args = '' ){
	global $post;

	if( is_string( $args ) ){
		parse_str( $args, $args );
	}

	$rg = (object) array_merge( [
		'maxchar'           => 350,
		'text'              => '',
		'autop'             => true,
		'more_text'         => '...',
		'ignore_more'       => false,
		'save_tags'         => '<strong><b><a><em><i><var><code><span>',
		'sanitize_callback' => static function( string $text, object $rg ){
			return strip_tags( $text, $rg->save_tags );
		},
	], $args );

	$rg = apply_filters( 'kama_excerpt_args', $rg );

	if( ! $rg->text ){
		$rg->text = $post->post_excerpt ?: $post->post_content;
	}

	$text = $rg->text;
	// strip content shortcodes: [foo]some data[/foo]. Consider markdown
	$text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text );
	// strip others shortcodes: [singlepic id=3]. Consider markdown
	$text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text );
	// strip direct URLs
	$text = preg_replace( '~(?<=\s)https?://.+\s~', '', $text );
	$text = trim( $text );

	// <!--more-->
	if( ! $rg->ignore_more && strpos( $text, '<!--more-->' ) ){

		preg_match( '/(.*)<!--more-->/s', $text, $mm );

		$text = trim( $mm[1] );

		$text_append = sprintf( ' <a href="%s#more-%d">%s</a>', get_permalink( $post ), $post->ID, $rg->more_text );
	}
	// text, excerpt, content
	else {

		$text = call_user_func( $rg->sanitize_callback, $text, $rg );
		$has_tags = false !== strpos( $text, '<' );

		// collect html tags
		if( $has_tags ){
			$tags_collection = [];
			$nn = 0;

			$text = preg_replace_callback( '/<[^>]+>/', static function( $match ) use ( & $tags_collection, & $nn ){
				$nn++;
				$holder = "~$nn";
				$tags_collection[ $holder ] = $match[0];

				return $holder;
			}, $text );
		}

		// cut text
		$cuted_text = mb_substr( $text, 0, $rg->maxchar );
		if( $text !== $cuted_text ){

			// del last word, it not complate in 99%
			$text = preg_replace( '/(.*)\s\S*$/s', '\\1...', trim( $cuted_text ) );
		}

		// bring html tags back
		if( $has_tags ){
			$text = strtr( $text, $tags_collection );
			$text = force_balance_tags( $text );
		}
	}

	// add <p> tags. Simple analog of wpautop()
	if( $rg->autop ){

		$text = preg_replace(
			[ "/\r/", "/\n{2,}/", "/\n/" ],
			[ '', '</p><p>', '<br />' ],
			"<p>$text</p>"
		);
	}

	$text = apply_filters( 'kama_excerpt', $text, $rg );

	if( isset( $text_append ) ){
		$text .= $text_append;
	}

	return $text;
}

add_filter( 'excerpt_more', function( $more ) {
	return '...';
} );

function motordev_custom_excerpt_length( $length ){
	global $post;

	if ($post->post_type == 'post')
		return 30;
    else
    	return 60;
}
add_filter('excerpt_length', 'motordev_custom_excerpt_length');


/**
 * Заголовок секции
 */
function motordev_section_heading( $section_heading = [] ) {
	if( empty( $section_heading['tag'] )  ) $section_heading['tag'] = 'h3';

	$section_heading_output = '<div class="section-heading ' . esc_attr( $section_heading['class'] ) . ' ">';	
	$section_heading_output .= '<' . $section_heading['tag'] . ' class="section-heading__title">';
	$section_heading_output .= $section_heading['title'];
	$section_heading_output .= '</'. $section_heading['tag'] . '>';

	if( $section_heading['desc'] ) :
		$section_heading_output .= '<p class="section-heading__desc">' . $section_heading['desc'] . '</p>';
	endif;

	$section_heading_output .= '</div>';

	echo $section_heading_output;
}

/**
 * Контент главной страницы
 */
function motordev_front_page_sections() {
	get_template_part( 'template-parts/sections/section-front', 'slider' );
	// get_template_part( 'template-parts/sections/section-front', 'services' );
	get_template_part( 'template-parts/sections/section-front', 'authors' );
}
add_action( 'front_page_content', 'motordev_front_page_sections', 5 );
