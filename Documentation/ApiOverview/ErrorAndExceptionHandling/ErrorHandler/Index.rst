.. include:: ../../../Includes.txt


.. _error-handling-error-handler:

=============
Error Handler
=============

Class :php:`\TYPO3\CMS\Core\Error\ErrorHandler` is the default error handler in
TYPO3.

Functions:

-  Can be registered for all PHP errors or for only a subset of the PHP errors
   which will then be handled by an error handler.

-  Displays error messages as flash messages in the Backend (if
   exceptionHandler is set to
   :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`).
   Since flash messages are integrated in the Backend template, PHP messages
   will not destroy the Backend layout.

-  Displays errors as TsLog messages in the adminpanel.

-  Logs error messages to
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` which is able to
   write error messages to a file, to the web server's error\_log, the system's
   log and it can send error- and exception-messages by mail.
   :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` offers a hook and
   can be extended by userdefined logging methods.


-  Logs error messages to the sys\_log table. Logged errors are displayed
   in the belog extension (Admin Tools > Log). This will work only with an
   existing DB connection.
