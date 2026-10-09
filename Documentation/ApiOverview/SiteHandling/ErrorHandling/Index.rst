..  include:: /Includes.rst.txt
..  index:: pair: Site handling; Error handling
..  _sitehandling-errorhandling:

==============
Error handling
==============

Error handling can be configured on site level and is automatically dependent
on the current site and language.

Currently, there are two error handler implementations and the option to write
a :ref:`custom handler <sitehandling-customerrorhandler>`:

..  toctree::
    :titlesonly:

    PageErrorHandler
    FluidErrorHandler



The configuration consists of two parts:

*   The HTTP error status code that should be handled
*   The error handler configuration

You can define one error handler per HTTP error code and add a generic one that
serves all error pages.

..  attention::
    Exceptions must be handled via :ref:`error and exception handling
    <error-handling>`, since they occur on a much lower level.
    These are currently not covered by site error handling.

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteHandlingErrorHandling-1.png
    :zoom: lightbox

    Add custom error handling.

..  index:: pair: Site handling; Error handling properties

..  _sitehandling-error-handling-properties:

Properties
==========

These properties apply to all error handlers.

..  _sitehandling-errorhandling-errorcode:

..  confval:: errorCode
    :name: site-error-handling-errorCode
    :searchFacet: Site Configuration
    :type: int
    :Example: `404`

    The `HTTP (error) status code`_ to handle. The predefined list contains the
    most common errors. A free definition of other error codes is also possible.
    The special value `0` will take care of all errors.

    ..  _HTTP (error) status code: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status


..  _sitehandling-errorhandling-errorhandler:

..  confval:: errorHandler
    :name: site-error-handling-errorHandler
    :searchFacet: Site Configuration
    :type: string / enum
    :Example: `Fluid`

    Define how to handle these errors:

    *   :ref:`Fluid <sitehandling-errorhandling-fluid>` for rendering a Fluid
        template
    *   :ref:`Page <sitehandling-errorhandling-page>` for fetching content from
        a page
    *   :ref:`PHP <sitehandling-customerrorhandler>` for a custom
        implementation

..  index:: pair: Site handling; ErrorController
..  _sitehandling-errorhandling-trigger:

Trigger an error page from an extension
=======================================

:php:`\TYPO3\CMS\Frontend\Controller\ErrorController` builds the response
for an error. It looks up the error handler that the site configures for the
status code. Where the site configures none, it falls back to the error page
of TYPO3. So an extension that reports an error through this controller gets
the error handling of the site.

..  _sitehandling-errorhandling-custom-action:

Any status code with `customErrorAction()`
------------------------------------------

..  versionadded:: 14.2
    :changelog: feature-108904-1771065699

:php-short:`\TYPO3\CMS\Frontend\Controller\ErrorController::customErrorAction()`
reports a status code of your choice, with a title and a message of your own.
Use it for a code that the methods for the fixed codes do not cover, for
example HTTP 429:

..  literalinclude:: _TriggerCustomErrorPage.php
    :caption: EXT:my_extension/Classes/Controller/DownloadController.php

After the request, the status code, the title, and the message, the method
takes three optional arguments. `$technicalReason` is a detail that TYPO3
appends to the message as `Reason: <technicalReason>`. `$reasons` reaches the
error handler of the site. `$errorCode` is a number that the error page shows
next to the message.

A request that accepts `application/json` receives a JSON response carrying
the technical reason, instead of an HTML page.

Configure an error handler for the status code to render the page of the site
instead of the error page of TYPO3. The :ref:`errorCode
<sitehandling-errorhandling-errorcode>` property accepts any code, so a site
can answer a 429 with a Fluid template of its own.
