<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * CustomerPool
 * @webserializable
 */
class CustomerPool
{
    /**
     * Normal/not specified
     */
    const TYPE_NORMAL_POOL = 'NORMAL_POOL';

    /**
     * Temporary customer pool
     */
    const TYPE_TEMPORARY_POOL = 'TEMPORARY_POOL';

    /**
     * Knowledge pool
     */
    const TYPE_KNOWLEDGE_POOL = 'KNOWLEDGE_POOL';

    /**
     * Club
     */
    const TYPE_CLUB_POOL = 'CLUB_POOL';

    /**
     * Department
     */
    const TYPE_DEPARTMENT_POOL = 'DEPARTMENT_POOL';

    /**
     * Actions/Campaign pool
     */
    const TYPE_CAMPAIGN_POOL = 'CAMPAIGN_POOL';

    /**
     * Statistic pool
     */
    const TYPE_STATISTIC_POOL = 'STATISTIC_POOL';

    /**
     * Newsletter Pool
     */
    const TYPE_NEWSLETTER_POOL = 'NEWSLETTER_POOL';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\NotBlank(message = "customerPool.id.notBlank")
     * @Assert\Type(type = "integer", message = "customerPool.id.type.integer")
     */
    public $id;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 250, maxMessage = "customerPool.externalId.length.max")
     */
    public $externalId;

    /**
     * description of customer pool
     * @var string
     *
     * @Assert\NotBlank(message = "customerPool.description.notBlank")
     * @SapAssert\Length(max = 255, maxMessage = "customerPool.description.length.max")
     */
    public $description;

    /**
     * type of customer pool
     * @var string
     *
     * @Assert\NotBlank(message = "customerPool.type.notBlank")
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
     *   message = "customerPool.type.choice"
     * )
     */
    public $type;

    /**
     * List of all customer-numbers of pool-members
     * @var string[]
     *
     * @Assert\All({
     *   @SapAssert\Length(max = 20, maxMessage = "customerPool.members.length.max")
     * })
     */
    public $members;

    /**
     * @param string $description
     * @param int $id
     * @param string $type
     */
    function __construct($description, $id, $type)
    {
        $this->description = $description;
        $this->id = $id;
        $this->type = $type;
    }
} 
