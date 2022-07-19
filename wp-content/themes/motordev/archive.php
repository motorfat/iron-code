<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motorfat_WP
 */

get_header();
?>

	<main class="page-main page-main-archive">
		<?php do_action( 'archive_page' ); ?>
	</main>

<?php
get_footer();
