<?php
/*
Plugin Name: NIKI-CAR ЗАМОВЛЕННЯ
Plugin URI: https://niki-car.space/
Description: Реалізация замовлень на сайті.
Version: 1.0
Author: criptex57
Author URI: https://niki-car.space/
*/
require_once "nikicar-order-func.php";
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
global $wpdb;
$order = new NikicarOrder($wpdb);
add_action( 'admin_menu', function(){
	global $wpdb;
	$countOrder = NikicarOrder::getNewOrderCount($wpdb);
	add_menu_page(
		'Замовлення',
		$countOrder>0?"Замовлення <span class=\"awaiting-mod\">$countOrder</span>":'Замовлення',
		'edit_others_posts',
		'order_settings',
		'order_settings',
		'dashicons-money-alt',
		5
	);
});

add_action( 'admin_menu', function(){
	add_submenu_page(
		'order_settings',
		'Настройки', // тайтл страницы
		'Настройки', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'order_settings_sub', // ярлык страницы
		'order_settings_sub' // функция, которая выводит содержимое страницы
	);
}, 25 );

register_activation_hook(__FILE__, function() {
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . NikicarOrder::$table;

	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE {$table_name} (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time DATETIME NOT NULL,
		  firstname tinytext NOT NULL,
		  lastname tinytext NOT NULL,
		  surname tinytext NOT NULL,
		  phone tinytext NOT NULL,
		  area tinytext NOT NULL,
		  region tinytext NOT NULL,
		  settlements tinytext NOT NULL,
		  warehouses tinytext NOT NULL,
		  price tinytext NOT NULL,
		  userOrder text NOT NULL,
		  comment text NOT NULL,
		  order text NOT NULL,
	      userIp tinytext NOT NULL,
		  status int(1) NOT NULL,
		  UNIQUE KEY id (id)
		);";

		dbDelta($sql);
	}
});

function order_settings_sub(){
	echo 'У розробці';
}

function order_settings(){
	echo 'У розробці';
}

add_action( 'rest_api_init', function(){
	register_rest_route( 'nikicar-order/v1', '/addOrder', array( //https://niki-car.space/wp-json/nikicar-order/v1/addOrder
		array(
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$params = json_decode(file_get_contents('php://input'), true);
				global $wpdb;
				$order = new NikicarOrder($wpdb);
				$order->addOrder($params);
				echo '{"success":"true", "data":[1,2,3]}';
			},
		),
//		array(
//			'methods'  => 'POST',
//			'callback' => 'my_awesome_func_two',
//			'args'     => array(
//				'arg_str' => array(
//					'type'     => 'string', // значение параметра должно быть строкой
//					'required' => true,     // параметр обязательный
//				),
//				'arg_int' => array(
//					'type'    => 'integer', // значение параметра должно быть числом
//					'default' => 10,        // значение по умолчанию = 10
//				),
//			),
//			'permission_callback' => function( $request ){
//				// только авторизованный юзер имеет доступ к эндпоинту
//				return is_user_logged_in();
//			},
//			// или в данном случае можно записать проще
//			'permission_callback' => 'is_user_logged_in',
//		)
	) );

} );