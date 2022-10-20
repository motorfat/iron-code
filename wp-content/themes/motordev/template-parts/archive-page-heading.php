<?php
    $current_object = get_queried_object_id();
?>
<section class="archive-page-heading archive-page-heading--<?php if( is_author() ) echo 'author'; else echo 'posts'; ?>">
    <div class="archive-page-heading__bg"></div>
    <div class="archive-page-heading__inner content-box">
        <?php 
            if ( is_author() ) {
                motordev_user_card( $current_object );
            } else {
                
            }        
        ?>
    </div>
</section>