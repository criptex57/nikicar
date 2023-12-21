<?php
/*
Plugin Name: NIKI-CAR ЗАМОВЛЕННЯ
Plugin URI: https://niki-car.space/
Description: Реалізация замовлень на сайті.
Version: 1.0
Author: criptex57
Author URI: https://niki-car.space/
*/
require_once "includes/NikicarOrderDb.php";
require_once "includes/NikicarBot.php";
require_once "includes/NikicarApiRouts.php";
define( 'NIKICAR_PLUGIN_URL', plugins_url( '', __FILE__ ));

register_activation_hook(__FILE__, function() {
	NikicarOrderDb::checkTable();
});

add_action( 'admin_menu', function(){
	$countOrder = count(NikicarOrderDb::getOrders());
	add_menu_page(
		'Замовлення',
		$countOrder>0?"Замовлення <span class=\"awaiting-mod\">$countOrder</span>":'Замовлення',
		'edit_others_posts',
		'order_new',
		function(){
			$page = NikicarOrderDb::ORDER_STATUS_NEW;
			$orders = NikicarOrderDb::getOrders($page);
			require_once 'templates/admin.php';
		},
		'dashicons-money-alt',
		5
	);

	$countOrder = count(NikicarOrderDb::getOrders(NikicarOrderDb::ORDER_STATUS_APPROVE));
	add_submenu_page(
		'order_new',
		'Прийняті',
		$countOrder>0?"Прийняті <span class=\"awaiting-mod\">$countOrder</span>":'Прийняті',
		'manage_options',
		'order_approve',
		function(){
			$page = NikicarOrderDb::ORDER_STATUS_APPROVE;
			$orders = NikicarOrderDb::getOrders($page);
			require_once 'templates/admin.php';
		}
	);

	$countOrder = count(NikicarOrderDb::getOrders(NikicarOrderDb::ORDER_STATUS_PAID));
	add_submenu_page(
		'order_new',
		'Оплачені',
		$countOrder>0?"Оплачені <span class=\"awaiting-mod\">$countOrder</span>":'Оплачені',
		'manage_options',
		'order_paid',
		function(){
			$page = NikicarOrderDb::ORDER_STATUS_PAID;
			$orders = NikicarOrderDb::getOrders($page);
			require_once 'templates/admin.php';
		}
	);

	add_submenu_page(
		'order_new',
		'Архівні',
		'Архівні',
		'manage_options',
		'order_archive',
		function(){
			$page = NikicarOrderDb::ORDER_STATUS_CLOSE;
			$orders = NikicarOrderDb::getOrders($page);
			require_once 'templates/admin.php';
		}
	);

	add_submenu_page(
		'order_new',
		'Настройки',
		'Настройки',
		'manage_options',
		'order_settings',
		function(){
			require_once 'templates/settings.php';
		}
	);
});

add_action( 'admin_init', function(){
	register_setting( 'nikicar_plugin_settings', 'telegram_bot' );
	register_setting( 'nikicar_plugin_settings', 'telegram_channel_id' );
	register_setting( 'nikicar_plugin_settings', 'encrypt_key' );
	register_setting( 'nikicar_plugin_settings', 'sms_service_token' );
	register_setting( 'nikicar_plugin_settings', 'sms_service_sender' );
	register_setting( 'nikicar_plugin_settings', 'sms_service_min_notify_balance' );
	register_setting( 'nikicar_plugin_settings', 'sms_text' );
	register_setting( 'nikicar_plugin_settings', 'sms_enabled' );
});