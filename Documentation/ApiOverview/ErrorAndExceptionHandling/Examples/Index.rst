.. include:: /Includes.rst.txt
.. _error-handling-configuration-examples:

========
Examples
========

.. index:: Errors; Debugging setup
.. _error-handling-configuration-examples-debug:

Debugging and development setup
===============================

.. important::
   Do not use **debug / development setup** in production. This setup generates error
   messages in the Frontend and a number of log messages for low severity errors.
   The messages in the Frontend will be visible to the user, give a potential attacker
   more information about your system and the logging will fill your filesystem / DB,
   which degrades performance and can potentially be used to bring down your system
   by filling storage with log messages. See :ref:`security-staging-servers` for more
   information.

Very verbose configuration which logs and displays all errors and
exceptions.

In :file:`LocalConfiguration.php`::

   'SYS' => array(
      'displayErrors' => '1',
      'devIPmask' => '*',
      'errorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
      'errorHandlerErrors' => E_ALL ^ E_NOTICE,
      'exceptionalErrors' => E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER_ERROR ^ E_USER_NOTICE ^ E_USER_WARNING,
      'debugExceptionHandler' => 'TYPO3\\CMS\\Core\\Error\\DebugExceptionHandler',
      'productionExceptionHandler' => 'TYPO3\\CMS\\Core\\Error\\DebugExceptionHandler',
   ),

You can also use the "Debug" preset in the Settings module "Configuration presets".


In :file:`.htaccess`::

   php_flag display_errors on
   php_flag log_errors on
   php_value error_log /path/to/php_error.log


TypoScript::

   config.contentObjectExceptionHandler = 0

Use this setting, to get more context and a stacktrace in the Frontend in case of an exception.

.. important::
   Do not set `config.contentObjectExceptionHandler` to 0 in production. It will
   display a complete stack dump in the Frontend, when an exception occurs. Use
   `config.contentObjectExceptionHandler = 1`, which is the default, in production.

See :ref:`contentObjectExceptionHandler <t3tsref:setup-config-contentObjectExceptionHandler>` for more
information.


.. index:: Errors; Production setup
.. _error-handling-configuration-examples-production:

Production setup
================

Example for a production configuration which displays only errors and
exceptions if the devIPmask matches. Errors and exceptions are only
logged if their level is at least 2 (=Warning).

In :file:`LocalConfiguration.php`::

   'SYS' => array(
      'displayErrors' => '2',
      'devIPmask' => '[your.IP.address]',
      'errorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
      'belogErrorReporting' => '0',
   ),

You can also use the "Live" preset in the Settings module "Configuration presets".

In :file:`.htaccess`::

   php_flag display_errors off
   php_flag log_errors on
   php_value error_log /path/to/php_error.log


.. index:: Errors; Performance setup
.. _error-handling-configuration-examples-performance:

Performance setup
=================

Since the error and exception handling and also the logging need some
performance, here's an example how to disable error and exception
handling completely.

In :file:`LocalConfiguration.php`::

   'SYS' => array(
      'displayErrors' => '0',
      'devIPmask' => '',
      'errorHandler' => '',
      'debugExceptionHandler' => '',
      'productionExceptionHandler' => '',
      'belogErrorReporting' => '0',
   ),


In :file:`.htaccess`::

   php_flag display_errors off
   php_flag log_errors off

