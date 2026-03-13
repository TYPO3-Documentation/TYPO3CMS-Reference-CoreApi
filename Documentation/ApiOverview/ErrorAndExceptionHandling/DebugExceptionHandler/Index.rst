.. include:: /Includes.rst.txt
.. index:: Exceptions; DebugExceptionHandler
.. _error-handling-debug-exception-handler:

=======================
Debug exception handler
=======================

Functions of :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`:

-  Shows detailed exception messages and full trace of an exception.

-  Logs exception messages via the :ref:`TYPO3 logging framework <logging>`.

-  Logs exception messages to the `sys_log` table. Logged errors are displayed
   in the belog extension (:guilabel:`Administration > Log`). This will work only if there is
   an existing DB connection.
