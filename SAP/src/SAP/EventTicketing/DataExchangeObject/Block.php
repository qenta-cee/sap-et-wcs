<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Block
 * @webserializable
 */
class Block {

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "block.id.type.integer")
     */
    public $id;

    /**
     * key
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "block.key.length.max")
     */
    public $key;

    /**
     * entry
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "block.entry.length.max")
     */
    public $entry;

    /**
     * number of seats
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "block.seats.type.integer")
     */
    public $seats;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max = 80, maxMessage = "block.name.length.max")
     */
    public $name;
} 
