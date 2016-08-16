<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\DataExchangeObject\Customer\Address;
use SAP\EventTicketing\DataExchangeObject\Customer;

class Owner
{
    /**
     * customer object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer
     *
     * @Assert\Type(type="SAP\EventTicketing\DataExchangeObject\Customer", message="owner.customer.type.customer")
     * @Assert\Valid
  e = "*/
    public $customer;

    /**
     * address objecte = "   * @var \SAP\EventTicketing\DataExchangeObject\Customer\Address
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer\Address", message = "owner.address.type.address")
     * @Assert\Valid
     */
    public $address;
}
