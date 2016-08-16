<?php

namespace SAP\EventTicketing\Bundle\PaymentBundle\Model;

/**
 * this class represents some useful properties about
 * the system and environment of the event ticketing system
 *
 * Class SystemInfo
 * @package SAP\EventTicketing\Bundle\PaymentBundle\Model
 */
class SystemInfo
{
    /**
   * @var string if needed, the URL of the current proxy
   */
  public $httpProxy;

  /**
   * @var int if needed, the port of the current proxy
   */
  public $httpProxyPort;

  /**
   * @var int ID of the current online shop
   */
  public $onlineshop;

  /**
   * @var string code (ISO 639-2) of the currently used language
   */
  public $languageCode;
}
