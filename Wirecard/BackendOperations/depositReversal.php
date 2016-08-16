<?php

	// computes the fingerprint based on the request parameters
  $this->requestFingerprint = $this->computeFingerprint($this->customerId, $this->shopId, $this->password,
                                           $this->secret, $this->language, $this->orderNumber,
                                           $this->paymentNumber);

  // sets all request parameters as assoziative array
  $request = array(
               "customerId" => $this->customerId,
               "shopId" => $this->shopId,
               "password" => $this->password,
               "language" => $this->language,
               "requestFingerprint" => $this->requestFingerprint,
               "orderNumber" => $this->orderNumber,
               "paymentNumber" => $this->paymentNumber
             );

  $response = $this->serverToServerRequest($this->URL_DEPOSIT_REVERSAL, $request, $systemInfo);