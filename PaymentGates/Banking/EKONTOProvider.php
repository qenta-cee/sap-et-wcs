<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\EKONTORequest;

class EKONTOProvider extends PaymentProvider {

	static protected $paymentType = "EKONTO";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new EKONTORequest();
	}
	
}