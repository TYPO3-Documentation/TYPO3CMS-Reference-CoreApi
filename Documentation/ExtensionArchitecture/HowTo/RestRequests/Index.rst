..  include:: /Includes.rst.txt
..  index::
    HTTP request
    Guzzle
    PSR-7
..  _http:

=================================
HTTP requests to external sources
=================================

The PHP library "Guzzle" is available in TYPO3 as a feature-rich solution for
creating HTTP requests based on the PSR-7 interfaces.

Guzzle automatically detects the underlying adapters available on the system,
such as cURL or stream wrappers, and chooses the best solution for the system.

A TYPO3-specific PHP class named :php:`TYPO3\CMS\Core\Http\RequestFactory` is
present as a simplified wrapper for accessing Guzzle clients.

All options available under :php:`$GLOBALS['TYPO3_CONF_VARS']['HTTP']` are
automatically applied to the Guzzle clients when using the :php:`RequestFactory`
class. The options are a subset of the available options from Guzzle, but can be
extended.

..  seealso::
    -   :ref:`typo3ConfVars_http`
    -   `Guzzle request options <https://docs.guzzlephp.org/en/stable/request-options.html>`__
    -   `Full documentation for Guzzle <https://docs.guzzlephp.org/en/stable/>`__

Although Guzzle can handle Promises/A+ and asynchronous requests, it currently
serves as a drop-in replacement for the previous mixed options and
implementations within :php:`GeneralUtility::getUrl()` and a PSR-7-based API for
HTTP requests.

The TYPO3-specific wrapper :php:`GeneralUtility::getUrl()` uses Guzzle for
remote files, eliminating the need to directly configure settings based on
specific implementations such as stream wrappers or cURL.

.. index:: HTTP request; RequestFactory
.. _http-basic:

Basic usage
===========

The :php:`RequestFactory` class can be used like this (PHP 8.1-compatible code):

..  include:: /CodeSnippets/Examples/Http/MeowInformationRequester.rst.txt

A POST request can be achieved with:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    $additionalOptions = [
        'body' => 'Your raw post data',
        // OR form data:
        'form_params' => [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]
    ];

    $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

Extension authors are advised to use the :php:`RequestFactory` class instead of
using the Guzzle API directly in order to ensure a clear upgrade path when
updates to the underlying API need to be done.


.. index:: HTTP request; Custom middleware handlers
.. _http-custom-handlers:

Custom middleware handlers
==========================

Guzzle accepts a stack of custom middleware handlers which can be configured
in :php:`$GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler']` as an array. If a
custom configuration is specified, the default handler stack will be extended
and not overwritten.

..  code-block:: php
    :caption: typo3conf/AdditionalConfiguration.php

    // Add custom middlewares to default Guzzle handler stack
    $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
        (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \MyVendor\MyExtension\Middleware\Guzzle\CustomMiddleware::class
        ))->handler();
    $GLOBALS['TYPO3_CONF_VARS']['HTTP']['handler'][] =
        (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \MyVendor\MyExtension\Middleware\Guzzle\SecondCustomMiddleware::class
        ))->handler();


.. index:: HTTP request; HttpUtility

HTTP Utility Methods
====================

TYPO3 provides a small set of helper methods related to HTTP Requests in the class :php:`HttpUtility`:

HttpUtility::redirect
---------------------

..  deprecated:: 11.3
    This method is deprecated and will be removed with TYPO3 v12.0. Create a
    direct response using the :ref:`ResponseFactory <request-handling-psr-17>`
    instead.

.. _http_utility_response_migration:

Migration
~~~~~~~~~

Most of the time, a proper PSR-7 response can be returned to the call stack
(request handler). Unfortunately there might still be some places within the
call stack where it is not possible to return a PSR-7 response directly. In such
a case a :php:`TYPO3\CMS\Core\Http\PropagateResponseException` could be thrown.
This is automatically caught by a PSR-15 middleware and the given PSR-7 response
is then returned directly.

..  code-block:: php

    // Before
    HttpUtility::redirect('https://example.org/', HttpUtility::HTTP_STATUS_303);

    // After

    // use Psr\Http\Message\ResponseFactoryInterface
    // use TYPO3\CMS\Core\Http\PropagateResponseException

    // Inject PSR-17 ResponseFactoryInterface
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory
    }

    // Create redirect response
    $response = $this->responseFactory
        ->createResponse(303)
        ->withAddedHeader('location', 'https://example.org/')

    // Return response directly
    return $response;

    // Or throw PropagateResponseException
    new PropagateResponseException($response);

..  note::
    Throwing exceptions for returning an immediate PSR-7 response is only
    considered as an intermediate solution until it is possible to return PSR-7
    responses at any relevant place. Therefore, the exception is marked as
    :php:`@internal` and will most likely vanish in the future.

HttpUtility::setResponseCode
----------------------------

..  deprecated:: 11.3
    This method is deprecated and will be removed with TYPO3 v12.0. Create a
    direct response using the :ref:`ResponseFactory <request-handling-psr-17>`
    instead. See also :ref:`Migration <http_utility_response_migration>`.

HttpUtility::setResponseCodeAndExit
-----------------------------------

..  deprecated:: 11.3
    This method is deprecated and will be removed with TYPO3 v12.0. Create a
    direct response using the :ref:`ResponseFactory <request-handling-psr-17>`
    instead. See also :ref:`Migration <http_utility_response_migration>`.

HttpUtility::buildUrl
---------------------

Creates a URL string from an array containing the URL parts, such as those
output by :php:`parse_url()`.

HttpUtility::buildQueryString
-----------------------------

The :php:`buildQueryString()` method is an enhancement to the `PHP function`_
:php:`http_build_query()`. It implodes multidimensional parameter arrays and
properly encodes parameter names as well as values into a valid query string
with an optional prepend of :php:`?` or :php:`&`.

If the query is not empty, `?` or `&` are prepended in the correct sequence.
Empty parameters are skipped.

.. _`PHP function`: https://www.php.net/manual/en/function.http-build-query.php
