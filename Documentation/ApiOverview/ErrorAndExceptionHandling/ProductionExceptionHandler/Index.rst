.. include:: /Includes.rst.txt
.. index::Exceptions; ProductionExceptionHandler
.. _error-handling-production-exception-handler:

============================
Production Exception Handler
============================

Functionality of the :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler`:

-  Shows brief exception message ("Oops, an error occurred!") using
   :php:`TYPO3\CMS\Core\Controller\ErrorPageController` and its attendant template.

-  Logs exception messages via the :ref:`logging API <logging>`.

-  Logs exception messages to the sys\_log table. Logged errors are displayed
   in the belog extension (**ADMIN TOOLS > Log**). This will only work with an
   existing DB connection.
