<?php
/**
 * The template for displaying all pages
 */
get_header();
?>
<main class="page-main">
	<?php
		while ( have_posts() ) :
			the_post();
							
			if ( is_front_page() ) {
				get_template_part( 'template-parts/content', 'front' );
			} else {
				get_template_part( 'template-parts/content', 'page' );
			}						
		endwhile;	
	?>
</main>

<?php get_footer(); ?>