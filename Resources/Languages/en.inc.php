<?php
namespace WireCardSeamlessBundle\Resources\Languages;

/**
 * English (en)
 * language file
 *
 */

// Payment types
$languageData["BANCONTACT_MISTERCASH"] = "Bancontact/Mister Cash";
$languageData["CCARD"] = "Credit Card";
$languageData["CCARD-MOTO"] = "Credit Card MOTO";
$languageData["EKONTO"] = "eKonto";
$languageData["SEPA-DD"] = "SEPA Direct Debit";
$languageData["EPS"] = "eps Online-Überweisung";
$languageData["GIROPAY"] = "giropay";
$languageData["IDL"] = "iDEAL";
$languageData["INSTALLMENT"] = "Installment";
$languageData["INVOICE"] = "Invoice";
$languageData["MONETA"] = "moneta.ru";
$languageData["MPASS"] = "mpass";
$languageData["PRZELEWY24"] = "Przelewy24";
$languageData["PAYPAL"] = "PayPal";
$languageData["PBX"] = "paybox";
$languageData["POLI"] = "POLi";
$languageData["PSC"] = "paysafecard";
$languageData["QUICK"] = "@Quick";
$languageData["SKRILLDIRECT"] = "Skrill Direct";
$languageData["SKRILLWALLET"] = "Skrill Digital Wallet";
$languageData["SOFORTUEBERWEISUNG"] = "SOFORT Banking";
$languageData["TRUSTLY"] = "Trustly";
$languageData["TRUSTPAY"] = "TrustPay";
$languageData["TATRAPAY"] = "TatraPay";
$languageData["EPAY_BG"] = "ePay.bg";
$languageData["VOUCHER"] = "My Voucher";

// Configuration parameters
$languageData["customerIdKey"] = "Customer ID";
$languageData["secretKey"] = "Secret";
$languageData["languageKey"] = "Language";
$languageData["paymentTypeKey"] = "Payment type";
$languageData["amountKey"] = "Amount";
$languageData["currencyKey"] = "Currency";
$languageData["orderDescriptionKey"] = "Order description";
$languageData["successUrlKey"] = "Success URL";
$languageData["cancelUrlKey"] = "Cancel URL";
$languageData["failureUrlKey"] = "Failure URL";
$languageData["serviceUrlKey"] = "Service URL";
$languageData["requestFingerprintOrderKey"] = "Request fingerprint order";
$languageData["requestFingerprintKey"] = "Request fingerprint";
$languageData["financialInstitutionKey"] = "Financial institution";
$languageData["financialInstitution1Key"] = "Financial institution 1";
$languageData["financialInstitution2Key"] = "Financial institution 2";
$languageData["financialInstitution3Key"] = "Financial institution 3";
$languageData["financialInstitution4Key"] = "Financial institution 4";
$languageData["pendingUrlKey"] = "Pending URL";
$languageData["confirmUrlKey"] = "Confirm URL";
$languageData["noScriptInfoUrlKey"] = "No script info URL";
$languageData["orderNumberKey"] = "Order number";
$languageData["windowNameKey"] = "Window name";
$languageData["duplicateRequestCheckKey"] = "Duplicate request check";
$languageData["customerStatementKey"] = "Customer statement";
$languageData["orderReferenceKey"] = "Order reference";
$languageData["transactionIdentifierKey"] = "Transaction identifier";
$languageData["displayTextKey"] = "Display text";
$languageData["imageUrlKey"] = "Image URL";
$languageData["shopIdKey"] = "Shop ID";
$languageData["layoutKey"] = "Layout";
$languageData["debugDirKey"] = "Debug directory";
$languageData["debugModeKey"] = "Debug mode";
$languageData["pciDssSaqKey"] = "PCI DSS SAQ";
$languageData["cssUrlKey"] = "CSS URL for SAQ A";
$languageData["ccAdditionalFieldsKey"] = "Additional input fields";

