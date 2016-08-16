<?php

namespace WireCardSeamlessBundle\Wirecard\Request\DirectDebit;

use Psr\Log\LoggerInterface;
use WireCardSeamlessBundle\Wirecard\Request\DirectDebit\SEPARequest;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;

class SEPAHOBEXRequest extends SEPARequest {
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){	
	
	}	
}