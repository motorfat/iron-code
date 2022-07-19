<?php
use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function motordev_custom_fields() {
	// Container::make( 'post_meta', __( 'Промо-секция' ) )
	// 	->where( 'post_id', '=', get_option( 'page_on_front' ) )
	// 	->set_classes('motordev-post-meta-fields')
	// 	->add_fields(array(
	// 		Field::make( 'rich_text', 'promo_title', __( 'Заголовок' ) ),
	// 		Field::make( 'rich_text', 'promo_desc', __( 'Описание' ) ),
	// 		Field::make( 'image', 'promo_img_hero', __( 'Изображение героя' ) ),
	// 	));
}
add_action( 'carbon_fields_register_fields', 'motordev_custom_fields' );