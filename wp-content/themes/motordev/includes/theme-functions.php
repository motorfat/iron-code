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
	get_template_part( 'template-parts/sections/section-front', 'latest-wp' );
	get_template_part( 'template-parts/sections/section-front', 'categories' );
	get_template_part( 'template-parts/sections/section-front', 'authors' );	
}
add_action( 'front_page_content', 'motordev_front_page_sections', 5 );


/**
 *  Карточка пользователя
 */
function motordev_user_card( $author_id ){
	if( ! $author_id ) return;

	$author = get_user_by( 'id', (int) $author_id );

	?>
	<div class="author-page-info">
        <figure class="author-page-info__photo">
            <img src="<?php echo get_avatar_url( $author->ID, [ 'size' => 176 ] ); ?>" alt="" class="post-author-card__avatar">
        </figure>
        <div class="author-page-info__content">
            <h1 class="author-page-info__name">
                Автор <?php echo $author->display_name; ?>
            </h1>
            <div class="author-page-info__desc">
                <?php echo $author->description; ?>
            </div>
			<button class="author-page-info__request icon-text-btn" type="button" data-author-id="<?php echo $author_id; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-text-btn__icon">
					<path fill="currentColor" d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-144c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/>
				</svg>
				<span class="icon-text-btn__label">Связаться с автором</span>
			</button>
            <div class="author-page__socials">
                <nav class="social-links">
                    <a href="#" class="social-link social-link--telegram" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
							<path fill="currentColor" d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/>
						</svg>
                    </a>
					<a href="#" class="social-link social-link--youtube" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
							<path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/>
						</svg>
					</a>
					<a href="#" class="social-link social-link--mail" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path fill="currentColor" d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM48 128V150.1L220.5 291.7C241.1 308.7 270.9 308.7 291.5 291.7L464 150.1V127.1C464 119.2 456.8 111.1 448 111.1H64C55.16 111.1 48 119.2 48 127.1L48 128zM48 212.2V384C48 392.8 55.16 400 64 400H448C456.8 400 464 392.8 464 384V212.2L322 328.8C283.6 360.3 228.4 360.3 189.1 328.8L48 212.2z"/>
						</svg>
					</a>
                </nav>
            </div>
        </div>
    </div>
	<?php
}


/**
 * Страница архивов
 */
function motordev_archive_nav() {
	?>
	<div class="posts-archive-topbar">
		<nav class="posts-archive-topbar__filter articles-filter">
			<button class="articles-filter__btn articles-filter__btn--active btn" type="button">Все записи</button>
			<button class="articles-filter__btn btn" type="button">Рекомендуемые</button>
		</nav>
		<div class="posts-archive-topbar__search">
			<?php echo get_search_form(); ?>
		</div>
	</div>
	<?php
}
add_action( 'archive_page_before_posts', 'motordev_archive_nav', 5 );