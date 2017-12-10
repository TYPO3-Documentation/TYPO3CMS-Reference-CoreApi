.. include:: ../../../Includes.txt


.. _error-handling-debug-exception-handler:

=======================
Debug Exception Handler
=======================

Functions of :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`:

-  Shows detailed exception messages and full trace of an exception.

-  Logs exception messages via the TYPO3 logging framework.

-  Logs exception messages to the sys\_log table. Logged errors are displayed
   in the belog extension (Admin Tools > Log). This will work only if there is
   an existing DB connection.
