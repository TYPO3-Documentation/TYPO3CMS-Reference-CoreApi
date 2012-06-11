

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


t3lib\_error\_DebugExceptionHandler
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Functions of t3lib\_error\_DebugExceptionHandler

- Shows detailed exception messages and full trace of an exception

- Logs exception messages to t3lib\_div::syslog() which is able to write
  exception messages to a file, to the web server's error\_log, the
  system's log and it can send you errors and exceptions in an email.
  t3lib\_div::syslog() offers a hook an can be extended by user-defined
  logging methods.

- Logs exception messages to t3lib\_div::devlog() if
  “enable\_exceptionDLOG” is enabled (depending on the devlog extension
  used, this might require an existing DB connection).

- Logs exception messages to the sys\_log table. Logged errors are
  displayed in the belog extension (Tools->Log) (works only if there is
  an existing DB connection).

