<section class="front-section front-section-latest">
    <div class="content-box">
        <?php motordev_section_heading( [ 'title' => 'Свежие записи о WordPress', 'desc' => 'Наиболее актуальные статьи про самую популярную CMS WordPress' ] ); ?>
        <div class="latest-posts flex-grid">
            <?php
                $latest_wp = get_posts( array(
                    'numberposts' => 8,
                    'category'    => 4,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'post_type'   => 'post',
                ) );
                
                foreach( $latest_wp as $post ){
                    setup_postdata( $post );
                    ?>
                    <div class="latest-posts__col flex-grid__item">
                        <?php get_template_part( 'template-parts/content', 'post-card' ); ?>
                    </div>
                    <?php
                }
                
                wp_reset_postdata();
            ?>
        </div>
    </div>
</section>