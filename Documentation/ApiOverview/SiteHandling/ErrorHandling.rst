.. include:: /Includes.rst.txt
.. index:: pair: Site handling; Error handling
.. _sitehandling-errorHandling:

==============
Error handling
==============

Error handling can be configured on site level and is automatically dependent on the
current site and language.

The configuration consists of two parts:

* The HTTP Error Status Code that should be handled
* The Error Handler Configuration

You can define one error handler per HTTP error code and add a generic one that serves all error pages.

.. attention::
   Exceptions must be handled via :ref:`error-handling` since they occur on a much lower level.
   These are currently not covered by site error handling.


.. figure:: ../../Images/SiteHandlingErrorHandling-1.png
   :class: with-shadow
   :alt: Error Handling

   Add custom error handling.


.. index:: pair: Site handling; Error handling properties

Properties
==========

errorCode
---------

:aspect:`Datatype`
    int

:aspect:`Description`
    The HTTP (Error) Status Code to handle. The predefined list contains the most common errors,
    a free definition of other error codes is also possible. Special value `0` will take care of
    all errors.

:aspect:`Example`
    `404`


errorHandler
------------

:aspect:`Datatype`
    string / enum

:aspect:`Description`
    Define how to handle these errors. May be `Fluid` for rendering a Fluid template,
    `Page` for fetching content from a page or `PHP` for a custom implementation.

:aspect:`Example`
    `Fluid`


errorFluidTemplate
------------------

:aspect:`Datatype`
    string

:aspect:`Description`
    **Only if errorHandler == `fluid`**: Path to fluid template file. Path may be

    * absolute
    * relative to site root
    * starting with `EXT:` for files from an extension

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Templates/Error.html`


errorFluidTemplatesRootPath
---------------------------

:aspect:`Datatype`
    string [optional]

:aspect:`Description`
    **Only if errorHandler == `Fluid`**: Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Templates/`


errorFluidPartialsRootPath
--------------------------

:aspect:`Datatype`
    string [optional]

:aspect:`Description`
    **Only if errorHandler == `Fluid`**: Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Partials/`


errorFluidLayoutsRootPath
-------------------------

:aspect:`Datatype`
    string [optional]

:aspect:`Description`
    **Only if errorHandler == `Fluid`**: Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Layouts/`


errorContentSource
------------------

:aspect:`Datatype`
    string

:aspect:`Description`
    **Only if `errorHandler: Page`**: May be either an External URL or TYPO3 Page that will be fetched with curl and displayed
    in case of an error.

:aspect:`Example`
    `t3://page?uid=123`


errorPhpClassFQCN
-----------------

:aspect:`Datatype`
    string

:aspect:`Description`
    **Only if `errorHandler: PHP`**: Fully qualified class name of a custom error handler implementing `PageErrorHandlerInterface`.

:aspect:`Example`
    `My\Site\Error\Handler`
