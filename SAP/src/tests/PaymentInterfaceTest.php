<?php

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

$autoloader->addPsr4('SAP\\', __DIR__ . '/SAP/src/SAP');
$autoloader->addPsr4('Psr\\', __DIR__ . '/SAP/src/Psr');

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\Bundle\PaymentBundle\PaymentInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer;

class myLogger implements \Psr\Log\LoggerInterface
{

    public function emergency($message, array $context = array())
    {

    }

    public function alert($message, array $context = array())
    {
    }

    public function critical($message, array $context = array())
    {
    }

    public function error($message, array $context = array())
    {
    }

    public function warning($message, array $context = array())
    {
    }

    public function notice($message, array $context = array())
    {
    }

    public function info($message, array $context = array())
    {
    }

    public function debug($message, array $context = array())
    {
    }

    public function log($level, $message, array $context = array())
    {
    }
}


$logger = new myLogger();

$sysInfo = new \SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo();
$sysInfo->httpProxy = 'http://proxy.org';
$sysInfo->httpProxyPort = 9999;
$sysInfo->languageCode = 'de';

$user = new \SAP\EventTicketing\DataExchangeObject\User();

$user->id = 111;
$user->username = 'test';
$user->realName = 'Test User';
$user->currency = 'EUR';


$container = new \Symfony\Component\DependencyInjection\ContainerBuilder();

$loader = new XmlFileLoader(
    $container,
    new FileLocator(__DIR__ . '/Resources/config/')
);

$loader->load(__DIR__ . '/Resources/config/services.xml');

$container->compile();

$services = $container->findTaggedServiceIds('sapet.extension.payment');

foreach ($services as $serviceId => $arguments) {
    $srvDef = $container->getDefinition($serviceId);
    $class = $srvDef->getClass();

    $refClass = new ReflectionClass($class);

    $provider = $refClass->newInstance($logger, $sysInfo, $user);
    print("####### execute test cases for class $class #######" . PHP_EOL);
    testProviderImpl($provider);
}


function testProviderImpl(\SAP\EventTicketing\Bundle\PaymentBundle\PaymentInterface $provider)
{
    global $sysInfo;
    try {

        print('### execute method checkLicense' . PHP_EOL);
        $valid = $provider->checkLicense();
        if (is_bool($valid)) {
            echo('>>> method checkLicense returns a valid result' . PHP_EOL);
        } else {
            print_r('!!! method checkLicense returns an invalid result: ' . $valid . PHP_EOL);
        }


        print('### execute method getGatewayName' . PHP_EOL);
        $gwName = $provider->getGatewayName();
        if (is_string($gwName) && strlen($gwName) > 1) {
            echo('>>> method getGatewayName returns a valid result' . PHP_EOL);
        } else {
            echo('!!! method getGatewayName returns an invalid name: ' . $gwName . PHP_EOL);
        }

        print('### execute method getPossibleConfigParameters' . PHP_EOL);
        $gwParameters = $provider->getPossibleConfigParameters();
        $checkResult = true;
        foreach ($gwParameters as $key => $attributes) {
            if (!($key && $attributes['languagekey'])) {
                echo("!!! missing attribute 'languagekey' for parameter $key." . PHP_EOL);
                $checkResult = false;
                continue;
            } elseif (1 != 1) {
//             TODO: check if $attributes contains other keys as expected
            } else {
                $definition = '';
                foreach ($attributes as $key => $value) {
                    $definition .= "$key => $value; ";
                }
                echo(">>> return parameter $key with definition: " . $definition . PHP_EOL);
            }

            if (!$provider->getLanguageEntry($sysInfo->languageCode, $attributes['languagekey'])) {
                echo("!!! method getLanguageEntry doesn't return any languageEntry for languagekey:" . $attributes['languagekey'] . PHP_EOL);
            }
        }

        if ($checkResult) {
            echo('>>> method getPossibleConfigParameters returns a valid result' . PHP_EOL);
        } else {
            echo('!!! method getPossibleConfigParameters returns invalid parameters' . PHP_EOL);
        }


        print('### execute method setConfigurationParameters' . PHP_EOL);
        $provider->setConfigurationParameters(array('testParam' => 'testValue'));

        print('### execute method collectPaymentData' . PHP_EOL);
        testCollectPaymentData($provider);

        print('### execute method reservePaymentData' . PHP_EOL);
        testReservePaymentData($provider);

    } catch (\Exception $ex) {

        echo('ERROR: ' . $ex->getMessage() . PHP_EOL);
    }

    print('####### finish test cases for class #######' . PHP_EOL . PHP_EOL);

}

function testCollectPaymentData(PaymentInterface $provider)
{
    $comp = createCompanyObj();
    $transaction = createTransObj();
    $customer = createCustObj();
    $dialogData = createDialogObj();

    $before = serialize($dialogData);
    $res = $provider->collectPaymentData($dialogData, $transaction, $comp, $customer);

    $after = serialize($dialogData);
    if (!is_bool($res)) {
        echo('!!! method collectPaymentData returns invalid response: ' . $res . PHP_EOL);
    } elseif ($before === $after) {
        echo("!!! method collectPaymentData doesn't change any dialog data" . PHP_EOL);
    } else {
        echo('>>> method collectPaymentData returns a valid result ' . PHP_EOL);
    }
}

function testReservePaymentData(PaymentInterface $provider)
{
    $transaction = createTransObj();
    $dialogData = createDialogObj();

    $before = serialize($transaction);
    $res = $provider->reservePaymentData($transaction, $dialogData, 'CC');

    $after = serialize($transaction);

    if (!is_bool($res)) {
        echo('!!! method reservePaymentData returns invalid response: ' . $res . PHP_EOL);
    } elseif ($before === $after) {
        echo("!!! method reservePaymentData doesn't change any transaction data" . PHP_EOL);
    } else {
        echo('>>> method reservePaymentData returns a valid result ' . PHP_EOL);
    }
}

function createTransObj()
{
    $transaction = new PaymentTransaction();
    $transaction->startTime = date('YmtHis');
    $transaction->orderId = 12345;
    $transaction->ownerName = 'Max Mustermann';
    $transaction->type = 'CC';
    $transaction->value = '30.15E';
    $transaction->bankName = 'Big Bank';
    $transaction->bic = 987654321;
    $transaction->paymentStatus = 't';

    return $transaction;
}

function createCustObj()
{
    $customer = new Customer();
    $customer->id = 4811;
    $customer->company = 'Test Company';
    $customer->firstName = 'Max';
    $customer->lastName = 'Mustermann';
    $customer->dateOfBirth = '1970-01-01';
    $customer->gender = 'm';

    return $customer;
}

function createDialogObj()
{
    $dialogData = new DialogData();
    $dialogData->cancelURL = '';
    $dialogData->successURL = '';
    $dialogData->notifyURL = '';

    return $dialogData;
}

function createCompanyObj()
{
    $company = new Company();

    $company->company_id = 815;
    $company->name = 'Test Company';
    $company->address = 'Where ever street';
    return $company;
}






