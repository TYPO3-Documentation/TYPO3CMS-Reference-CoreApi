.. include:: ../../../Includes.txt


.. _error-handling-debug-exception-handler:

=======================
Debug Exception Handler
=======================

Functions of :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`:

-  Shows detailed exception messages and full trace of an exception.

-  Logs exception messages to
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` which is able to
   write exception messages to a file, to the web server's error\_log, the
   system's log and it can send you errors and exceptions in an email.
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` offers a hook an can
   be extended by userdefined logging methods.

-  Logs exception messages to
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::devLog()` if
   :php:`$TYPO3_CONF_VARS[SYS][enable_errorDLOG]` is enabled. Depending on
   which devlog extension is used this may require an existing DB connection.

-  Logs exception messages to the sys\_log table. Logged errors are displayed
   in the belog extension (Admin Tools > Log). This will work only if there is
   an existing DB connection.
