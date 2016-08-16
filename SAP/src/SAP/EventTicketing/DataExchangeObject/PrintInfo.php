<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * all about printing
 * @webserializable
 */
class PrintInfo
{
    /**
     * counter for number of prints
     * @var integer
     *
     * @Assert\NotBlank(message = "printInfo.counter.notBlank")
     * @Assert\Type(type = "integer", message = "printInfo.counter.type.integer")
     */
    public $counter;

    /**
     * option printable: Do not print ticket
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "printInfo.printable.type.bool")
     */
    public $printable;

    /**
     * option state: Ticket is not printable/printable
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "printInfo.state.type.bool")
     */
    public $state;

    /**
     * booklet
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "printInfo.booklet.type.bool")
     */
    public $booklet = false;

    /**
     * @param $counter
     * @param $printable
     * @param $state
     */
    function __construct($counter, $printable, $state)
    {
        $this->counter = $counter;
        $this->printable = $printable;
        $this->state = $state;
    }
} 
