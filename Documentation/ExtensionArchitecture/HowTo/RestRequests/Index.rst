:navigation-title: External HTTP requests

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

The :php:`RequestFactory` class can be used like this:

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
    :caption: config/system/additional.php | typo3conf/system/additional.php

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
