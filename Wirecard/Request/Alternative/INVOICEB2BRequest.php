<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Alternative;

use Psr\Log\LoggerInterface;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\INVOICERequest;

class INVOICEB2BRequest extends INVOICERequest {
	
	
	//	REQUIRED PARAMETERS
	
	/**
	 * Name of company.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of 1 to 100
	 */
	protected $companyName;
	
	
	//	OPTIONAL PARAMETERS
	
	/**
	 * VAT ID of company.
	 * @var string Alphanumeric with a variable length of 0 to 50
	 */
	protected $companyVatId;	
	
	/**
	 * Trade register number of company.
	 * @var string Alphanumeric with a variable length of 0 to 50
	 */
	protected $companyTradeRegisterNumber;	
	
	/**
	 * Additional or alternative registry number of company.
	 * @var string Alphanumeric with a variable length of 0 to 50
	 */
	protected $companyRegistryNumber;
	
	
	public function getCompanyName() {
		return $this->companyName;
	}
	public function setCompanyName( $companyName) {
		$this->companyName = $companyName;
		return $this;
	}
	public function getCompanyVatId() {
		return $this->companyVatId;
	}
	public function setCompanyVatId( $companyVatId) {
		$this->companyVatId = $companyVatId;
		return $this;
	}
	public function getCompanyTradeRegisterNumber() {
		return $this->companyTradeRegisterNumber;
	}
	public function setCompanyTradeRegisterNumber( $companyTradeRegisterNumber) {
		$this->companyTradeRegisterNumber = $companyTradeRegisterNumber;
		return $this;
	}
	public function getCompanyRegistryNumber() {
		return $this->companyRegistryNumber;
	}
	public function setCompanyRegistryNumber( $companyRegistryNumber) {
		$this->companyRegistryNumber = $companyRegistryNumber;
		return $this;
	}
	
	
	
	
	
}