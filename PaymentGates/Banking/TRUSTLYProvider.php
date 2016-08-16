<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\TRUSTLYRequest;

class TRUSTLYProvider extends PaymentProvider {

	
	static protected $paymentType = "TRUSTLY";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new TRUSTLYRequest();
	}
}