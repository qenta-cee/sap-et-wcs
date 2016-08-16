<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Account
 * @webserializable
 */
class Account
{
    /**
     * name of account
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "account.name.length.max")
     */
    public $name;

    /**
     * account number
     * @var string
     *
     * @SapAssert\Length(max = 30, maxMessage = "account.number.length.max")
     */
    public $number;

    /**
     * cost unit
     * @var string
     *
     * @SapAssert\Length(max = 30, maxMessage = "account.unit.length.max")
     */
    public $unit;

    /**
     * cost centre
     * @var string
     *
     * @SapAssert\Length(max = 30, maxMessage = "account.centre.length.max")
     */
    public $centre;
} 
