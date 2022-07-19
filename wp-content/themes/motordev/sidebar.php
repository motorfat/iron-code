<aside id="sidebar" class="page-sidebar">
	<div class="page-sidebar__inner">
        <div class="page-sidebar__logo">
            <a href="/" class="logo-box">
                <img src="<?php echo get_theme_file_uri( 'assets/img/logo.png' ); ?>" alt="" class="logo-box__img">
                <div class="logo-box__text">
                    <p><strong>Ирина</strong></p>
                    <p>Фотограф в Крыму</p>
                </div>
            </a>
        </div>
        <div class="page-sidebar__nav">
            <?php            
                wp_nav_menu(
                    array(
                        'theme_location'  => 'sidebar-menu',
                        'menu_id'         => 'sidebar-menu',
                        'container'       => 'nav',
                        'container_class' => 'sidebar-navbar',
                        'menu_class'      => 'sidebar-navbar__list'
                    )
                );
            ?>
        </div>
        <div class="page-sidebar__bottom">
            
        </div>
	</div>
</aside>