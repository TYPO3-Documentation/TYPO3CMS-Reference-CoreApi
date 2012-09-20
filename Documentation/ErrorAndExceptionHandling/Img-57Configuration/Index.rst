.. include:: Images.txt

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


|img-57| Configuration
----------------------

All configuration options related to error and exception handling are
found in $TYPO3\_CONF\_VARS[SYS]:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key

   Datatype
         Datatype

   Description
         Description


.. container:: table-row

   Key
         displayErrors

   Datatype
         integer

   Description
         Configures whether PHP errors should be displayed.

         - 0 = Do not display any PHP error messages. Overrides the value of
           "exceptionalErrors" and sets it to 0 (= no errors are turned into
           exceptions),the configured "productionExceptionHandler" is used as
           exception handler

         - 1 = Display error messages with the registered error handler,the
           configured "debugExceptionHandler" is used as exception handler

         - 2 = Display errors only if client matches
           TYPO3\_CONF\_VARS[SYS][devIPmask]. If devIPmask matches the users IP
           address the configured "debugExceptionHandler" is used for exceptions,
           if not "productionExceptionHandler" will be used.

         - -1 = Default setting. With this option, you can override the PHP
           setting "display\_errors". If devIPmask matches the users IP address
           the configured "debugExceptionHandler" is used for exceptions, if not
           "productionExceptionHandler" will be used.


.. container:: table-row

   Key
         errorHandler

   Datatype
         string

   Description
         Classname to handle PHP errors. Leave empty to disable error handling.

         Default: "t3lib\_error\_ErrorHandler". This class will register itself
         as error handler. It is able to write error messages to all available
         logging systems in TYPO3 (t3lib\_div::syslog, t3lib\_div::devlog() and
         to the sys\_log table).

         Additionally the errors can be displayed as flash messages in the
         Backend or in the adminpanel in Frontend. The flash messages in
         Backend are only displayed if the error and exception handling is in
         "debug-mode", which is the case when the configured
         "debugExceptionHandler" is registered as exception handler (see:
         TYPO3\_CONF\_VARS[SYS][displayErrors]).

         Errors which are registered as "exceptionalErrors" will be turned into
         exceptions (to be handled by the configured exceptionHandler).


.. container:: table-row

   Key
         errorHandlerErrors

   Datatype
         integer

   Description
         The E\_\* constant that will be handled by the error handler

         Default: E\_ALL ^ E\_NOTICE


.. container:: table-row

   Key
         exceptionalErrors

   Datatype
         integer

   Description
         The E\_\* constant that will be handled as an exception by the error
         handler.

         Default: "E\_ALL ^ E\_NOTICE ^ E\_WARNING ^ E\_USER\_ERROR ^
         E\_USER\_NOTICE ^ E\_USER\_WARNING" (4341) and "0" if displayError=0.

         Refer to the PHP documentation for more details on this value.


.. container:: table-row

   Key
         productionExceptionHandler

   Datatype
         string

   Description
         Classname to handle exceptions that might happen in the TYPO3-code.

         Leave empty to disable exception handling.

         **Default** : "t3lib\_error\_ProductionExceptionHandler". This
         exception handler displays a nice error message when something went
         wrong. The error message is logged to the configured logs.

         **Note** : The configured productionExceptionHandler is used if
         displayErrors is set to "0" or to "-1" and devIPmask doesn't match.


.. container:: table-row

   Key
         debugExceptionHandler

   Datatype
         string

   Description
         Classname to handle exceptions that might happen in the TYPO3-code.

         Leave empty to disable exception handling.

         **Default** : "t3lib\_error\_DebugExceptionHandler". This exception
         handler displays the complete stack trace of any encountered
         exception. The error message and the stack trace is logged to the
         configured logs.

         **Note** : The configured debugExceptionHandler is used if
         displayErrors is set to "1" and if displayErrors is "-1" or "2" and
         the devIPmask matches.


.. container:: table-row

   Key
         enable\_errorDLOG

   Datatype
         boolean

   Description
         Whether errors should be written to the developer log (requires an
         installed \*devlog extension).


.. container:: table-row

   Key
         enable\_exceptionDLOG

   Datatype
         boolean

   Description
         Whether exceptions should be written to the developer log (requires an
         installed \*devlog extension).


