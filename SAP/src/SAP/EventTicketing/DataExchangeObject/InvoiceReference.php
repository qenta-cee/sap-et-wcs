<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class InvoiceReference
{
    const TYPE_INVOICE = 'INVOICE';
    const TYPE_OPTION = 'OPTION';
    const TYPE_RETURN = 'RETURN';

    /**
     * primary identifier
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "invoiceReference.id.length.max")
     */
    public $id;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "invoiceReference.externalId.length.max")
     */
    public $externalId;

    /**
     * type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     InvoiceReference::TYPE_INVOICE,
     *     InvoiceReference::TYPE_OPTION,
     *     InvoiceReference::TYPE_RETURN,
     *   },
     *   message = "invoiceReference.type.choice"
     * )
     */
    public $type;
}
