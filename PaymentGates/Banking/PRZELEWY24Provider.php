<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\PRZELEWY24Request;

class PRZELEWY24Provider extends PaymentProvider {

	static protected $paymentType = "PRZELEWY24";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new PRZELEWY24Request();
	}
	
}