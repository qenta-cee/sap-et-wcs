<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Collection object for Address objects
 * @webserializable
 */
abstract class AbstractCollection extends ArrayCollection
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
