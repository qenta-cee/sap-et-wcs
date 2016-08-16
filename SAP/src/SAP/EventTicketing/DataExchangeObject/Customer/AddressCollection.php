<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use SAP\EventTicketing\DataExchangeObject\AbstractCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Collection object for Address objects
 * @webserializable
 */
class AddressCollection extends AbstractCollection
{
    /**
     * Soap Hack
     * @param $var
     * @return mixed
     */
    public function __get($var)
    {
        if ($var == 'item') {
            return $this->toArray();
        }

        return $this->{$var};
    }
}
