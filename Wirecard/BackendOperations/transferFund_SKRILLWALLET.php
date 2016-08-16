<?php

  // the fund transfer type
  $this->fundTransferType = "SKRILLWALLET";

	// computes the fingerprint based on the request parameters
  $this->requestFingerprint = $this->computeFingerprint($this->customerId, $this->shopId, $this->password,
                                           $this->secret, $this->language, $this->orderNumber,
                                           $this->orderDescription,
                                           $this->amount, $this->currency,
                                           $this->customerStatement,
                                           $this->fundTransferType, $this->consumerEmail);

  // sets all request parameters as assoziative array
  $request = array(
               "customerId" => $this->customerId,
               "shopId" => $this->shopId,
               "password" => $this->password,
               "language" => $this->language,
               "requestFingerprint" => $this->requestFingerprint,
               "orderNumber" => $this->orderNumber,
               "amount" => $this->amount,
               "currency" => $this->currency,
               "orderDescription" => $this->orderDescription,
               "customerStatement" => $this->customerStatement,
               "fundTransferType" => $this->fundTransferType,
               "consumerEmail" => $this->consumerEmail
             );

  $response = $this->serverToServerRequest($this->URL_TRANSFER_FUND, $request, $systemInfo);