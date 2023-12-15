..  include:: /Includes.rst.txt
..  index:: pair: Site handling; Error handling
..  _sitehandling-errorHandling:

==============
Error handling
==============

Error handling can be configured on site level and is automatically dependent
on the current site and language.

Currently, there are two error handler implementations and the option to write
a :ref:`custom handler <sitehandling-customErrorHandler>`:

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

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingErrorHandling-1.rst.txt


..  index:: pair: Site handling; Error handling properties

Properties
==========

These properties apply to all error handlers.

..  _sitehandling-errorHandling_errorCode:

..  option:: errorCode

    :type: int
    :Example: `404`

    The `HTTP (error) status code`_ to handle. The predefined list contains the
    most common errors. A free definition of other error codes is also possible.
    The special value `0` will take care of all errors.

    ..  _HTTP (error) status code: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status


.. _sitehandling-errorHandling_errorHandler:

..  option:: errorHandler

    :type: string / enum
    :Example: `Fluid`

    Define how to handle these errors:

    *   :ref:`Fluid <sitehandling-errorHandling_fluid>` for rendering a Fluid
        template
    *   :ref:`Page <sitehandling-errorHandling_page>` for fetching content from
        a page
    *   :ref:`PHP <sitehandling-customErrorHandler>` for a custom
        implementation


