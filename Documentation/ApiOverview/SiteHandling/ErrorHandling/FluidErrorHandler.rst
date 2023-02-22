..  include:: /Includes.rst.txt
..  index:: pair: Error handling; fluid
..  _sitehandling-errorHandling_fluid:

=========================
Fluid-based error handler
=========================

The Fluid-based error handler is defined in
:t3src:`core/Classes/Error/PageErrorHandler/FluidPageErrorHandler.php`.

Properties
==========

The Fluid-based error handler has the properties
:ref:`sitehandling-errorHandling_errorCode` and
:ref:`sitehandling-errorHandling_errorHandler`, and the following:

..  confval:: errorFluidTemplate

    :type: string
    :Example: `EXT:my_sitepackage/Resources/Private/Templates/Sites/Error.html`

    The path to the Fluid template file. Path may be

    *   absolute
    *   relative to site root
    *   starting with `EXT:` for files from an extension

..  confval:: errorFluidTemplatesRootPath

    :type: string [optional]
    :Example: `EXT:my_sitepackage/Resources/Private/Templates/Sites/`

    The paths to the Fluid templates in case more flexibility is needed.

..  confval:: errorFluidPartialsRootPath

    :type: string [optional]
    :Example: `EXT:my_sitepackage/Resources/Private/Partials/Sites/`

    The paths to the Fluid partials in case more flexibility is needed.

..  confval:: errorFluidLayoutsRootPath

    :type: string [optional]
    :Example: `EXT:my_sitepackage/Resources/Private/Layouts/Sites/`

    The paths to Fluid layouts in case more flexibility is needed.


Example
=======

Show the content of a Fluid template in case of an error with HTTP status 404:

..  literalinclude:: _fluid-error-handler.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

