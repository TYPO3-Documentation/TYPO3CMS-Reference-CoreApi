

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


t3lib\_error\_ErrorHandler
^^^^^^^^^^^^^^^^^^^^^^^^^^

The class t3lib\_error\_ErrorHandler is the default error handler in
TYPO3.

Functions:

- Can be registered for all, or for only a subset of the PHP errors
  which can be handled by an error handler

- Displays error messages as flash messages in the Backend (if
  exceptionHandler is set to “t3lib\_error\_DebugExceptionHandler”).
  Since flash messages are integrated in the Backend template, PHP
  messages will not destroy the Backend layout.

- Displays errors as TsLog messages in the adminpanel.

- Logs error messages to t3lib\_div::syslog() which is able to write
  error messages to a file, to the web server's error\_log, the system's
  log and it can send you errors and exceptions in an email.
  t3lib\_div::syslog() offers a hook and can be extended by user-defined
  logging methods.

- Logs error messages to t3lib\_div::devLog() if “enable\_errorDLOG” is
  enabled (depending on the devlog extension used, this might require an
  existing DB connection).

- Logs error messages to the sys\_log table. Logged errors are displayed
  in the belog extension (Tools->Log) (works only if there is an
  existing DB connection).

