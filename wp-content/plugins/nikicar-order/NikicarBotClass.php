<?php
class NikicarBotClass {
	const BOT_TOKEN = '6719470784:AAFclWyyGgXmpt_KZgEV0OqaYSeUBrK8I_4';
	const CHANNEL_ID = '-1002037180621';
	const ENCRYPT_KEY = 'A0MzVCTSuA4CxWtegj+6iHrtewSx7XKl6qcdTA0M';
	const IV = '2980367891019544';
	const CIPHERING = 'AES-128-CTR';

	static public function encrypt($text){
		return openssl_encrypt($text, self::CIPHERING, self::ENCRYPT_KEY, 0, self::IV);
	}

	static public function decrypt($hash){
		return openssl_decrypt($hash, self::CIPHERING, self::ENCRYPT_KEY, 0, self::IV);
	}

	static public function approveOrderMessage($order){
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

			self::sendRequest('sendPhoto', [
				'chat_id' => self::CHANNEL_ID,
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
			'chat_id' => self::CHANNEL_ID,
			'parse_mode' => 'HTML',
			'text' => $text
		];

		$params['reply_markup'] =  json_encode([
			'inline_keyboard' => [[
				//['text' => 'Прийняти', 'url' => get_site_url().'/wp-json/nikicar-order/v1/approveFromTg?hash='.self::encrypt($order['id'])]
				['text' => 'Прийняти', 'url' => get_site_url().'/wp-json/nikicar-bot/v1/test?hash='.self::encrypt(json_encode(['oderId' => $order['id']]) )]
			]]
		]);

		$response = self::sendRequest('sendMessage', $params);

		if($response){
			$response = json_decode($response, true);

			if(isset($response['ok']) && $response['ok']){
				$response['result']['']
			}
		}
		print_r($response);
	}

	static public function sendRequest($action, $param = []){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.telegram.org/bot'.self::BOT_TOKEN.'/'.$action,
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