.. container:: table-row

   Key
         syslogErrorReporting

   Datatype
         integer

   Description
         Configures which PHP errors should be logged to the configured syslogs
         (see: [SYS][systemLog]). If set to "0" no PHP errors are logged to the
         syslog. Default is "E\_ALL ^ E\_NOTICE" (6135).


.. container:: table-row

   Key
         belogErrorReporting

   Datatype
         integer

   Description
         Configures which PHP errors should be logged to the "syslog" table
         (extension: belog). If set to "0" no PHP errors are logged to the
         sys\_log table. Default is "E\_ALL ^ E\_NOTICE" (6135).


.. ###### END~OF~TABLE ######

The table below shows which values can be set by the user and which
are set by TYPO3.

Values in black can be changed in localconf.php.

Values in red are set by TYPO3.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   displayErrors
         display


         Errors

   errorHandlerErrors
         errorHandler


         Errors

   exceptionalErrors
         exceptionalErrors

   errorHandler
         errorHandler

   devIPmask
         devIP


         mask

   exceptionHandler
         exception


         Handler

   display\_errors (php\_ini)
         display\_


         errors (php\_ini)


.. container:: table-row

   displayErrors
         -1

   errorHandlerErrors
         E\_ALL

         ^ E\_NOTICE

   exceptionalErrors
         E\_ALL

         ^ E\_NOTICE

         ^ E\_WARNING

         ^ E\_USER\_ERROR

         ^ E\_USER\_NOTICE

         ^ E\_USER\_WARNING

   errorHandler
         t3lib\_error\_ErrorHandler

   devIPmask
         match

   exceptionHandler
         $TYPO3\_CONF\_VARS['SYS']['debugExceptionHandler']

   display\_errors (php\_ini)
         Not changed


.. container:: table-row

   displayErrors
         no match

   errorHandlerErrors
         $TYPO3\_CONF\_VARS['SYS']['productionExceptionHandler']


.. container:: table-row

   displayErrors
         0

   errorHandlerErrors
         E\_ALL

         ^ E\_NOTICE

   exceptionalErrors
         0 (no errors are turned into exceptions)

   errorHandler
         t3lib\_error\_ErrorHandler

   devIPmask
         Doesn't matter

   exceptionHandler
         $TYPO3\_CONF\_VARS['SYS']['productionExceptionHandler']

   display\_errors (php\_ini)
         0 (Off)


.. container:: table-row

   displayErrors
         1

   errorHandlerErrors
         E\_ALL

         ^ E\_NOTICE

   exceptionalErrors
         E\_ALL

         ^ E\_NOTICE

         ^ E\_WARNING

         ^ E\_USER\_ERROR

         ^ E\_USER\_NOTICE

         ^ E\_USER\_WARNING

   errorHandler
         t3lib\_error\_ErrorHandler

   devIPmask
         Doesn't matter

   exceptionHandler
         $TYPO3\_CONF\_VARS['SYS']['debugExceptionHandler']

   display\_errors (php\_ini)
         1 (On)


.. container:: table-row

   displayErrors
         2

   errorHandlerErrors
         E\_ALL

         ^ E\_NOTICE

   exceptionalErrors
         E\_ALL

         ^ E\_NOTICE

         ^ E\_WARNING

         ^ E\_USER\_ERROR

         ^ E\_USER\_NOTICE

         ^ E\_USER\_WARNING

   errorHandler
         t3lib\_error\_ErrorHandler

   devIPmask
         match

   exceptionHandler
         $TYPO3\_CONF\_VARS['SYS']['debugExceptionHandler']

   display\_errors (php\_ini)
         1 (On)


.. container:: table-row

   displayErrors
         no match

   errorHandlerErrors
         $TYPO3\_CONF\_VARS['SYS']['productionExceptionHandler']

   exceptionalErrors
         0 (Off)


.. ###### END~OF~TABLE ######


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   T3libErrorErrorhandler/Index
   T3libErrorProductionexceptionhandler/Index
   T3libErrorDebugexceptionhandler/Index
   Examples/Index
   ExtendingTheErrorAndExceptionHandling/Index

