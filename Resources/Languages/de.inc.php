<?php
namespace WireCardSeamlessBundle\Resources\Languages;

/**
 * German (de)
 * language file
 * 
 */


// Payment types
$languageData["BANCONTACT_MISTERCASH"] = "Bancontact/Mister Cash";
$languageData["CCARD"] = "Kreditkarte";
$languageData["CCARD-MOTO"] = "Kreditkarte MOTO";
$languageData["EKONTO"] = "eKonto";
$languageData["SEPA-DD"] = "SEPA Lastschrift";
$languageData["EPS"] = "eps Online-Überweisung";
$languageData["GIROPAY"] = "giropay";
$languageData["IDL"] = "iDEAL";
$languageData["INSTALLMENT"] = "Kauf auf Raten";
$languageData["INVOICE"] = "Kauf auf Rechnung";
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
$languageData["SOFORTUEBERWEISUNG"] = "SOFORT Überweisung";
$languageData["TRUSTLY"] = "Trustly";
$languageData["TRUSTPAY"] = "TrustPay";
$languageData["TATRAPAY"] = "TatraPay";
$languageData["EPAY_BG"] = "ePay.bg";
$languageData["VOUCHER"] = "Mein Gutschein";

// Configuration parameters
$languageData["customerIdKey"] = "Kundennummer";
$languageData["secretKey"] = "Passwort";
$languageData["languageKey"] = "Sprache";
$languageData["paymentTypeKey"] = "Zahlungsmethode";
$languageData["amountKey"] = "Betrag";
$languageData["currencyKey"] = "Währung";
$languageData["orderDescriptionKey"] = "Beschreibung";
$languageData["successUrlKey"] = "Success URL";
$languageData["cancelUrlKey"] = "Cancel URL";
$languageData["failureUrlKey"] = "Failure URL";
$languageData["serviceUrlKey"] = "Service URL";
$languageData["requestFingerprintOrderKey"] = "Request-Fingerabdruck Reihenfolge";
$languageData["requestFingerprintKey"] = "Request-Fingerabdruck";
$languageData["financialInstitutionKey"] = "Finanzinstitut";
$languageData["financialInstitution1Key"] = "Finanzinstitute 1";
$languageData["financialInstitution2Key"] = "Finanzinstitute 2";
$languageData["financialInstitution3Key"] = "Finanzinstitute 3";
$languageData["financialInstitution4Key"] = "Finanzinstitute 4";
$languageData["pendingUrlKey"] = "Pending URL";
$languageData["confirmUrlKey"] = "Confirm URL";
$languageData["noScriptInfoUrlKey"] = "Kein script info URL";
$languageData["orderNumberKey"] = "Bestellnummer";
$languageData["windowNameKey"] = "Fenstername";
$languageData["duplicateRequestCheckKey"] = "Duplicate request check";
$languageData["customerStatementKey"] = "Kunden Anmerkung";
$languageData["orderReferenceKey"] = "Bestellreferenz";
$languageData["transactionIdentifierKey"] = "Transaktions-ID";
$languageData["displayTextKey"] = "Display Text";
$languageData["imageUrlKey"] = "Bild URL";
$languageData["shopIdKey"] = "Shop ID";
$languageData["layoutKey"] = "Layout";
$languageData["debugDirKey"] = "Debug Verseichnis";
$languageData["debugModeKey"] = "Debug Modus";
$languageData["pciDssSaqKey"] = "PCI DSS SAQ";
$languageData["cssUrlKey"] = "CSS URL für SAQ A";
$languageData["ccAdditionalFieldsKey"] = "Zusätzliche Eingabefelder";

// American Express Address Verification - Amex AVS
$languageData["consumerBillingFirstnameKey"] = "Vorname";
$languageData["consumerBillingLastnameKey"] = "Nachname";
$languageData["consumerBillingAddress1Key"] = "Adresse 1";
$languageData["consumerBillingAddress2Key"] = "Adresse 2";
$languageData["consumerBillingCityKey"] = "Stadt";
$languageData["consumerBillingCountryKey"] = "Land";
$languageData["consumerBillingZipCodeKey"] = "Postleitzahl";
$languageData["consumerEmailKey"] = "E-Mail";
$languageData["consumerBirthDateKey"] = "Gerbutsdatum";
$languageData["consumerBillingPhoneKey"] = "Telefon";
$languageData["consumerBillingFaxKey"] = "Fax";

