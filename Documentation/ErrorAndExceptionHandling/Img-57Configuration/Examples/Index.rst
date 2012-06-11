

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


Examples
^^^^^^^^


Debugging and development setup
"""""""""""""""""""""""""""""""

Veryverboseconfiguration which logs and displays all errors and
exceptions.

[File: localconf.php]

::

   $TYPO3_CONF_VARS['SYS']['displayErrors'] = '1';
   $TYPO3_CONF_VARS['SYS']['devIPmask'] = '*';
   $TYPO3_CONF_VARS['SYS']['errorHandler'] = 't3lib_error_ErrorHandler';
   $TYPO3_CONF_VARS['SYS']['errorHandlerErrors'] = E_ALL ^ E_NOTICE;
   $TYPO3_CONF_VARS['SYS']['exceptionalErrors'] = E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER_ERROR ^ E_USER_NOTICE ^ E_USER_WARNING;
   $TYPO3_CONF_VARS['SYS']['debugExceptionHandler'] = 't3lib_error_DebugExceptionHandler';
   $TYPO3_CONF_VARS['SYS']['productionExceptionHandler'] = 't3lib_error_DebugExceptionHandler';
   $TYPO3_CONF_VARS['SYS']['systemLogLevel'] = '0';
   $TYPO3_CONF_VARS['SYS']['systemLog'] = 'mail,test@localhost.local,4;error_log,,2;syslog,LOCAL0,,3;file,/abs/path/to/logfile.log';
   $TYPO3_CONF_VARS['SYS']['enable_errorDLOG'] = '1';
   $TYPO3_CONF_VARS['SYS']['enable_exceptionDLOG'] = '1';

[File: .htaccess]

::

   php_flag display_errors on
   php_flag log_errors on
   php_value error_log /path/to/php_error.log


Production setup
""""""""""""""""

Example for a production configuration which displays only errors and
exceptions if the devIPmask matches. Errors and exceptions are only
logged if their level is at least 2 (=Warning).

[File: localconf.php]

::

   $TYPO3_CONF_VARS['SYS']['displayErrors'] = '2';
   $TYPO3_CONF_VARS['SYS']['devIPmask'] = '[your.IP.address]';
   $TYPO3_CONF_VARS['SYS']['errorHandler'] = 't3lib_error_ErrorHandler';
   $TYPO3_CONF_VARS['SYS']['systemLogLevel'] = '2';
   $TYPO3_CONF_VARS['SYS']['systemLog'] = 'mail,test@localhost.local,4;error_log,,2;syslog,LOCAL0,,3';
   $TYPO3_CONF_VARS['SYS']['enable_errorDLOG'] = '0';
   $TYPO3_CONF_VARS['SYS']['enable_exceptionDLOG'] = '0';
   $TYPO3_CONF_VARS['SYS']['syslogErrorReporting'] = E_ALL ^ E_NOTICE ^ E_WARNING;
   $TYPO3_CONF_VARS['SYS']['belogErrorReporting'] = '0';

[File: .htaccess]

::

   php_flag display_errors off
   php_flag log_errors on
   php_value error_log /path/to/php_error.log


Performance setup
"""""""""""""""""

Since the error and exception handling and also the logging need some
performance, here's an example how to disable error and exception
handling completely.

[File: localconf.php]

::

   $TYPO3_CONF_VARS['SYS']['displayErrors'] = '0';
   $TYPO3_CONF_VARS['SYS']['devIPmask'] = '';
   $TYPO3_CONF_VARS['SYS']['errorHandler'] = '';
   $TYPO3_CONF_VARS['SYS']['debugExceptionHandler'] = '';
   $TYPO3_CONF_VARS['SYS']['productionExceptionHandler'] = '';
   $TYPO3_CONF_VARS['SYS']['systemLog'] = '';
   $TYPO3_CONF_VARS['SYS']['enable_errorDLOG'] = '0';
   $TYPO3_CONF_VARS['SYS']['enable_exceptionDLOG'] = '0';
   $TYPO3_CONF_VARS['SYS']['syslogErrorReporting'] = '0';
   $TYPO3_CONF_VARS['SYS']['belogErrorReporting'] = '0';

[File: .htaccess]

::

   php_flag display_errors off
   php_flag log_errors off

