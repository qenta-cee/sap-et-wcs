<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\INVOICEB2BRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class INVOICEB2BProvider extends PaymentProvider{

	
	static protected $paymentType = "INVOICEB2B";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new INVOICEB2BRequest();
	}	
}


