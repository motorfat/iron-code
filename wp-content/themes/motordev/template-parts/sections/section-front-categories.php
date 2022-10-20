<section class="front-section front-section-categories">
    <div class="content-box">
        <?php motordev_section_heading( [ 'title' => 'Категории блога', 'desc' => 'Популярные и наиболее интересные разделы' ] ); ?>
        <div class="categories-grid flex-grid">
            <?php                
                $categories = get_terms( [
                    'taxonomy' => [ 'category' ],
                    // 'orderby'       => 'id',
                    // 'order'         => 'ASC',
                    'hide_empty'    => false,
                    'count'         => true,
                    'parent'        => 0,
                    'exclude'       => 1
                ] );
                
                foreach( $categories as $term ){
                    // print_r( $term );
                    ?>
                    <div class="categories-grid__col flex-grid__item">
                        <a href="<?php echo get_term_link( $term ); ?>" class="category-preview-link category-preview-link-id-<?php echo esc_attr( $term->slug ); ?> category-preview-link-<?php echo esc_attr( $term->slug ); ?>">
                            <figure class="category-preview-link__thumbnail">
                                <?php 
                                    echo wp_get_attachment_image( 
                                        carbon_get_term_meta( $term->term_id, 'term_thumb' ),
                                        'full',
                                        false,
                                        [ 'alt' => esc_attr( 'Перейти в категорию блога ' . $term->name ) ]
                                    );
                                ?>
                            </figure>
                            <div class="category-preview-link__info">
                                <div class="category-preview-link__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z"/>
                                    </svg>
                                </div>
                                <div class="category-preview-link__desc">
                                    <h5 class="category-preview-link__title">
                                        <?php echo $term->name; ?>
                                    </h5>
                                    <div class="category-preview-link__posts">
                                        <?php
                                            if ( $term->count > 0 ) {
                                                echo $term->count . ' записей';
                                            } else {
                                                echo 'Пока нет статей :(';
                                            }                                        
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</section>