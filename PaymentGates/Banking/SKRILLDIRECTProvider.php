<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\SKRILLDIRECTRequest;

class SKRILLDIRECTProvider extends PaymentProvider {

	static protected $paymentType = "SKRILLDIRECT";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new SKRILLDIRECTRequest();
	}
	
}