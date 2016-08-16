<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Alternative;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class EPAYRequest extends WCBasicPaymentRequest{
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){	
	
	}	
}