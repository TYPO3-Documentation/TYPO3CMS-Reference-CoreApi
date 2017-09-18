.. include:: ../../Includes.txt

.. _error-handling:

============================
Error and Exception Handling
============================

Since version 4.3.0 TYPO3 comes with a build-in error and exception
handling system. Admins can configure how errors and exceptions should
be displayed in the Backend and in the Frontend. Errors and exception can be
logged to all available logging systems of TYPO3 including
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog()` which is – among 
other features – able to send error messages by mail.
See the examples below.

.. rst-class:: compact-list
.. toctree::

   Configuration/Index
   ErrorHandler/Index
   ProductionExceptionHandler/Index
   DebugExceptionHandler/Index
   Examples/Index
   Extending/Index
