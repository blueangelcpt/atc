<?php
App::uses('HttpSocket', 'Network/Http');
class AtcComponent extends Component {
	public $settings = array(
		'url' => 'https://clientserv.net',
		'TradeCode' => '',
		'TradePass' => '',
		'TerminalId' => ''
 	);
	private $socket = '';
	private $tag = 'atc';

	public function initialize(Controller $controller, $settings = array()) {
		$this->controller = $controller;
		$this->settings = array_merge($this->settings, $settings);
		$this->socket = new HttpSocket();
	}

	public function purchase($meterNumber, $amount) {
		$request = array(
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		);
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass']
		);
		$url = 'api/Elec?MeterNumber=' . $meterNumber . '&Amount=' . ($amount / 100);
		$result = $this->socket->post($this->settings['url'] . $url, $payload, $request);
		$this->log('ATC API purchase request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API purchase response (N$' . ($amount / 100) . ' for ' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}

	public function validate($meterNumber) {
		$request = array(
			'header' => array(
				'Content-Type' => 'application/json',
				'Connection' => 'keep-alive',
				'Cache-Control' => 'no-cache'
			)
		);
		$payload = array(
			'TradeCode' => $this->settings['TradeCode'],
			'TradePass' => $this->settings['TradePass']
		);
		$url = 'api/Elec?MeterNumber=' . $meterNumber;
		$result = $this->socket->post($this->settings['url'] . $url, $payload, $request);
		$this->log('ATC API validation request: ' . $this->socket->request['raw'], $this->tag);
		$this->log('ATC API validation response (' . $meterNumber . '): ' . $result, $this->tag);
		return json_decode($result->body, true);
	}
}