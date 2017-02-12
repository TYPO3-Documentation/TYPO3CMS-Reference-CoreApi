.. include:: ../../../Includes.txt


.. _error-handling-error-handler:

Error Handler
^^^^^^^^^^^^^

Class :code:`\TYPO3\CMS\Core\Error\ErrorHandler` is the default error handler in
TYPO3.

Functions:

- Can be registered for all, or for only a subset of the PHP errors
  which can be handled by an error handler

- Displays error messages as flash messages in the Backend (if
  exceptionHandler is set to :code:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`).
  Since flash messages are integrated in the Backend template, PHP
  messages will not destroy the Backend layout.

- Displays errors as TsLog messages in the adminpanel.

- Logs error messages to :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` which is able to write
  error messages to a file, to the web server's error\_log, the system's
  log and it can send you errors and exceptions in an email.
  :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` offers a hook and can be extended by user-defined
  logging methods.

- Logs error messages to :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::devLog()` if `$TYPO3_CONF_VARS[SYS][enable_errorDLOG]` is
  enabled (depending on the devlog extension used, this might require an
  existing DB connection).

- Logs error messages to the sys\_log table. Logged errors are displayed
  in the belog extension (Admin Tools > Log) (works only if there is an
  existing DB connection).
