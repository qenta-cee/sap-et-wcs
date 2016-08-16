<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * price and currency
 * @webserializable
 */
class Price
{
    /**
     * value
     * @var double
     *
     * @Assert\NotBlank(message = "price.value.notBlank")
     * @Assert\Type(type = "double", message = "price.value.type.double")
     */
    public $value;

    /**
     * 3-letter ISO 4217 currency code (EUR,CZK,CHF,..)
     * @var string
     *
     * @Assert\NotBlank(message = "price.currency.notBlank")
     * @Assert\Currency(message = "price.currency.currency")
     */
    public $currency;

    /**
     * @param $value
     * @param $currency
     */
    function __construct($value, $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }
} 
