.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _error-handling-configuration:

Configuration
-------------

All configuration options related to error and exception handling are
found in :code:`$TYPO3_CONF_VARS[SYS]`:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Data type,20: Data type
   :Description,60: Description

 - :Key:
         displayErrors
   :Data type:
         integer
   :Description:
         Configures whether PHP errors should be displayed.

         - 0 = Do not display any PHP error messages. Overrides the value of
           "exceptionalErrors" and sets it to 0 (= no errors are turned into
           exceptions),the configured :code:`productionExceptionHandler` is used as
           exception handler

         - 1 = Display error messages with the registered error handler,the
           configured :code:`debugExceptionHandler` is used as exception handler

         - 2 = Display errors only if client matches
           :code:`$TYPO3_CONF_VARS[SYS][devIPmask]`. If devIPmask matches the users IP
           address the configured "debugExceptionHandler" is used for exceptions,
           if not "productionExceptionHandler" will be used.

         - -1 = Default setting. With this option, you can override the PHP
           setting :code:`display_errors`. If :code:`devIPmask` matches the users IP address
           the configured :code:`debugExceptionHandler` is used for exceptions, if not
           :code:`productionExceptionHandler` will be used.


 - :Key:
         errorHandler
   :Data type:
         string
   :Description:
         Classname to handle PHP errors. Leave empty to disable error handling.

         Default: :code:`\TYPO3\CMS\Core\Error\ErrorHandler`. This class will register itself
         as error handler. It is able to write error messages to all available
         logging systems in TYPO3 (:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::syslog`,
         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::devlog()` and
         to the "sys\_log" table).

         Additionally the errors can be displayed as flash messages in the
         Backend or in the adminpanel in Frontend. The flash messages in
         Backend are only displayed if the error and exception handling is in
         "debug-mode", which is the case when the configured
         "debugExceptionHandler" is registered as exception handler (see:
         :code:`$TYPO3_CONF_VARS[SYS][displayErrors]`).

         Errors which are registered as "exceptionalErrors" will be turned into
         exceptions (to be handled by the configured exceptionHandler).


 - :Key:
         errorHandlerErrors
   :Data type:
         integer
   :Description:
         The :code:`E_*` constant that will be handled by the error handler

         Default: :code:`E_ALL ^ E_NOTICE`


 - :Key:
         exceptionalErrors
   :Data type:
         integer
   :Description:
         The :code:`E_*` constant that will be handled as an exception by the error
         handler.

         Default: :code:`E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER\_ERROR ^ E_USER\_NOTICE ^ E_USER\_WARNING`
         (4341) and "0" if :code:`$TYPO3_CONF_VARS[SYS][displayErrors] = 0`.

         Refer to the PHP documentation for more details on this value.


 - :Key:
         productionExceptionHandler
   :Data type:
         string
   :Description:
         Classname to handle exceptions that might happen in the TYPO3-code.

         Leave empty to disable exception handling.

         Default: :code:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler`. This
         exception handler displays a nice error message when something went
         wrong. The error message is logged to the configured logs.

         .. note::

            The configured productionExceptionHandler is used if
            :code:`$TYPO3_CONF_VARS[SYS][displayErrors]` is set to "0" or to "-1"
            and :code:`$TYPO3_CONF_VARS[SYS][devIPmask]` doesn't match.


 - :Key:
         debugExceptionHandler
   :Data type:
         string
   :Description:
         Classname to handle exceptions that might happen in the TYPO3 code.

         Leave empty to disable exception handling.

         Default: :code:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`. This exception
         handler displays the complete stack trace of any encountered
         exception. The error message and the stack trace is logged to the
         configured logs.

         .. note::

            The configured debugExceptionHandler is used if
            :code:`$TYPO3_CONF_VARS[SYS][displayErrors]` is set to "1" or
            if :code:`$TYPO3_CONF_VARS[SYS][displayErrors]` is "-1" or "2" and
            the :code:`$TYPO3_CONF_VARS[SYS][devIPmask]` matches.


 - :Key:
         enable_errorDLOG
   :Data type:
         boolean
   :Description:
         Whether errors should be written to the Developer's Log (requires an
         installed \*devlog extension).


 - :Key:
         enable_exceptions
   :Data type:
         boolean
   :Description:
         Whether exceptions should be written to the Developer's Log (requires an
         installed \*devlog extension).


 - :Key:
         syslogErrorReporting
   :Data type:
         integer
   :Description:
         Configures which PHP errors should be logged to the configured syslogs
         (see: [SYS][systemLog]). If set to "0" no PHP errors are logged to the
         syslog.

         Default: :code:`E_ALL ^ E_NOTICE` (6135).


 - :Key:
         belogErrorReporting
   :Data type:
         integer
   :Description:
         Configures which PHP errors should be logged to the "sys\_log" table
         (extension: belog). If set to "0" no PHP errors are logged to the
         "sys\_log" table.

         Default: :code:`E_ALL ^ E_NOTICE` (6135).


