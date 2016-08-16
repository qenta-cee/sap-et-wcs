<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\SOFORTRequest;

class SOFORTProvider extends PaymentProvider {

	static protected $paymentType = "SOFORTUEBERWEISUNG";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new SOFORTRequest();
	}
	
}