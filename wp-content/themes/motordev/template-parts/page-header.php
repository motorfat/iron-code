<header class="page-header">
    <div class="page-header__inner content-box">
        <a href="<?php echo get_site_url(); ?>" class="page-header__logo">
            <img src="<?php echo get_theme_file_uri( 'assets/img/logo-2-w.png' ); ?>" alt="">
        </a>
        <div class="page-header__nav">
            <nav class="head-nav">
                <ul class="head-nav__list">
                    <li class="current"><a href="#">Главная</a></li>
                    <li><a href="#">Блог</a></li>
                    <li><a href="#">Услуги</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
            </nav>
        </div>
        <div class="page-header__actions">
            <a href="/wp-admin" class="page-header__user-login btn">
                <?php
                    if( is_user_logged_in() ){ 
                        echo 'Аккаунт';
                    } else { 
                        echo 'Войти'; 
                    }
                ?>
            </a>
        </div>
    </div>
</header>