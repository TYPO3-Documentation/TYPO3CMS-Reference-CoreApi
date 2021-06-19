.. include:: /Includes.rst.txt
.. index:: pair: Site handling; Error handling
.. _sitehandling-errorHandling:

==============
Error handling
==============

Error handling can be configured on site level and is automatically dependent
on the current site and language.

There are currently to error handler implementations and the option to write
a custom handler:

.. toctree::
   :titlesonly:

   PageErrorHandler
   FluidErrorHandler
   WriteCustomErrorHandler


The configuration consists of two parts:

* The HTTP Error Status Code that should be handled
* The Error Handler Configuration

You can define one error handler per HTTP error code and add a generic one that
serves all error pages.

.. attention::
   Exceptions must be handled via the :ref:`error and exception handling
   <error-handling>` since they occur on a much lower level.
   These are currently not covered by site error handling.

.. figure:: /Images/ManualScreenshots/SiteHandling/SiteHandlingErrorHandling-1.png
   :class: with-shadow
   :alt: Error Handling

   Add custom error handling.


.. index:: pair: Site handling; Error handling properties

Properties
==========

These properties apply to all error handlers.

.. _sitehandling-errorHandling_errorCode:

errorCode
---------

:aspect:`Datatype`
    int

:aspect:`Description`
    The HTTP (Error) Status Code to handle. The predefined list contains the most common errors.
    A free definition of other error codes is also possible. The special value `0` will take care of
    all errors.

:aspect:`Example`
    `404`


.. _sitehandling-errorHandling_errorHandler:

errorHandler
------------

:aspect:`Datatype`
    string / enum

:aspect:`Description`
   Define how to handle these errors. May be
   :ref:`Fluid<sitehandling-errorHandling_fluid>` for rendering a Fluid template,
   :ref:`Page<sitehandling-errorHandling_page>` for fetching content from a page
   or :ref:`PHP<sitehandling-customErrorHandler>` for a custom implementation.

:aspect:`Example`
   `Fluid`



