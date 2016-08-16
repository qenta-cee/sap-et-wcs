<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;
use SAP\EventTicketing\DataExchangeObject\Customer\CustomerPool;

class CustomerPoolState
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "customerPoolState.id.type.integer")
     */
    public $id;

    /**
     * External ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 250, maxMessage = "customerPoolState.externalId.length.max")
     */
    public $externalId;

    /**
     * Description of customer pool
     *
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "customerPoolState.description.length.max")
     */
    public $description;

    /**
     * Type of customer pool
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     CustomerPool::TYPE_NORMAL_POOL,
     *     CustomerPool::TYPE_TEMPORARY_POOL,
     *     CustomerPool::TYPE_KNOWLEDGE_POOL,
     *     CustomerPool::TYPE_CLUB_POOL,
     *     CustomerPool::TYPE_DEPARTMENT_POOL,
     *     CustomerPool::TYPE_CAMPAIGN_POOL,
     *     CustomerPool::TYPE_STATISTIC_POOL,
     *     CustomerPool::TYPE_NEWSLETTER_POOL
     *   },
     *   message = "customerPoolState.type.choice"
     * )
     */
    public $type;

    /**
     * State of customer in customer pool
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     CustomerPoolState::STATE_ACTIVE,
     *     CustomerPoolState::STATE_INACTIVE
     *   },
     *   message = "customerPoolState.state.choice"
     * )
     */
    public $state;

    /**
     * @param $id
     * @param $description
     * @param $type
     * @param $state
     */
    function __construct($id, $description, $type, $state)
    {
        $this->id = $id;
        $this->description = $description;
        $this->type = $type;
        $this->state = $state;
    }
}
