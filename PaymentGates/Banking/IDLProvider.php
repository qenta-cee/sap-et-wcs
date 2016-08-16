<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\IDEALRequest;

class IDLProvider extends PaymentProvider {

	static protected $paymentType = "IDL";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new IDEALRequest();
	}
	
}