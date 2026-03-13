.. include:: /Includes.rst.txt
.. index:: Errors; ErrorHandler
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

-  Logs error messages  via the :ref:`logging API <logging>`.

-  Logs error messages to the sys\_log table. Logged errors are displayed
   in the belog extension (:guilabel:`Administration > Log`). This will work only with an
   existing DB connection.
