<?php
class NikicarBotClass {
	const BOT_ACTION_APPROVE = 'approve';
	const BOT_ACTION_CLOSE = 'close';
	const BOT_ACTION_PAYED = 'payed';

	static public function sendSms($orderId){
		$order = NikicarOrderDb::getOrderById($orderId);

		if($order && isset($order['phone'])){
			self::checkSmsBalance();
			//SMS — 1521 символ латиницею або 661 символ кириличного тексту
			$text = get_option('sms_text');
			$text = str_replace('#orderSum#', NikicarOrderDb::getTotalPrice($order['userOrder']), $text);
			$text = str_replace('#orderNum#', $orderId, $text);
			$param = ['sms' => ['sender' => get_option('sms_service_sender'), 'text' => $text],  'recipients' => [$order['phone']]];
			self::sendSmsRequest($param);
			//self::sendTelegramMessage(json_encode($param));
		}
	}

	static public function checkSmsBalance(){
		$response = self::sendSmsRequest([], 'user/balance.json');
		$response = json_decode($response, true);

		if($response && isset($response['response_result']) && isset($response['response_result']['balance']) && $response['response_result']['balance'] <= get_option('sms_service_min_notify_balance')){
			self::sendTelegramRequest('sendMessage', ['chat_id' => get_option('telegram_channel_id'), 'text' => 'Увага! На рахунку залишилось '.$response['response_result']['balance'].' ГРН. Поповніть будь ласка рахунок: https://turbosms.ua/']);
		}
	}

	static public function sendTelegramMessage($text){
		$params = [
			'chat_id' => get_option('telegram_channel_id'),
			'text' => $text
		];

		self::sendTelegramRequest('sendMessage', $params);
	}

	static public function getWebhook(){
		return get_site_url().'/wp-json/nikicar-order/v1/bot';
	}

	static public function encrypt($text){
		return openssl_encrypt($text, 'AES-128-CTR', get_option('encrypt_key'), 0, '2980367891019544');
	}

	static public function decrypt($hash){
		return openssl_decrypt($hash, 'AES-128-CTR', get_option('encrypt_key'), 0, '2980367891019544');
	}

	static public function closeOrderMessage($orderId){
		$order = NikicarOrderDb::getOrderById($orderId);

		if($order && isset($order['tgMessageId'])){
			self::checkWebhook();
			self::sendTelegramRequest('editMessageReplyMarkup', [
				'chat_id' => get_option('telegram_channel_id'),
				'message_id' => $order['tgMessageId'],
				'reply_markup' =>  json_encode([
					'inline_keyboard' => [[
						['text' => 'На сайт', 'url' => get_site_url()]
					]]
				])
			]);

			$params = [
				'chat_id' => get_option('telegram_channel_id'),
				'text' => "Замовлення №{$order['id']} відмічено закритим.",
				'reply_to_message_id' => $order['tgMessageId']
			];

			self::sendTelegramRequest('sendMessage', $params);
		}
	}

	static public function paidOrderMessage($orderId){
		$order = NikicarOrderDb::getOrderById($orderId);

		if($order && isset($order['tgMessageId'])){
			self::checkWebhook();
			self::sendTelegramRequest('editMessageReplyMarkup', [
				'chat_id' => get_option('telegram_channel_id'),
				'message_id' => $order['tgMessageId'],
				'reply_markup' =>  json_encode([
					'inline_keyboard' => [[[
						'text' => 'Закрити замовлення',
						'callback_data' => self::encrypt(json_encode(['oderId' => $order['id'], 'action' => self::BOT_ACTION_CLOSE]))
					]]]
				])
			]);

			$params = [
				'chat_id' => get_option('telegram_channel_id'),
				'text' => "Замовлення №{$order['id']} відмічено оплаченим.",
				'reply_to_message_id' => $order['tgMessageId']
			];

			self::sendTelegramRequest('sendMessage', $params);
		}
	}

	static public function approveOrderMessage($orderId){
		$order = NikicarOrderDb::getOrderById($orderId);

		if($order && isset($order['tgMessageId'])){
			self::checkWebhook();
			self::sendTelegramRequest('editMessageReplyMarkup', [
				'chat_id' => get_option('telegram_channel_id'),
				'message_id' => $order['tgMessageId'],
				'reply_markup' =>  json_encode([
					'inline_keyboard' => [[
						[
							'text' => 'Помітити оплаченим',
							'callback_data' => self::encrypt(json_encode(['oderId' => $order['id'], 'action' => self::BOT_ACTION_PAYED]))
						],
						[
							'text' => 'Закрити замовлення',
							'callback_data' => self::encrypt(json_encode(['oderId' => $order['id'], 'action' => self::BOT_ACTION_CLOSE]))
						]
					]]
				])
			]);


			self::sendTelegramRequest('sendMessage', [
				'chat_id' => get_option('telegram_channel_id'),
				'text' => "Замовлення №{$order['id']} підтверджено.",
				'reply_to_message_id' => $order['tgMessageId']
			]);

			if(get_option('sms_enabled')){
				self::sendSms($order['id']);
			}
		}
	}

