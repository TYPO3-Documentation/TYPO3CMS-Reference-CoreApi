.. include:: ../../Includes.txt

.. _http:

=====================================
HTTP Request Library / Guzzle / PSR-7
=====================================

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

Basic Usage
===========

The `RequestFactory` class can be used like this:

.. code-block:: php

      use Psr\Http\Message\ResponseFactoryInterface;

      /** @var RequestFactoryInterface */
        private $requestFactory;

      // Initiate the Request Factory, which allows to run multiple requests (prefer dependency injection)
        public function __construct(RequestFactoryInterface $requestFactory)
        {
            $this->requestFactory = $requestFactory;
        }

      public function handle() {
         $url = 'https://typo3.com';
         $additionalOptions = [
            // Additional headers for this specific request
            'headers' => ['Cache-Control' => 'no-cache'],
            // Additional options, see http://docs.guzzlephp.org/en/latest/request-options.html
            'allow_redirects' => false,
            'cookies' => true,
         ];
         // Return a PSR-7 compliant response object
         $response = $this->requestFactory->request($url, 'GET', $additionalOptions);
         // Get the content as a string on a successful request
         if ($response->getStatusCode() === 200) {
            if (strpos($response->getHeaderLine('Content-Type'), 'text/html') === 0) {
               $content = $response->getBody()->getContents();
            }
         }
      }

A POST request can be achieved with:

.. code-block:: php

   $additionalOptions = [
      'body' => 'Your raw post data',
      // OR form data:
      'form_params' = [
         'first_name' => 'Hans',
         'last_name' => 'Dampf',
      ]
   ];
   $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

Extension authors are advised to use the `RequestFactory` class instead of using the Guzzle
API directly in order to ensure a clear upgrade path when updates to the underlying API need to be done.


.. note::

   Some information on this page was moved to :ref:`backend-routing`.

.. _http-custom-handlers:

Custom Middleware Handlers
==========================

Guzzle will accept a stack of custom middleware handlers, which can be configured using :php:`$GLOBALS['TYPO3_CONF_VARS']`.
If a custom configuration is given, the default handler stack is extended, but overridden.

.. code-block:: php

   # Add custom middleware to default Guzzle handler stack
   $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
      (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\ACME\Middleware\Guzzle\CustomMiddleware::class))->handler();
   $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
      (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\ACME\Middleware\Guzzle\SecondCustomMiddleware::class))->handler();
