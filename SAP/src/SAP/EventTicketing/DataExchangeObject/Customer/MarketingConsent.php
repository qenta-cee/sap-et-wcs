<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class MarketingConsent
{
    const TYPE_EMAIL = 'EMAIL';
    const TYPE_SMS = 'SMS';
    const TYPE_LETTER = 'LETTER';
    const TYPE_PHONE = 'PHONE';

    const STATUS_CREATED = 'CREATED';
    const STATUS_VALID = 'VALID';
    const STATUS_INVALID = 'INVALID';

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "marketingConsent.externalId.length.max")
     */
    public $externalId;

    /**
     * Type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     MarketingConsent::TYPE_EMAIL,
     *     MarketingConsent::TYPE_SMS,
     *     MarketingConsent::TYPE_LETTER,
     *     MarketingConsent::TYPE_PHONE
     *   },
     *   message = "marketingConsent.type.choice"
     * )
     */
    public $type;

    /**
     * Status
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     MarketingConsent::STATUS_CREATED,
     *     MarketingConsent::STATUS_VALID,
     *     MarketingConsent::STATUS_INVALID
     *   },
     *   message = "marketingConsent.status.choice"
     * )
     */
    public $status;

    /**
     * Receiver
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "marketingConsent.receiver.length.max")
     */
    public $receiver;

    /**
     * @param string $receiver Receiver
     * @param string $externalId Externe ID
     */
    function __construct($receiver, $externalId)
    {
        $this->receiver = $receiver;
        $this->externalId = $externalId;
    }
}
