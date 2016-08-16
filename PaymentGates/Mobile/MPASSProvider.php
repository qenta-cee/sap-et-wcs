<?php

namespace WireCardSeamlessBundle\PaymentGates\Mobile;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Mobile\MPASSRequest;

class MPASSProvider extends PaymentProvider {

	static protected $paymentType = "MPASS";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new MPASSRequest();
	}
	
}