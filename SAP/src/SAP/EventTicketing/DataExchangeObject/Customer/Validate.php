<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use SAP\EventTicketing\DataExchangeObject\Customer\AddressCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValueCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Validate
{
    /**
     * Validation status
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "validate.valid.type.bool")
     */
    public $valid;

    /**
     * Address suggestions
     * @var AddressCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Address[] $Addresses
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\AddressCollection",
     *   message = "validate.suggestions.type.addressCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Address",
     *     message = "validate.suggestions.all.type.address"
     *   )
     * })
     * @Assert\Valid
     */
    public $suggestions;

    /**
     * Address errors
     * @var KeyValueCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValue[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValueCollection",
     *   message = "validate.errors.type.keyValueCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValue",
     *     message = "validate.errors.all.type.keyValue"
     *   )
     * })
     * @Assert\Valid
     */
    public $errors;

    /**
     * Address warnings and notices
     * @var KeyValueCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValue[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValueCollection",
     *   message = "validate.warnings.type.keyValueCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Validate\KeyValue",
     *     message = "validate.warnings.all.type.keyValue"
     *   )
     * })
     * @Assert\Valid
     */
    public $warnings;

    public function __construct()
    {
        $this->suggestions = new AddressCollection();
        $this->errors = new KeyValueCollection();
        $this->warnings = new KeyValueCollection();
    }
}
