..  include:: /Includes.rst.txt

..  index::
    Errors; Configuration
    Exceptions; Configuration
    TYPO3_CONF_VARS; SYS
..  _error-handling-configuration:

=============
Configuration
=============

.. contents::
   :depth: 1
   :local:

Via the :abbr:`GUI (Graphical User Interface)`
==============================================

You can configure the most important settings for live or debug error
handling in the presets:

:guilabel:`System > Settings > Configuration Presets > Debug Settings`

..  include:: /Images/ManualScreenshots/Backend/DebugConfigurationPresets.rst.txt

For more fine-grained error handling you can change various settings in:

:guilabel:`System > Settings > Configure Installation-Wide Options > SYS`


Via configuration files
=======================

It is also possible to write changes manually into the configuration file
:file:`config/system/settings.php` or
:file:`config/system/additional.php`.
Most configuration options related to error and exception handling are
part of :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']`.

The following configuration values are of interest:

:confval:`$GLOBALS['TYPO3_CONF_VARS']['BE']['debug']`
    If enabled, the login refresh is disabled and pageRenderer is set to debug
    mode. Furthermore the fieldname is appended to the label of fields.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] <typo3-conf-vars-fe-debug>`
    If enabled, the total parse time of the page is added as HTTP response
    header :html:`X-TYPO3-Parsetime`.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']`
    Defines a list of IP addresses which will allow development output to
    display. Setting to "*" will allow all. Setting it to an empty string
    allows none.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']`
    Configures whether PHP errors or Exceptions should be displayed.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler']`
    Classname to handle PHP errors. Leave empty to disable error handling.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors']`
    The :php:`E_*` constants that will be handled by the error handler.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors']`
    The :php:`E_*` constant that will be converted into an exception by
    the default errorHandler.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler']`
    The default exception handler displays
    a nice error message when something goes wrong. The error message is
    logged to the configured logs.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler']`
    The default debug exception handler displays
    the complete stack trace of any encountered
    exception. The error message and the stack trace is logged to the
    configured logs.

:confval:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting']`
    Configures which PHP errors should be logged to the :sql:`sys_log` table.

..  seealso::

    `PHP predefined constants for errors and logging
    <https://www.php.net/manual/en/errorfunc.constants.php>`__


Exception handler for rendering TypoScript content objects
==========================================================

Exceptions which occur during rendering of content objects (typically plugins)
will be caught by default in production context and an error message is shown
along with the rendered output. For more information and examples have a look
into the TypoScript reference for
:ref:`config.contentObjectExceptionHandler <t3tsref:setup-config-contentObjectExceptionHandler>`.
