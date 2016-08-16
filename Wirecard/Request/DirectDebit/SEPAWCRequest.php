<?php

namespace WireCardSeamlessBundle\Wirecard\Request\DirectDebit;

use Psr\Log\LoggerInterface;
use WireCardSeamlessBundle\Wirecard\Request\DirectDebit\SEPARequest;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;

class SEPAWCRequest extends SEPARequest {

	
	
	/**
	 * Unique identifier of creditor (merchant).
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 35.
	 */
	protected $creditorId;
	
	
	
	/**
	 * Date when payment is debited from consumer�s bank account.
	 * The due date is calculated by merchant or, if the field is left empty, Wirecard will automatically calculate the due date.
	 * Within fingerprint: Required if used
	 * @var string Date as �DD.MM.YYYY�
	 */
	protected $dueDate;
	
		
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){
	
	}
		
	public function getCreditorId() {
		return $this->creditorId;
	}
	public function setCreditorId( $creditorId) {
		$this->creditorId = $creditorId;
		return $this;
	}
	public function getDueDate() {
		return $this->dueDate;
	}
	public function setDueDate( $dueDate) {
		$this->dueDate = $dueDate;
		return $this;
	}
	
	
	
}