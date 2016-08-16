<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\QUICKRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class QUICKProvider extends PaymentProvider{

	
	static protected $paymentType = "QUICK";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new QUICKRequest();
	}	
}


