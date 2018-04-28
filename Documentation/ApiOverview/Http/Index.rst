.. include:: ../../Includes.txt

.. _http:

HTTP request library / Guzzle / PSR-7
-------------------------------------

Since TYPO3 CMS 8.1 the PHP library `Guzzle` has been added via composer dependency
to work as a feature rich solution for creating HTTP requests based on the PSR-7 interfaces
already used within TYPO3.

Guzzle auto-detects available underlying adapters available on the system, like cURL or
stream wrappers and chooses the best solution for the system.

A TYPO3-specific PHP class called `TYPO3\CMS\Core\Http\RequestFactory` has been added as
a simplified wrapper to access Guzzle clients.

All options available under `$GLOBALS['TYPO3_CONF_VARS'][HTTP]` are automatically applied to the Guzzle
clients when using the `RequestFactory` class. The options are a subset to the available options
on Guzzle (http://docs.guzzlephp.org/en/latest/request-options.html) but can further be extended.

Existing `$GLOBALS['TYPO3_CONF_VARS'][HTTP]` options have been removed and/or migrated to the
new Guzzle-compliant options.

A full documentation for Guzzle can be found at http://docs.guzzlephp.org/en/latest/.

Although Guzzle can handle Promises/A+ and asynchronous requests, it currently acts as
a drop-in replacement for the previous mixed options and implementations within
`GeneralUtility::getUrl()` and a PSR-7-based API for HTTP requests.

The existing TYPO3-specific wrapper `GeneralUtility::getUrl()` now uses Guzzle under the hood
automatically for remote files, removing the need to configure settings based on certain
implementations like stream wrappers or cURL directly.


.. _http-basic:

Basic usage
^^^^^^^^^^^

The `RequestFactory` class can be used like this:

.. code-block:: php

   // Initiate the Request Factory, which allows to run multiple requests
   /** @var \TYPO3\CMS\Core\Http\RequestFactory $requestFactory */
   $requestFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Http\RequestFactory::class);
   $url = 'https://typo3.com';
   $additionalOptions = [
      // Additional headers for this specific request
      'headers' => ['Cache-Control' => 'no-cache'],
      // Additional options, see http://docs.guzzlephp.org/en/latest/request-options.html
      'allow_redirects' => false,
      'cookies' => true
   ];
   // Return a PSR-7 compliant response object
   $response = $requestFactory->request($url, 'GET', $additionalOptions);
   // Get the content as a string on a successful request
   if ($response->getStatusCode() === 200) {
      if (strpos($response->getHeaderLine('Content-Type'), 'text/html') === 0) {
         $content = $response->getBody()->getContents();
      }
   }

Extension authors are advised to use the `RequestFactory` class instead of using the Guzzle
API directly in order to ensure a clear upgrade path when updates to the underlying API need to be done.


.. _backend-routing:

Routing
^^^^^^^

Each request to the backend is eventually executed by a controller.
A list of routes is defined which maps a given request to a controller
and an action.

Routes are defined inside extensions, in file :file:`Configuration/Backend/Routes.php`
for general requests and in  :file:`Configuration/Backend/AjaxRoutes.php` for
AJAX calls.

Here is an extract of :file:`typo3/sysext/backend/Configuration/Backend/Routes.php`:

.. code-block:: php

	<?php
	use TYPO3\CMS\Backend\Controller;

	/**
	 * Definitions for routes provided by EXT:backend
	 * Contains all "regular" routes for entry points
	 *
	 * Please note that this setup is preliminary until all core use-cases are set up here.
	 * Especially some more properties regarding modules will be added until TYPO3 CMS 7 LTS, and might change.
	 *
	 * Currently the "access" property is only used so no token creation + validation is made,
	 * but will be extended further.
	 */
	return [
		// Login screen of the TYPO3 Backend
		'login' => [
			'path' => '/login',
			'access' => 'public',
			'target' => Controller\LoginController::class . '::formAction'
		],

		// Main backend rendering setup (previously called backend.php) for the TYPO3 Backend
		'main' => [
			'path' => '/main',
			'target' => Controller\BackendController::class . '::mainAction'
		],
		// ...
	];

So a routes file essentially returns an array containing routes mapping.
A route is defined by a key, a path and a target. The "public" :code:`access`
property indicates that no authentication is required for that action.

.. note::

   As the above code extract mentions, routes are a new feature (since TYPO3 CMS 7)
   and may yet evolve.
