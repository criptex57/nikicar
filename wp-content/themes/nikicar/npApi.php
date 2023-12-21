<?php //Template Name: Нова пошта API
$np = new NovaPoshta('10279ba4a9f59b792aafc9959e8466d8');

if(isset($_GET['area'])){
	echo json_encode(json_decode($np->getSettlementAreas()), JSON_UNESCAPED_UNICODE);
}
elseif(isset($_GET['region']) && $_GET['region']){
	echo json_encode(json_decode($np->getSettlementCountryRegion($_GET['region'])), JSON_UNESCAPED_UNICODE);
}
elseif(isset($_GET['settlements']) && $_GET['settlements']){
	echo json_encode(json_decode($np->getSettlements($_GET['settlements'])), JSON_UNESCAPED_UNICODE);
}
elseif(isset($_GET['settlementsCity']) && $_GET['settlementsCity']){
	echo json_encode(json_decode($np->getSettlements($_GET['settlementsCity'], true)), JSON_UNESCAPED_UNICODE);
}
elseif(isset($_GET['warehouses']) && $_GET['warehouses']){
	echo json_encode(json_decode($np->getWarehouses($_GET['warehouses'])), JSON_UNESCAPED_UNICODE);
}
else {
	header("Location: /");
}

class NovaPoshta {
	private $apiKey;
	private $host = 'https://api.novaposhta.ua/v2.0/json/';

	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function getSettlementAreas(){
		return $this->sendRequest(__FUNCTION__);
	}

	public function getSettlementCountryRegion($ref){
		return $this->sendRequest(__FUNCTION__, ['methodProperties' => ['AreaRef' => $ref]]);
	}

	public function getSettlements($ref, $city = false){
		$params = ['RegionRef' => $ref];

		if($city){
			$params = ['Ref' => $ref];
		}

		return $this->sendRequest(__FUNCTION__, ['methodProperties' => $params]);
	}

	public function getWarehouses($ref){
		return $this->sendRequest(__FUNCTION__, ['methodProperties' => ['SettlementRef' => $ref]]);
	}

	private function sendRequest($calledMethod, $param = [], $modelName = 'Address'){
		$param['apiKey'] = $this->apiKey;
		$param['modelName'] = $modelName;
		$param['calledMethod'] = $calledMethod;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->host,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ["Content-type: application/json"],
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS => json_encode($param),
			CURLOPT_POST => true,
			CURLOPT_CONNECTTIMEOUT => 100,
			CURLOPT_TIMEOUT => 200
		));

		return curl_exec($curl);
	}
}