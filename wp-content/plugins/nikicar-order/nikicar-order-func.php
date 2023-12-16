<?php
//{
//	"order": {
//		"115-1": {
//			"souvenirId": "115",
//            "variantId": "1",
//            "slug": "%d1%81%d1%83%d0%b2%d0%b5%d0%bd%d1%96%d1%80%d0%b8",
//            "souvenirTitle": "Сувеніри (доп)",
//            "souvenirImageSrc": "https://niki-car.space/wp-content/uploads/2023/12/souvenir_2-1.png",
//            "souvenirPrice": "500",
//            "variantImageSrc": "https://niki-car.space/wp-content/uploads/2023/12/souvenir_4.png",
//            "variantDesc": "Варіант 2",
//            "count": 1
//        }
//    },
//    "phone": "380970496247",
//    "comment": "gfdb",
//    "lastname": "test",
//    "firstname": "test",
//    "surname": "test",
//    "area": "Кіровоградська",
//    "region": "Кропивницький",
//    "settlements": "Кропивницький",
//    "warehouses": "Відділення №6 (до 30 кг на одне місце): вул. Короленка, 32а",
//    "price": '500'
//}

class NikicarOrder {
	private $tableName;
	private $wpdb;
	const ORDER_STATUS_NEW = 0;
	const ORDER_STATUS_APPROVE = 1;
	const ORDER_STATUS_CLOSE = 2;
	static public $table = 'nikicar_orders';

	public function __construct($wpdb){
		$this->tableName = $wpdb->get_blog_prefix().self::$table;
		$this->wpdb = $wpdb;
	}

	static public function getNewOrderCount($wpdb){
		$result = [];
		$t = $wpdb->get_blog_prefix() . self::$table;

		if($wpdb->get_var("show tables like '$t'") == $t){
			$result = $wpdb->get_results( " SELECT * FROM {$t} WHERE 'status' =  ".self::ORDER_STATUS_NEW);
		}

		return count($result);
	}
	
	public function addOrder($data){
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

		$this->wpdb->insert( $this->tableName, [
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
	}
}
