<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\POLIRequest;

class POLIProvider extends PaymentProvider {

	static protected $paymentType = "POLI";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new POLIRequest();
	}
	
}