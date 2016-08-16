<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\PAYPALRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class PAYPALProvider extends PaymentProvider{

	
	static protected $paymentType = "PAYPAL";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new PAYPALRequest();
	}	
}


