<?php
add_action( 'rest_api_init', function(){
	register_rest_route( 'nikicar-bot/v1', '/test', [ // /wp-json/nikicar-bot/v1/test
		[
			'methods'  => 'GET',
			'callback' => function(WP_REST_Request $request){
				print_r(NikicarBotClass::decrypt($_GET['hash']));
			},
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/addOrder', [ // /wp-json/nikicar-order/v1/addOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$id = NikicarOrder::addOrder(json_decode(file_get_contents('php://input'), true));
				NikicarBotClass::approveOrderMessage(NikicarOrder::getOrderById($id));
				success();
			},
		]
	]);

	register_rest_route( 'nikicar-order/v1', '/approveOrder', [ // /wp-json/nikicar-order/v1/approveOrder
		[
			'methods'  => 'POST',
			'callback' => function(WP_REST_Request $request){
				$data = json_decode(file_get_contents('php://input'), true);
				if(isset($data['orderId'])){
					NikicarOrder::changeOrder($data['orderId'], NikicarOrder::ORDER_STATUS_APPROVE);
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
					NikicarOrder::changeOrder($data['orderId'], NikicarOrder::ORDER_STATUS_CLOSE);
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