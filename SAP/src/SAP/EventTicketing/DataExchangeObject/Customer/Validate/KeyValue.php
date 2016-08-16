<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer\Validate;

use SAP\EventTicketing\Validator\Constraints as SapAssert;

class KeyValue
{
    /**
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "keyValue.key.length.max")
     */
    public $key;

    /**
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "keyValue.value.length.max")
     */
    public $value;
}
