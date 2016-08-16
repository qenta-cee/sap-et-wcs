<?php

namespace WireCardSeamlessBundle\Wirecard\Request\DirectDebit;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

/**
 * Abstract class for SEPA (Single Euro Payments Area) Direct Debit.
 * To carry out recurring payments the request parameter transactionIdentifier is used.
 * @author clic
 *
 */
abstract class SEPARequest extends WCBasicPaymentRequest{	
	
	
	/**
	 * Identifier of displayed mandate. 
	 * Within fingerprint: Required if used.
	 * @var string Alphanumeric with a variable length of up to 35.
	 */
	protected $mandateId;
			 
	/**
	 * Date when the mandate was signed by the consumer. 
	 * Within fingerprint: Required if used.
	 * @var string Date as �DD.MM.YYYY�
	 */
	protected $mandateSignatureDate;
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){
		
	}
		
	
	public function getMandateId() {
		return $this->mandateId;
	}
	public function setMandateId($mandateId) {
		$this->mandateId = $mandateId;
		return $this;
	}
	public function getMandateSignatureDate() {
		return $this->mandateSignatureDate;
	}
	public function setMandateSignatureDate($mandateSignatureDate) {
		$this->mandateSignatureDate = $mandateSignatureDate;
		return $this;
	}
			
	
	
}