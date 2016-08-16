<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * communication channel for customer
 * @webserializable
 */
class Communication
{
    const COMMUNICATION_TYPE_PHONE = 'PHONE';
    const COMMUNICATION_TYPE_PRIVATE_PHONE = 'PRIVATE_PHONE';
    const COMMUNICATION_TYPE_OFFICIAL_PHONE = 'OFFICIAL_PHONE';
    const COMMUNICATION_TYPE_CELL_PHONE = 'CELL_PHONE';
    const COMMUNICATION_TYPE_FAX   = 'FAX';
    const COMMUNICATION_TYPE_PRIVATE_FAX = 'PRIVATE_FAX';
    const COMMUNICATION_TYPE_OFFICIAL_FAX = 'OFFICIAL_FAX';
    const COMMUNICATION_TYPE_POST = 'POST';
    const COMMUNICATION_TYPE_EMAIL = 'EMAIL';
    const COMMUNICATION_TYPE_WEBSITE = 'WEBSITE';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "communication.id.type.integer")
     */
    public $id;

    /**
     * identifier of customer
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "communication.customerId.length.max")
     */
    public $customerId;

    /**
     * communication type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Communication::COMMUNICATION_TYPE_PHONE,
     *     Communication::COMMUNICATION_TYPE_PRIVATE_PHONE,
     *     Communication::COMMUNICATION_TYPE_OFFICIAL_PHONE,
     *     Communication::COMMUNICATION_TYPE_CELL_PHONE,
     *     Communication::COMMUNICATION_TYPE_FAX,
     *     Communication::COMMUNICATION_TYPE_PRIVATE_FAX,
     *     Communication::COMMUNICATION_TYPE_OFFICIAL_FAX,
     *     Communication::COMMUNICATION_TYPE_POST,
     *     Communication::COMMUNICATION_TYPE_EMAIL,
     *     Communication::COMMUNICATION_TYPE_WEBSITE,
     *   },
     *   message = "communication.communicationType.choice"
     * )
     */
    public $communicationType;

    /**
     * communication value
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "communication.value.length.max")
     */
    public $value;

    /**
     * extras
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "communication.extras.length.max")
     */
    public $extras;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 80, maxMessage = "communication.externalId.length.max")
     */
    public $externalId;

    /**
     * describes if this channel is usable
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "communication.deactivated.type.bool")
     */
    public $deactivated;

    /**
     * customer decides to not be informed via this channel
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "communication.noCommunication.type.bool")
     */
    public $noCommunication;
}
