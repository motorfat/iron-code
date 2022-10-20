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
		<?php get_template_part( 'template-parts/archive-page', 'heading' ); ?>
        <section class="entry-section">  
            <div class="content-box">
                <?php do_action( 'archive_page_before_posts' ); ?>
                <div class="archive-posts flex-grid">
                    <?php if ( have_posts() ) : ?>
                        <?php 
                            while ( have_posts() ) {
                                the_post();
                                ?>
                                <div class="archive-posts__article flex-grid__item">
                                    <?php get_template_part( 'template-parts/content', 'post-preview' ); ?>
                                </div>
                                <?php
                            }
                        ?>
                    <?php else: ?>
                        <p>Записей пока нет :(</p>
                    <?php endif; ?>	
                </div>

                <?php do_action( 'archive_page_after_posts' ); ?>
            </div>    
        </section>	
	</main>

<?php
get_footer();