	static public function newOrderMessage($order){
		$userOrder = json_decode($order['userOrder'], true);
		$totalPrice = 0;

		foreach ($userOrder as $o){
			$o['variantDesc'] = isset($o['variantDesc'])?$o['variantDesc']:'-';
			$price = $o['souvenirPrice']*$o['count'];
			$totalPrice += $price;
			$caption = "Сувенір: <a href=\"".get_site_url()."/souvenir/{$o['slug']}\">{$o['souvenirTitle']}</a>\n";
			$caption .= "Варіант: {$o['variantDesc']}\n";
			$caption .= "Кількість: {$o['count']} ШТ\n";
			$caption .= "Вартість: {$o['souvenirPrice']} ГРН\n";
			$caption .= "Ціна: $price ГРН\n";

			self::sendTelegramRequest('sendPhoto', [
				'chat_id' => get_option('telegram_channel_id'),
				'parse_mode' => 'HTML',
				'photo' => isset($o['variantImageSrc'])&&$o['variantImageSrc']?$o['variantImageSrc']:$o['souvenirImageSrc'],
				'caption' => $caption
			]);
		}

		$text = "<b>Замовлення №:".$order['id']."</b>\n\n";
		$text .= "<b>Ім'я:</b> <i>" .$order['firstname'].' '.$order['lastname'].' '.$order['surname']."</i>\n";
		$text .= "<b>Телефон:</b> <i>" .$order['phone']."</i>\n";
		$text .= "<b>Область:</b> <i>" .$order['area']."</i>\n";
		$text .= "<b>Район:</b> <i>" .$order['region']."</i>\n";
		$text .= "<b>Населенний пункт:</b> <i>" .$order['settlements']."</i>\n";
		$text .= "<b>Відділеня НП:</b> <i>" .$order['warehouses']."</i>\n";
		$text .= "<b>IP:</b> <i>" .$order['userIp']."</i>\n";
		$text .= "<b>Коментар:</b> <i>" .$order['comment']."</i>\n\n";
		$text .= "<b>Загальна вартість:</b> <i>" .$totalPrice."</i> ГРН\n\n";

		$params = [
			'chat_id' => get_option('telegram_channel_id'),
			'parse_mode' => 'HTML',
			'text' => $text
		];

		$params['reply_markup'] =  json_encode([
			'inline_keyboard' => [[
				[
					'text' => 'Прийняти замовлення',
					'callback_data' => self::encrypt(json_encode(['oderId' => $order['id'], 'action' => self::BOT_ACTION_APPROVE]))
				],
				[
					'text' => 'Закрити замовлення',
					'callback_data' => self::encrypt(json_encode(['oderId' => $order['id'], 'action' => self::BOT_ACTION_CLOSE]))
				]
			]]
		]);

		self::checkWebhook();
		$response = self::sendTelegramRequest('sendMessage', $params);

		if($response){
			$response = json_decode($response, true);

			if(isset($response['ok']) && $response['ok']){
				NikicarOrderDb::addTelegramMessageId($order['id'], $response['result']['message_id']);
			}
		}
	}

	static public function checkWebhook(){
		$response = self::sendTelegramRequest('getWebhookInfo');

		if($response){
			$response = json_decode($response, true);

			if($response['result']['url'] != self::getWebhook()){
				self::sendTelegramRequest('deleteWebhook');
				self::sendTelegramRequest('setWebhook', ['url' => self::getWebhook()]);
			}
		}
	}

	static public function sendSmsRequest($param, $action = 'message/send.json'){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.turbosms.ua/'.$action.'?token='.get_option('sms_service_token'),
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ['Content-type: application/json'],
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS => json_encode($param),
			CURLOPT_POST => true,
			CURLOPT_CONNECTTIMEOUT => 100,
			CURLOPT_TIMEOUT => 200
		));

		$response = curl_exec($curl);
		return $response;
	}

	static public function sendTelegramRequest($action, $param = []){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.telegram.org/bot'.get_option('telegram_bot').'/'.$action,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ['Content-type: application/json'],
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS => json_encode($param),
			CURLOPT_POST => true,
			CURLOPT_CONNECTTIMEOUT => 100,
			CURLOPT_TIMEOUT => 200
		));

		$response = curl_exec($curl);
		return $response;
	}
}