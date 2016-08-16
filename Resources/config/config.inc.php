<?php

namespace WireCardSeamlessBundle\Resources\config;

/************************************* Logging *******************************************/

$logDir = "/var/log/sap_et";				// ATTENTION: This only works if you can provide the given directory as writeable
$logLevelConfig = "debug";					// "verbose", "debug", "prod", or "off" nothing
											// ATTENTION: The SAPET Cloud system cannot provide "debug" or "verbose" logging
$product = "WirecardSeamless";				// ATTENTION: This is only necessary if you can provide a writable directory given in $logDir

?>
