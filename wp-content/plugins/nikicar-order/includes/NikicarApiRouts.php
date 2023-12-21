<?php
add_action( 'rest_api_init', function(){
	register_rest_route( 'nikicar-order/v1', '/sms', [ // /wp-json/nikicar-order/v1/sms
		[
			'methods'  => 'GET',
			'callback' => function(WP_REST_Request $request){

			},
			'permission_callback' => '__return_true'
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/bot', [ // /wp-json/nikicar-bot/v1/test
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$params = json_decode(file_get_contents('php://input') , true);

				if(isset($params['callback_query'])){
					if(isset($params['callback_query']['data'])){
						$decryptData = NikicarBotClass::decrypt($params['callback_query']['data']);
						$decryptData = json_decode($decryptData, true);

						//NikicarBotClass::sendRequest('sendMessage', ['chat_id' => NikicarBotClass::CHANNEL_ID, 'text' => $decryptData['action']]); //todo this is bot webhook log

						if($decryptData){
							if(isset($decryptData['oderId'])){
								switch($decryptData['action']){
									case NikicarBotClass::BOT_ACTION_APPROVE:
										NikicarOrderDb::changeOrder($decryptData['oderId'], NikicarOrderDb::ORDER_STATUS_APPROVE);
										break;
									case NikicarBotClass::BOT_ACTION_PAYED:
										NikicarOrderDb::changeOrder($decryptData['oderId'], NikicarOrderDb::ORDER_STATUS_PAID);
										break;
									case NikicarBotClass::BOT_ACTION_CLOSE:
										NikicarOrderDb::changeOrder($decryptData['oderId'], NikicarOrderDb::ORDER_STATUS_CLOSE);
										break;
									default:
										fail('Invalid action.');
								}
							}
							else {
								fail('Invalid hash.');
							}
						}
						else {
							fail('Missing require param hash.');
						}
					}
				}
			},
			'permission_callback' => '__return_true'
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/addOrder', [ // /wp-json/nikicar-order/v1/addOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$id = NikicarOrderDb::addOrder(json_decode(file_get_contents('php://input'), true));
				NikicarBotClass::newOrderMessage(NikicarOrderDb::getOrderById($id));
				success();
			},
			'permission_callback' => '__return_true'
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/approveOrder', [ // /wp-json/nikicar-order/v1/approveOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$data = json_decode(file_get_contents('php://input'), true);
				if(isset($data['orderId'])){
					NikicarOrderDb::changeOrder($data['orderId'], NikicarOrderDb::ORDER_STATUS_APPROVE);
					success($data);
				}
				else {
					fail('Missing require param "orderId".');
				}
			},
			'permission_callback' => function($request){
				return in_array('administrator', wp_get_current_user()->roles);
			}
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/paidOrder', [ // /wp-json/nikicar-order/v1/paidOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$data = json_decode(file_get_contents('php://input'), true);
				if(isset($data['orderId'])){
					NikicarOrderDb::changeOrder($data['orderId'], NikicarOrderDb::ORDER_STATUS_PAID);

					success($data);
				}
				else {
					fail('Missing require param "orderId".');
				}
			},
			'permission_callback' => function($request){
				return in_array('administrator', wp_get_current_user()->roles);
			}
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/closeOrder', [ // /wp-json/nikicar-order/v1/closeOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$data = json_decode(file_get_contents('php://input'), true);
				if(isset($data['orderId'])){
					NikicarOrderDb::changeOrder($data['orderId'], NikicarOrderDb::ORDER_STATUS_CLOSE);
					success($data);
				}
				else {
					fail('Missing require param "orderId".');
				}
			},
			'permission_callback' => function($request){
				return in_array('administrator', wp_get_current_user()->roles);
			}
		]
	]);
});

/**
 * @param $data array
 */
function success($data = []){
	echo json_encode(['success' => true, 'data' => $data]);
}

/**
 * @param $error string
 */
function fail($error = ''){
	echo json_encode(['success' => false, 'error' => $error]);
}