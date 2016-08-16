<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class Duplicate
{
    /**
     * customer identifier
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "duplicate.customerIdentifier.length.max")
     */
    public $customerIdentifier;

    /**
     * number of customer
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "duplicate.customerNumber.length.max")
     */
    public $customerNumber;

    function __construct($customerIdentifier, $customerNumber)
    {
        $this->customerIdentifier = $customerIdentifier;
        $this->customerNumber = $customerNumber;
    }
}
