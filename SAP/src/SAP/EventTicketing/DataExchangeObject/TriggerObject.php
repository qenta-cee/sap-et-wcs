<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Represents a data set for the trigger table
 * @webserializable
 */
class TriggerObject
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_ERROR = 'ERROR';
    const STATE_PROCESSED = 'PROCESSED';
    const STATE_SYSTEM_ERROR = 'SYSTEM ERROR';
    const STATE_DISABLED = 'DISABLED';
    const STATE_OPEN = 'OPEN';

    const TYPE_CUSTOMER_DATA = 'CUSTOMER_DATA';
    const TYPE_INVOICE_DATA = 'INVOICE_DATA';
    const TYPE_TICKET_DATA = 'TICKET_DATA';
    const TYPE_ITEM_DATA = 'ITEM_DATA';
    const TYPE_PRICELIST_DATA = 'PRICELIST_DATA';
    const TYPE_EXTRAPRICE_DATA = 'EXTRAPRICE_DATA';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "triggerObject.id.type.integer")
     */
    public $id;

    /**
     * type of the specific object
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     TriggerObject::TYPE_CUSTOMER_DATA,
     *     TriggerObject::TYPE_INVOICE_DATA,
     *     TriggerObject::TYPE_TICKET_DATA,
     *     TriggerObject::TYPE_ITEM_DATA,
     *     TriggerObject::TYPE_PRICELIST_DATA,
     *     TriggerObject::TYPE_EXTRAPRICE_DATA,
     *   },
     *   message = "triggerObject.type.choice"
     * )
     */
    public $type;

    /**
     * the id of the specific object
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "triggerObject.objectId.length.max")
     */
    public $objectId;

    /**
     * time of last update
     * @var string
     *
     * @SapAssert\DateTime(message = "triggerObject.timestamp.dateTime")
     */
    public $timestamp;

    /**
     * state
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     TriggerObject::STATE_ACTIVE,
     *     TriggerObject::STATE_ERROR,
     *     TriggerObject::STATE_PROCESSED,
     *     TriggerObject::STATE_SYSTEM_ERROR,
     *     TriggerObject::STATE_DISABLED,
     *     TriggerObject::STATE_OPEN,
     *   },
     *   message = "triggerObject.state.choice"
     * )
     */
    public $state;

    /**
     * the error code from external system
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "triggerObject.errorCode.length.max")
     */
    public $errorCode;

    /**
     * the error text from external system
     * @var string
     *
     * @Assert\Length(max = "65000", maxMessage = "triggerObject.errorMessage.length.max")
     */
    public $errorMessage;

    /**
     * id of the external system
     * @var int 10
     *
     * @Assert\Type(type = "integer", message = "triggerObject.systemId.type.integer")
     */
    public $systemId;
}
