<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\INVOICERequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class INVOICEProvider extends PaymentProvider{

	
	static protected $paymentType = "INVOICE";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new INVOICERequest();
	}	
}


