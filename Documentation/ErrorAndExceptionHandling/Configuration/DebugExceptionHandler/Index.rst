.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _error-handling-debug-exception-handler:

Debug Exception Handler
^^^^^^^^^^^^^^^^^^^^^^^

Functions of :code:`t3lib_error_DebugExceptionHandler`:

- Shows detailed exception messages and full trace of an exception.

- Logs exception messages to :code:`t3lib_div::syslog()` which is able to write
  exception messages to a file, to the web server's error\_log, the
  system's log and it can send you errors and exceptions in an email.
  :code:`t3lib_div::syslog()` offers a hook an can be extended by user-defined
  logging methods.

- Logs exception messages to :code:`t3lib_div::devLog()` if
  `$TYPO3_CONF_VARS[SYS][enable_errorDLOG]` is enabled (depending on the devlog extension
  used, this might require an existing DB connection).

- Logs exception messages to the sys\_log table. Logged errors are
  displayed in the belog extension (Admin Tools > Log) (works only if there is
  an existing DB connection).
