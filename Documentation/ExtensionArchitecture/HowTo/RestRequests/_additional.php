<?php

use MyVendor\MyExtension\Http\Middleware\RequestIdMiddleware;

// Add a custom middleware to the default Guzzle handler stack
$GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']['my_extension_request_id'] =
  new RequestIdMiddleware();
