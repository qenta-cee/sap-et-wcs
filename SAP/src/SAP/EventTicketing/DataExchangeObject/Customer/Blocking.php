<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Management of customer locks
 *
 * @package framework
 */
class Blocking
{
    /**
     * title of lock
     * @var string
     *
     * @SapAssert\Length(max = 40, maxMessage = "blocking.title.length.max")
     */
    public $title;

    /**
     * description of lock
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "blocking.description.length.max")
     */
    public $description;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "blocking.externalId.length.max")
     */
    public $externalId;

    /**
     * ticketing sale lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.sale.type.bool")
     */
    public $sale = false;

    /**
     * ticketing shipping lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.shipment.type.bool")
     */
    public $shipment = false;

    /**
     * ticketing access control lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.entry.type.bool")
     */
    public $entry = false;

    /**
     * membership management lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.membership.type.bool")
     */
    public $membership = false;

    /**
     * lock DTA payment
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.dataMediumExchange.type.bool")
     */
    public $dataMediumExchange = false;

    /**
     * lock credit card payment
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.creditCard.type.bool")
     */
    public $creditCard = false;

    /**
     * lock direct debit payment
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.debit.type.bool")
     */
    public $debit = false;

    /**
     * lock invoice payment
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.invoice.type.bool")
     */
    public $invoice = false;

    /**
     * lock cheque payment
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.cheque.type.bool")
     */
    public $cheque = false;

    /**
     * lock cash on delivery
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.cashOnDelivery.type.bool")
     */
    public $cashOnDelivery = false;

    /**
     * only cash payment allowed
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.onlyCash.type.bool")
     */
    public $onlyCash = false;

    /**
     * communication lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.communication.type.bool")
     */
    public $communication = false;

    /**
     * state of the lock
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "blocking.state.type.bool")
     */
    public $state;

    /**
     * date of start
     * @var string
     *
     * @SapAssert\Date(message = "blocking.startDate.date")
     */
    public $startDate = '';

    /**
     * date of end
     * @var string
     *
     * @SapAssert\Date(message = "blocking.endDate.date")
     */
    public $endDate = '';

    /**
     * @param string $title
     * @param string $externalId
     */
    function __construct($title, $externalId)
    {
        $this->title = $title;
        $this->externalId = $externalId;
    }
}
