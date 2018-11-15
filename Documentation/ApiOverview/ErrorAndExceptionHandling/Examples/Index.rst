.. include:: ../../../Includes.txt


.. _error-handling-configuration-examples:

========
Examples
========

.. _error-handling-configuration-examples-debug:

Debugging and development setup
===============================

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
      'systemLogLevel' => '0',
      'systemLog' => true,
   ),

You can also use the "Debug" preset in the Settings module "Configuration presets". 


In :file:`.htaccess`::

   php_flag display_errors on
   php_flag log_errors on
   php_value error_log /path/to/php_error.log

TypoScript::

   config.contentObjectExceptionHandler = 0 
   
Use this setting, to get more context and a stacktrace in the Frontend in case of an exception.
See :ref:`contentObjectExceptionHandler <t3tsref:setup-config-contentObjectExceptionHandler>` for more
information.


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
      'systemLogLevel' => '2',
      'systemLog' => true,
      'syslogErrorReporting' => E_ALL ^ E_NOTICE ^ E_WARNING,
      'belogErrorReporting' => '0',
   ),

You can also use the "Live" preset in the Settings module "Configuration presets". 

In :file:`.htaccess`::

   php_flag display_errors off
   php_flag log_errors on
   php_value error_log /path/to/php_error.log


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
      'systemLog' => false,
      'syslogErrorReporting' => '0',
      'belogErrorReporting' => '0',
   ),


In :file:`.htaccess`::

   php_flag display_errors off
   php_flag log_errors off
