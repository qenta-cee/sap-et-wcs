<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\EPSRequest;

class EPSProvider extends PaymentProvider {

	static protected $paymentType = "EPS";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new EPSRequest();
	}
	
}