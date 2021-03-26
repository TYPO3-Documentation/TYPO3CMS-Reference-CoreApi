.. include:: /Includes.rst.txt
.. index:: pair: Error handling; fluid
.. _sitehandling-errorHandling_fluid:

=========================
Fluid-based error handler
=========================

The fluid-based error handler is defined in
`\TYPO3\CMS\Core\Error\PageErrorHandler\FluidPageErrorHandler
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/core/Classes/Error/PageErrorHandler/FluidPageErrorHandler.php>`__.

Properties
==========

The fluid-based error handler has the properties
:ref:`sitehandling-errorHandling_errorCode` and
:ref:`sitehandling-errorHandling_errorHandler` and the following:

errorFluidTemplate
------------------

:aspect:`Datatype`
    string

:aspect:`Description`
    Path to fluid template file. Path may be

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
    Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Templates/`


errorFluidPartialsRootPath
--------------------------

:aspect:`Datatype`
    string [optional]

:aspect:`Description`
    Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Partials/`


errorFluidLayoutsRootPath
-------------------------

:aspect:`Datatype`
    string [optional]

:aspect:`Description`
    Paths to Fluid Templates, Partials and Layouts in
    case more flexibility is needed.

:aspect:`Example`
    `EXT:sitepackage/Resources/Private/Layouts/`


Examples
========

Shows the content of a Fluid template on error with HTTP status 404.

.. code-block:: yaml

   errorHandling:
     -
       errorCode: 404
       errorHandler: Fluid
       errorFluidTemplate: 'EXT:my_sitepackage/Resources/Private/Templates/Sites/Error.html'
       errorFluidTemplatesRootPath: ''
       errorFluidLayoutsRootPath: ''
       errorFluidPartialsRootPath: 'EXT:my_sitepackage/Resources/Private/Partials/Sites/'
