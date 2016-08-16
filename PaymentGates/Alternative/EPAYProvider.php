<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\EPAYRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class EPAYProvider extends PaymentProvider{

	
	static protected $paymentType = "EPAY_BG";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new EPAYRequest();
	}	
}


