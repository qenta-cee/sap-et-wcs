<?php

namespace SAP\EventTicketing\Bundle\PaymentBundle;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;

use SAP\EventTicketing\DataExchangeObject\Customer;
use SAP\EventTicketing\DataExchangeObject\User;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;

/**
 * This interface defines the required functions for
 * the implementation of a Payment gateway. It is designed to
 * support a two-step-payment process.
 *
 * Interface PaymentInterface
 * @package SAP\EventTicketing\Bundle\PaymentBundle
 */

interface PaymentInterface
{
    const DIRECT_DEBIT = 'DD';

    const CREDIT_CARD  = 'CC';

    const ELECTRONIC_PAYMENT = 'EPS';

    const COUPON_PAYMENT = 'COU';

  /**
   * creates a new instance of a payment gateway with an interface
   * to log information to the system
   *
   * @param LoggerInterface $logger   instance of the used logger API
   * @param SystemInfo $system        information about the system
   * @param User $user                data about the current user
   */
  public function __construct(LoggerInterface $logger, SystemInfo $system, User $user = null);

  /**
   * check the license of the payment gateway, for the case
   * that a special license is needed.
   *
   * @return boolean true if license is valid, otherwise false
   */
  public static function checkLicense();

  /**
   * returns the name of the gateway.
   *
   * @return string   the name of the gateway
   */
  public static function getGatewayName();

  /**
   * used to show the relevant dialog to collect the payment/banking data
   *
   * @param DialogData          $dialogData
   * @param PaymentTransaction  $transaction
   * @param Company             $company
   * @param Customer            $customer
   * @return boolean            true in case of success, otherwise false
   *
   * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
   */
  public function collectPaymentData(DialogData $dialogData, PaymentTransaction $transaction, Company $company = null, Customer $customer = null);

  /**
   * used to implement the reservation of payment data
   * in general the processing consists of 3 steps:
   *  * check the input data
   *  * send payment request to gateway
   *  * return payment data
   *
   * @param PaymentTransaction  $transaction
   * @param DialogData          $dialogData
   * @param string              $orderType
   * @return boolean            true in case of success, otherwise false
   *
   * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
   */
  public function reservePaymentData(PaymentTransaction $transaction, DialogData $dialogData, $orderType);

  /**
   * finalize the payment process
   *
   * @param PaymentTransaction $transaction
   * @return boolean
   *
   * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
   */
  public function finalize(PaymentTransaction $transaction);

  /**
   * cancel and rollback the executed reservation
   *
   * @param PaymentTransaction $transaction
   * @return boolean
   *
   * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
   */
  public function cancelReserve(PaymentTransaction $transaction);

  /**
   * pay back the value based on the transaction amount
   *
   * @param PaymentTransaction $transaction
   * @return boolean
   *
   * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
   */
  public function cancelByReference(PaymentTransaction $transaction);

  /**
   * returns the relevant text for the given language key and language
   *
   * @param string $language ISO 639-2 ( e.g. 'de', 'en' )
   * @param string $languagekey
   * @return string  the text for the relevant language key and language
   */
  public function getLanguageEntry($language, $languagekey);

  /**
   * returns a list of required parameters for the payment gateway.
   * This list will be processed within an configuration dialog.
   * The value-key can contain a simple string or a list of items, which should have the keys value and languagekey.
   * The value-key will be used as default value for the specific parameter.
   * The mandatory-key specifies if a parameter is required or not.
   * The used language keys will be used to call getLanguageEntry().
   *
   * format: array( key => array( value => [string|array(value => string, languagekey => string]
   *                              mandatory => true|false
   *                              languagekey => string
   *                            )
   *               );
   * @return array
   */
  public function getPossibleConfigParameters();

  /**
   * set the configuration of the payment gateway
   *
   * format: array( key => value );
   * @param array $parameters
   */
  public function setConfigurationParameters($parameters);

  /**
   * returns information for a given transaction ID
   *
   * @param $transactionId
   * @param bool $moreDetails
   * @return array list of information for this transaction
   */
  public function getTransactionDetails($transactionId, $moreDetails = false);
}
