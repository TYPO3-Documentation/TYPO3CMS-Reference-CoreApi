..  include:: /Includes.rst.txt
..  index::Exceptions; ProductionExceptionHandler
..  _error-handling-production-exception-handler:

============================
Production exception handler
============================

Functionality of the :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler`:

*   Shows brief exception message ("Oops, an error occurred!") using
    :php:`\TYPO3\CMS\Core\Controller\ErrorPageController` and its attendant template.
*   Logs exception messages via the :ref:`logging API <logging>`.
*   Logs exception messages to the sys\_log table. Logged errors are displayed
    in the belog extension (:guilabel:`Admin Tools > Log`). This will only work with an
    existing DB connection.

Depending on the :ref:`Logging writer configuration <logging-configuration-writer>`
the exception output can be found for example in the following locations:

:php:`\TYPO3\CMS\Core\Log\Writer\FileWriter`
    In Composer-based installations the information can be found in directory
    :path:`var/logs/`. In Classic mode installations in :path:`typo3temp/var/logs/`.
:php:`\TYPO3\CMS\Core\Log\Writer\SyslogWriter`
    Logs exception messages to the :sql:`sys_log` table. Logged errors are displayed
    in the backend module :guilabel:`Admin Tools > Log`.

Here you find a complete list of :ref:`Log writers <logging-writers>`.

..  _error-handling-oops-an-error:

Message "Oops, an error occurred!"
==================================

The generic error message "Oops, an error occurred!" is displayed when an
exception or error happens within a TypoScript content object like
:ref:`FLUIDTEMPLATE <t3tsref:cobj-template>` or a plugin. When the exception
affects only one content element or plugin it is displayed in place of that
elements. However, if it affects the content element representing the whole page
like :ref:`FLUIDTEMPLATE <t3tsref:cobj-template>` only a plain page with this text on
it is displayed.

This message is displayed in :ref:`production context <Environment-context>`
instead of a more detailed exception message. The detailed message can then be
found in the log.

..  _error-handling-oops-an-error-detail:

Show detailed exception output
------------------------------

When the frontend debugging is activated, a detailed exception message is output
instead of the generic "Oops, an error occurred!" message.

By default, debugging is enabled in the
:ref:`TYPO3 contexts <Environment-context>` starting with `Development`. It can
also be enabled by setting
:ref:`config.contentObjectExceptionHandler <t3tsref:setup-config-contentObjectExceptionHandler>`
in TypoScript.

..  _error-handling-oops-an-error-detail-admin:

Example: prevent "Oops, an error occurred!" messages for logged-in admins
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    [backend.user.isAdmin]
        config.contentObjectExceptionHandler = 0
    [END]