// American Express Address Verification - Amex AVS
$languageData["consumerBillingFirstnameKey"] = "First name";
$languageData["consumerBillingLastnameKey"] = "Last name";
$languageData["consumerBillingAddress1Key"] = "Adress 1";
$languageData["consumerBillingAddress2Key"] = "Adress 2";
$languageData["consumerBillingCityKey"] = "City";
$languageData["consumerBillingCountryKey"] = "Country";
$languageData["consumerBillingZipCodeKey"] = "Zip code";
$languageData["consumerEmailKey"] = "Email";
$languageData["consumerBirthDateKey"] = "Birth date";
$languageData["consumerBillingPhoneKey"] = "Phone";
$languageData["consumerBillingFaxKey"] = "Fax";


$languageData["backendOpPasswordKey"] = "Back-end operations password";

$languageData["checkout"] = "Start payment | Checkout";
$languageData["manual.popup.click"] = "If the checkout window did not open automatically, please click here!";

$languageData["viewPaymentDataKey"] = "Viewed payment data";
$languageData["checkoutMethodKey"] = "Checkout method for shops";
$languageData["shopHostsKey"] = "Shop hosts";
$languageData["paymentCancelled"] = "Payment cancelled!";
$languageData["paymentFailure"] = "Payment failed!";
$languageData["paymentPending"] = "Payment not completed yet! (PENDING)";
$languageData["paymentPendingTrustly"] = "Payment PENDING! The ticketing system does not support that yet. Please manually cancel your payment at your financial service provider.";

$languageData["reservePaymentData.nodatareturned"] = "No data retuned from the checkout process!";
$languageData["reservePaymentData.invalidstate"] = "Invalid internal state!";

$languageData["cancelReserve.notsupportedcancel"] = " does not support cancelling! ";
$languageData["cancelReserve.notsupportedcancelbyref"] = " does not support cancel by reference! ";
$languageData["cancelReserve.toolkitfailed"] = "Cancelling process failed! Please try again.";
$languageData["backendOperationFailed"] = "Backend operation failed!";
$languageData["getOrderDetails.backendOpFailed"] = "Receiving transaction details failed! Please try again.";

$languageData["toolkit.setupParameters.parseamounterror"] = "Error when trying to parse amount and currency!";
$languageData["toolkit.setupParameters.nodepositdataerror"] = "No deposit data available for this transaction!";
$languageData["toolkit.setupParameters.norefunddataerror"] = "No refund data available for this transaction!";
$languageData["paymentStatusTemporary"] = "Finalizing payment not possible (temporary payment status)";
$languageData["paymentStatusOrdered"] = "Payment already finalized!";

// Wirecard data storage 
$languageData["wirecard.datastorage.callbackalert.title"] = "Result of storing your sensible data";
$languageData["wirecard.datastorage.init.failed"] = "Wirecard DataStorage initialization failed!";

/***** 	Wirecard Seamless sensitive data parameter fields *****/

//	button
$languageData["storeData"] = "Send";
$languageData["select.financialInst"] = "Select financial institution";
$languageData["button.continue"] = "Next";

//	SEPA Direct Debit
$languageData["bankAccountIban"] = "IBAN:";
$languageData["bankBic"] = "BIC:";
$languageData["accountOwner"] = "Account owner:";
$languageData["bankName"] = "Bank name:";


//	Credit Card
$languageData["pan"] = "Credit card number:";
$languageData["expirationDate"] = "Expiration date:";
$languageData["cardholdername"] = "Card holder:";
$languageData["cardverifycode"] = "Verification code:";
$languageData["issueDate"] = "Issue date:";

// Paybox
$languageData["payerPayboxNumber"] = "paybox Number:";

//	Giropay
$languageData["bankAccount"] = "Account number:";
$languageData["bankNumber"] = "Bank sorting code:";

//	Voucher by ValueMaster
$languageData["voucherId"] = "Voucher code:";

