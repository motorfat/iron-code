<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function motordev_theme_options() {
    Container::make( 'theme_options', 'Дополнительно' )
		->add_tab( 'Контакты и общая информация', array(
			Field::make( 'image', 'site_logo', __( 'Лого' ) ),			
			Field::make( 'textarea', 'site_slogan', __( 'Название организации' ) ),
			Field::make( 'text', 'site_mail', __( 'E-mail' ) ),
			Field::make( 'text', 'site_adress', __( 'Адрес' ) ),
			Field::make( 'text', 'site_phone', __( 'Телефон' ) ),
			Field::make( 'text', 'site_schedule', __( 'Время работы' ) ),
		) )
		->add_tab( 'SEO', array(
			Field::make( "header_scripts", "header_analytics", 'Код счётчика Яндекс | Google' )
		) );
}
add_action( 'carbon_fields_register_fields', 'motordev_theme_options' );