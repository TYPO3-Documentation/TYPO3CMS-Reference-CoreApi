.. include:: ../../Includes.txt

.. _deprecation:

===========
Deprecation
===========

Since TYPO3 4.3, calls to deprecated functions are logged to track usage of
deprecated/outdated methods in the TYPO3 Core. Developers have to make sure to adjust their code to avoid
using this old functionality since deprecated methods will be removed in future TYPO3 releases.

.. _deprecation_introduction:

Introduction
============

Deprecations since TYPO3 9 use the PHP method :php:`trigger_error('a message', E_USER_DEPRECATED)` and run
through the logging and exception stack of the TYPO3 core. There are several methods that help extension developers in
dispatching deprecation errors. In development context deprecations are turned into exceptions by default
and ignored in production context.

Therefore calls to deprecated functions within the core are no longer written to their own log file
(:file:`typo3conf/deprecation_xxxxxxx.log`). The deprecation log related methods have been deprecated themselves.

.. hint::
   Even though calls to functions within the core are no longer being written to the old deprecation log
   calls to functions within extensions might still be written to the old deprecation log.

.. _deprecation_disable_errors:

Disabling Deprecation Errors
============================

Deprecation errors are automatically being ignored in production context. If you need to disable them in development
context you can do so in the :file:`AdditionalConfiguration.php`::

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::NOTICE] = [];

For more information on how to configure the writing of deprecation logs see :ref:`logging-configuration-writer`.

.. _deprecation_finding_calls:

Finding Calls to Deprecated Functions
=====================================

The extension scanner which has been introduced with TYPO3 core version 9 as part of the system
management (formerly "Install Tool") provides an interactive interface to scan extension code
for usage of TYPO3 core API which has been removed or deprecated. See :ref:`extension-scanner` for more information.

It is also possible to do a file search for "@deprecated" and "E_USER_DEPRECATED". Then using an IDE you can find all
calls to the affected functions.

.. _deprecate_functions:

Deprecate Functions in Extensions
=================================

Functions that will be removed in future versions of your extension should be marked as deprecated by both the
doc-comment and a call to the PHP error method::

   /**
    * @param array $record
    * @param int $dec
    * @return int
    * @deprecated since version 3.0.4, will be removed in version 4.0.0
    * @codeCoverageIgnore
    */
   public function decreaseColPosCountByRecord(array $record, int $dec = 1): int
   {
      trigger_error(
         'Method "decreaseColPosCountByRecord" is deprecated since version 3.0.4, will be removed in version 4.0.0',
         E_USER_DEPRECATED
      );
      //[ ...]
   }

For more information about how to deprecate classes, arguments and hooks and how the TYPO3 core handles deprecations,
see :ref:`t3contribute:deprecations`.
