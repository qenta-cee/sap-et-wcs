<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\MISTERCASHRequest;

class BCTMISTERCASHProvider extends PaymentProvider {

	static protected $paymentType = "BANCONTACT_MISTERCASH";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new MISTERCASHRequest();
	}
	
}