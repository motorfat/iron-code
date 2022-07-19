<?php
get_header();
?>
    <main class="page-main">
        <?php get_template_part( 'template-parts/breadcrumbs' ); ?>
        <section class="single-page-section">
            <div class="content-box">
                <?php
                    while ( have_posts() ) :
                        the_post();
                        if ( get_post_type() == 'product') {
                            get_template_part( 'template-parts/product', 'card' );
                        } else {
                            get_template_part( 'template-parts/content' );
                        }
                    endwhile;
                ?>
            </div>
        </section>
    </main>
<?php
get_footer();
