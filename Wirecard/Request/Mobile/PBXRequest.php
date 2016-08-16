<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Mobile;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class PBXRequest extends WCBasicPaymentRequest{
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){	
	
	}	
}