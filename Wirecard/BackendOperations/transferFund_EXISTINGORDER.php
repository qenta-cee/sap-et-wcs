<?php

  // the fund transfer type
  $this->fundTransferType = "EXISTINGORDER";


	// computes the fingerprint based on the request parameters
  $this->requestFingerprint = $this->computeFingerprint($this->customerId, $this->shopId, $this->password,
                                           $this->secret, $this->language, $this->orderNumber,
                                           $this->orderDescription,
                                           $this->amount, $this->currency,
                                           $this->fundTransferType, $this->sourceOrderNumber);

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
               "fundTransferType" => $this->fundTransferType,
               "sourceOrderNumber" => $this->sourceOrderNumber
             );

  $response = $this->serverToServerRequest($this->URL_TRANSFER_FUND, $request, $systemInfo);