$languageData["backendOpPasswordKey"] = "Back-end Operations Passwort";

$languageData["checkout"] = "Zahlung starten | Checkout";
$languageData["manual.popup.click"] = "Sollte sich das Checkout-Fenster nicht von selbst öffnen, klicken Sie bitte hier!";

$languageData["viewPaymentDataKey"] = "Angezeigte Zahlungsinformationen";
$languageData["checkoutMethodKey"] = "Checkout Methode für Shops";
$languageData["shopHostsKey"] = "Shop Hosts";
$languageData["paymentCancelled"] = "Zahlvorgang abgebrochen!";
$languageData["paymentFailure"] = "Zahlvorgang fehlgeschlagen!";
$languageData["paymentPending"] = "Zahlvorgang noch nicht abgeschlossen! (PENDING)";
$languageData["paymentPendingTrustly"] = "Zahlvorgang PENDING! Das Ticketsystem unterstützt dies derzeit noch nicht. Bitte stornieren Sie den Zahlvorgang manuell bei Ihrem Finanzdienstleister.";

$languageData["reservePaymentData.nodatareturned"] = "Der Checkout-Prozess hat keine Daten retouniert!";
$languageData["reservePaymentData.invalidstate"] = "Ungültiger interner Zustand!";

$languageData["cancelReserve.notsupportedcancel"] = " unterstützt keinen Abbruch! ";
$languageData["cancelReserve.notsupportedcancelbyref"] = " unterstützt kein cancel by reference! ";
$languageData["cancelReserve.toolkitfailed"] = "Abbruch nicht erfolgreich! Bitte versuchen Sie es noch einmal.";
$languageData["backendOperationFailed"] = "Backend operation fehlgeschlagen!";

$languageData["getOrderDetails.backendOpFailed"] = "Abfrage der Transaktions-Details nicht erfolgreich! Bitte versuchen Sie es noch einmal.";

$languageData["toolkit.setupParameters.parseamounterror"] = "Fehler beim Betrag auslesen!";
$languageData["toolkit.setupParameters.nodepositdataerror"] = "Keine deposit Daten für diese Transaktion verfügbar!";
$languageData["toolkit.setupParameters.norefunddataerror"] = "Keine refund Daten für diese Transaktion verfügbar!";
$languageData["paymentStatusTemporary"] = "Abschluss des Zahlvorgangs nicht möglich (temporärer Bezahlstatus)";
$languageData["paymentStatusOrdered"] = "Bezahlvorgang bereits abgeschlossen!";

// Wirecard data storage
$languageData["wirecard.datastorage.callbackalert.title"] = "Ergebnis der Übermittlung Ihrer sensiblen Daten";
$languageData["wirecard.datastorage.init.failed"] = "Wirecard DataStorage Initialisierung fehlgeschlagen!";

/***** 	Wirecard Seamless sensitive data parameter fields *****/

//	button
$languageData["storeData"] = "Senden";
$languageData["select.financialInst"] = "Finanzinstitut auswählen";
$languageData["button.continue"] = "Weiter";

//	SEPA Direct Debit
$languageData["bankAccountIban"] = "IBAN:";
$languageData["bankBic"] = "BIC:";
$languageData["accountOwner"] = "Kontoinhaber:";
$languageData["bankName"] = "Bank:";


//	Credit Card
$languageData["pan"] = "Kreditkartennummer:";
$languageData["expirationDate"] = "Ablaufdatum:";
$languageData["cardholdername"] = "Karteninhaber:";
$languageData["cardverifycode"] = "Kartenprüfnummer:";
$languageData["issueDate"] = "Ausstellungsdatum:";
$languageData["issueNumber"] = "Ausstellungsnummer:";

// Paybox
$languageData["payerPayboxNumber"] = "paybox-Nummer:";

//	Giropay
$languageData["bankAccount"] = "Kontonummer:";
$languageData["bankNumber"] = "Bankleitzahl:";

//	Voucher by ValueMaster
$languageData["voucherId"] = "Voucher Code:";