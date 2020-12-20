.. include:: /Includes.rst.txt
.. index::
   HTTP request
   Guzzle
   PSR-7
.. _http:

=====================================
HTTP request library / Guzzle / PSR-7
=====================================

Since TYPO3 CMS 8.1 the PHP library `Guzzle` has been added via composer dependency
to work as a feature rich solution for creating HTTP requests based on the PSR-7 interfaces
already used within TYPO3.

Guzzle auto-detects available underlying adapters available on the system, like cURL or
stream wrappers and chooses the best solution for the system.

A TYPO3-specific PHP class called :php:`\TYPO3\CMS\Core\Http\RequestFactory` has been added as
a simplified wrapper to access Guzzle clients.

All options available under :php:`$GLOBALS['TYPO3_CONF_VARS'][HTTP]` are automatically applied to the Guzzle
clients when using the :php:`RequestFactory` class. The options are a subset to the available options
on Guzzle (http://docs.guzzlephp.org/en/latest/request-options.html) but can further be extended.

Existing :php:`$GLOBALS['TYPO3_CONF_VARS'][HTTP]` options have been removed and/or migrated to the
new Guzzle-compliant options.

A full documentation for Guzzle can be found at http://docs.guzzlephp.org/en/latest/.

Although Guzzle can handle Promises/A+ and asynchronous requests, it currently acts as
a drop-in replacement for the previous mixed options and implementations within
:php:`GeneralUtility::getUrl()` and a PSR-7-based API for HTTP requests.

The existing TYPO3-specific wrapper :php:`GeneralUtility::getUrl()` now uses Guzzle under the hood
automatically for remote files, removing the need to configure settings based on certain
implementations like stream wrappers or cURL directly.

.. index:: HTTP request; RequestFactory
.. _http-basic:

Basic usage
===========

The `RequestFactory` class can be used like this:

.. code-block:: php

      use Psr\Http\Message\RequestFactoryInterface;

      /** @var RequestFactoryInterface */
      private $requestFactory;

      // Initiate the Request Factory, which allows to run multiple requests (prefer dependency injection)
      public function __construct(RequestFactoryInterface $requestFactory)
      {
         $this->requestFactory = $requestFactory;
      }

      public function handle()
      {
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

A POST request can be achieved with::

   $additionalOptions = [
      'body' => 'Your raw post data',
      // OR form data:
      'form_params' => [
         'first_name' => 'Hans',
         'last_name' => 'Dampf',
      ]
   ];
   $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

Extension authors are advised to use the :php:`RequestFactory` class instead of using the Guzzle
API directly in order to ensure a clear upgrade path when updates to the underlying API need to be done.


.. note::

   Some information on this page was moved to :ref:`backend-routing`.


.. index:: HTTP request; Custom middleware handlers
.. _http-custom-handlers:

Custom middleware handlers
==========================

Guzzle will accept a stack of custom middleware handlers, which can be configured using :php:`$GLOBALS['TYPO3_CONF_VARS']`.
If a custom configuration is given, the default handler stack is extended, but overridden.

.. code-block:: php

   # Add custom middleware to default Guzzle handler stack
   $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
      (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\ACME\Middleware\Guzzle\CustomMiddleware::class))->handler();
   $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
      (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\ACME\Middleware\Guzzle\SecondCustomMiddleware::class))->handler();


.. index:: HTTP request; HttpUtility

HTTP Utility Methods
====================

TYPO3 provides a small set of helper methods related to HTTP Requests in the class :php:`HttpUtility`:

HttpUtility::redirect
---------------------

Sends a redirect header response and exits. Additionally the URL is checked and
if needed corrected to match the format required for a Location redirect header.
By default the HTTP status code sent is `HTTP/1.1 303 See Other`.

HttpUtility::setResponseCode
----------------------------

Set a specific response code like `404`. Response codes should be taken from
the :php:`HttpUtility` class constants - for example :php:`HttpUtility::HTTP_STATUS_404`.

HttpUtility::setResponseCodeAndExit
-----------------------------------

Set a specific response code like `404` and exit directly.
Response codes should be taken from the :php:`HttpUtility` class constants -
for example :php:`HttpUtility::HTTP_STATUS_404`.

HttpUtility::buildUrl
---------------------

Builds a URL string from an array with the URL parts, as e.g. output by :php:`parse_url()`.

HttpUtility::buildQueryString
-----------------------------

The method :php:`buildQueryString()` is an enhancement to the `PHP function`_ :php:`http_build_query()`.
It implodes multidimensional parameter arrays and properly encodes parameter names as well as values to a valid query string.
with an optional prepend of :php:`?` or :php:`&`.

If the query is not empty, `?` or `&` are prepended in the correct sequence.
Empty parameters are skipped.

.. _`PHP function`: https://secure.php.net/manual/de/function.http-build-query.php

HttpUtility::idn_to_ascii
-------------------------

Compatibility layer for PHP versions running ICU 4.4, as the constant :php:`INTL_IDNA_VARIANT_UTS46`
is only available as of ICU 4.6.

.. important::

   Once PHP 7.4 is the minimum requirement, this method will vanish without further notice
   as it is recommended to use the native method instead, when working against a modern environment.
