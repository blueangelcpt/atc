<?php
App::uses('HttpSocket', 'Network/Http');
class AtcComponent extends Component {
	public $settings = array(
		'TradeCode' => '',
		'TradePass' => '',
		'TerminalId' => ''
 	);
	private $socket = '';
	private $tag = 'atc';

	public function initialize(Controller $controller, $settings = array()) {
		$this->controller = $controller;
		$this->settings = array_merge($this->settings, $settings);
		$this->socket = new HttpSocket(array(
			'ssl_verify_peer' => false,
			'ssl_verify_host' => false,
			'ssl_verify_peer' => false
		));
	}

	public function purchase($meterNumber, $amount) {
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass'],
			'TerminalId' => $this->settings['TerminalId']
		);
		// $result = $this->socket->post('https://clientserv.net/ATCMerchants/api/Elec?MeterNumber=' . $meterNumber . '&Amount=' . ($amount / 100), json_encode($payload, true), $request);
		$this->log('ATC API purchase prerequest timestamp', $this->tag);
		$result = $this->socket->request(array(
			'method' => 'POST',
			'uri' => 'https://clientserv.net/ATCMerchants/api/Elec?MeterNumber=' . $meterNumber . '&Amount=' . ($amount / 100),
			'body' => json_encode($payload, true),
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		));
		$this->log('ATC API purchase request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API purchase response (N$' . ($amount / 100) . ' for ' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}

	public function validate($meterNumber) {
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass'],
			'TerminalId' => $this->settings['TerminalId']
		);
		// $result = $this->socket->post('https://clientserv.net/ATCMerchants/api/Elec?MeterNumber=' . $meterNumber, json_encode($payload, true), $request);
		$this->log('ATC API validation prerequest timestamp', $this->tag);
		$result = $this->socket->request(array(
			'method' => 'GET',
			'uri' => 'https://clientserv.net/ATCMerchants/api/Elec?MeterNumber=' . $meterNumber,
			'body' => json_encode($payload, true),
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		));
		$this->log('ATC API validation request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API validation response (' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}

	public function validatewater($meterNumber) {
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass'],
			'TerminalId' => $this->settings['TerminalId']
		);
		$this->log('ATC API validation prerequest timestamp', $this->tag);
		$result = $this->socket->request(array(
			'method' => 'GET',
			'uri' => 'https://clientserv.net/ATCMerchants/api/Water?MeterNumber=' . $meterNumber,
			'body' => json_encode($payload, true),
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		));
		$this->log('ATC API validation request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API validation response (' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}

	public function purchasewater($meterNumber, $amount) {
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass'],
			'TerminalId' => $this->settings['TerminalId']
		);
		$this->log('ATC API purchase prerequest timestamp', $this->tag);
		$result = $this->socket->request(array(
			'method' => 'POST',
			'uri' => 'https://clientserv.net/ATCMerchants/api/Water?MeterNumber=' . $meterNumber . '&Amount=' . ($amount / 100),
			'body' => json_encode($payload, true),
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		));
		$this->log('ATC API purchase request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API purchase response (N$' . ($amount / 100) . ' for ' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}
}