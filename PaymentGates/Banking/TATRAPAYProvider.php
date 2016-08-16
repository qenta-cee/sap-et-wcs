<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\TATRAPAYRequest;

class TATRAPAYProvider extends PaymentProvider {

	static protected $paymentType = "TATRAPAY";
	
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new TATRAPAYRequest();
	}
}