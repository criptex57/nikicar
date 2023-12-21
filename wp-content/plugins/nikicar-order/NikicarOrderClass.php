<?php
class NikicarOrder {
	const ORDER_STATUS_NEW = 0;
	const ORDER_STATUS_APPROVE = 1;
	const ORDER_STATUS_CLOSE = 2;

	static public $table = 'nikicar_orders';

	static public function getWpdb(){
		global $wpdb;
		return $wpdb;
	}

	static public function getTableName(){
		return self::getWpdb()->get_blog_prefix() . self::$table;
	}

	static public function getOrders($status = self::ORDER_STATUS_NEW){
		$t = self::getTableName();
		$result = self::getWpdb()->get_results( " SELECT * FROM {$t} WHERE status =  ".$status, ARRAY_A);

		return $result;
	}

	static public function getOrderById($id){
		$t = self::getTableName();
		$result = self::getWpdb()->get_results( " SELECT * FROM {$t} WHERE id =  ".$id, ARRAY_A);
		return isset($result[0])?$result[0]:[];
	}

	static public function changeOrder($orderId, $status){
		$t = self::getTableName();
		self::getWpdb()->get_results("UPDATE `{$t}` SET `status` = {$status} WHERE `{$t}`.`id` = {$orderId};", ARRAY_A);
	}

	static public function addOrder($data){
		$phone = isset($data['phone'])?$data['phone']:'';
		$comment = isset($data['comment'])?$data['comment']:'';
		$lastname = isset($data['lastname'])?$data['lastname']:'';
		$firstname = isset($data['firstname'])?$data['firstname']:'';
		$surname = isset($data['surname'])?$data['surname']:'';
		$area = isset($data['area'])?$data['area']:'';
		$region = isset($data['region'])?$data['region']:'';
		$settlements = isset($data['settlements'])?$data['settlements']:'';
		$warehouses = isset($data['warehouses'])?$data['warehouses']:'';
		$price = isset($data['price'])?$data['price']:'';
		$order = isset($data['order'])?json_encode($data['order'], JSON_UNESCAPED_UNICODE):'';

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		self::getWpdb()->insert( self::getTableName(), [
			'time' => current_time('mysql'),
			'status' => self::ORDER_STATUS_NEW,
			'comment' => $comment,
			'lastname' => $lastname,
			'firstname' => $firstname,
			'surname' => $surname,
			'area' => $area,
			'region' => $region,
			'settlements' => $settlements,
			'warehouses' => $warehouses,
			'price' => $price,
			'userOrder' => $order,
			'userIp' => $ip,
			'phone' => $phone,
		]);

		return self::getWpdb()->insert_id;
	}

	static public function checkTable(){
		if(self::getWpdb()->get_var("show tables like '".self::getTableName()."'") != self::getTableName()) {
			$tn = self::getTableName();

			$sql = "CREATE TABLE {$tn} (
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
		      userIp tinytext NOT NULL,
			  status int(1) NOT NULL,
			  UNIQUE KEY id (id)
			);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
}
