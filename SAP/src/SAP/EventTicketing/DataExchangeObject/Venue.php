<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Venue
 * @webserializable
 */
class Venue
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "venue.id.type.integer")
     */
    public $id;

    /**
     * key
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "venue.key.length.max")
     */
    public $key;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "venue.name.length.min", maxMessage = "venue.name.length.max")
     */
    public $name;

    /**
     * street
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 40, minMessage = "venue.street.length.min", maxMessage = "venue.street.length.max")
     */
    public $street;

    /**
     * post code
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 10, minMessage = "venue.postalCode.length.min", maxMessage = "venue.postalCode.length.max")
     */
    public $postalCode;

    /**
     * city
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 40, minMessage = "venue.city.length.min", maxMessage = "venue.city.length.max")
     */
    public $city;

    /**
     * federal state
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "venue.federalState.length.min", maxMessage = "venue.federalState.length.max")
     */
    public $federalState;

    /**
     * additional information
     * @var string
     *
     * @SapAssert\Length(max = 40, maxMessage = "venue.additional.length.max")
     */
    public $additionalInformation;
}
