<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Shipment
 * @webserializable
 */
class Shipment
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "shipment.id.type.integer")
     */
    public $id;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "shipment.name.length.max")
     */
    public $name;
} 
