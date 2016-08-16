<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\INSTALLMENTRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class INSTALLMENTProvider extends PaymentProvider{

	
	static protected $paymentType = "INSTALLMENT";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new INSTALLMENTRequest();
	}	
	
}


