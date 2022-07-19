<?php
/**
 * The main template file
 */
get_header();
?>
	<main id="primary" class="site-main">
		<?php
			if ( have_posts() ) :

				single_post_title();

				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				endwhile;
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
		?>
	</main>
<?php
get_sidebar();
get_footer();