- :Key:
         systemLog
   :Data type:
         string
   :Description:
         Configures which mechanism is used to log errors being logged using
         GeneralUtility::sysLog() calls. Multiple settings are possible by
         separating them with a semicolon.
         
         Every distinct option can contain up to three values separated by
         comma. The first option defines the mechanism which is used for logging.
         The second option defines the destination/target of the log message.
         The third option defines a severity level. Messages will get logged
         to the mechanism/target only if the severity of the message is higher
         than the specified level. Giving "0" as level or not giving a level at all
         will log all messages. Possible options are:

         - file,<abs-path-to-file>[,<level>] = Writes the error messages to the
           specified file.

         - mail,<to>[/<from>][,<level>] = Sends an email for every error message
           to the configured email "<to>". Additionally sets the e-mail From
           header.

         - syslog,<facility>[,<level>] = Uses the PHP method "syslog" (http://php.net/manual/en/function.syslog.php)
           to send the log message. Depending on the operating system the message
           will get logged in different ways. On Linux (Debian, Ubuntu) the message
           will usually appear in /var/log/syslog if not configured otherwise.
           The <facility> option is not used currently.

         - error_log[,,<level>] = This setting will use the PHP method "error_log"
           (http://php.net/manual/en/function.error-log.php) to log the message.
           The message will get handled according to the settings of the variable
           "error_log" in the php.ini file (http://php.net/manual/en/errorfunc.configuration.php#ini.error-log).
           
         Using the method "file" is very reliable but could also pose a security
         risk if you write error logs into the webroot of your site. The option
         "error_log" allows to use the same logging facility which is by default
         used by PHP scripts on the server. Be aware that on production machines
         error logging for PHP scripts could be disabled.


The table below shows which values can be set by the user and which
are set by TYPO3.

Values in plain text can be changed in localconf.php.

**Values in bold are set by TYPO3.**

+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
| displayErrors | errorHandlerErrors | exceptionalErrors | errorHandler   | devIPmask | exceptionHandler            | display\_errors |
|               |                    |                   |                |           |                             |    (php\_ini)   |
+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|     -1        | E_ALL ^ E_NOTICE   | E_ALL ^ E_NOTICE  | \TYPO3\CMS     | Matters   | If devIPmask matches:       | Not changed     |
|               |                    | ^ E_WARNING       | \Core\Error    |           | debugExceptionHandler       |                 |
|               |                    | ^ E_USER\_ERROR   | \ErrorHandler  |           |                             |                 |
|               |                    | ^ E_USER\_NOTICE  |                |           | |                           |                 |
|               |                    |                   |                |           |                             |                 |
|               |                    |                   |                |           | If devIPmask doesn't match: |                 |
|               |                    |                   |                |           | productionExceptionHandler  |                 |
+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|      0        | E_ALL ^ E_NOTICE   | **0**             | \TYPO3\CMS     | Doesn't   | production                  | **0 (Off)**     |
|               |                    | **(no errors are  | \Core\Error    | matter    | ExceptionHandler            |                 |
|               |                    | turned into       | \ErrorHandler  |           |                             |                 |
|               |                    | exceptions)**     |                |           |                             |                 |
+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|      1        | E_ALL ^ E_NOTICE   | E_ALL ^ E_NOTICE  | \TYPO3\CMS     | Doesn't   | debugException              | **1 (On)**      |
|               |                    | ^ E_WARNING       | \Core\Error    | matter    | Handler                     |                 |
|               |                    | ^ E_USER\_ERROR   | \ErrorHandler  |           |                             |                 |
|               |                    | ^ E_USER\_NOTICE  |                |           |                             |                 |
|               |                    | ^ E_USER\_WARNING |                |           |                             |                 |
+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|      2        | E_ALL ^ E_NOTICE   | E_ALL ^ E_NOTICE  | \TYPO3\CMS     | Matters   | If devIPmask matches:       | **1 (On)**      |
|               |                    | ^ E_WARNING       | \Core\Error    |           | debugExceptionHandler       |                 |
|               |                    | ^ E_USER\_ERROR   | \ErrorHandler  |           |                             | |               |
|               |                    | ^ E_USER\_NOTICE  |                |           | |                           | |               |
|               |                    | ^ E_USER\_WARNING |                |           |                             |                 |
|               |                    |                   |                |           | If devIPmask doesn't match: | **0 (Off)**     |
|               |                    |                   |                |           | productionExceptionHandler  |                 |
+---------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+


The following sections highlight the roles and goals of the various classes
related to error and exception handling. Examples and custom handlers are also
discussed.

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   ErrorHandler/Index
   ProductionExceptionHandler/Index
   DebugExceptionHandler/Index
   Examples/Index
   Extending/Index
