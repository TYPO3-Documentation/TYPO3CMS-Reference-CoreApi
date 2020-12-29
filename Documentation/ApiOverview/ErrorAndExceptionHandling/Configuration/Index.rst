.. include:: /Includes.rst.txt

.. index::
   Errors; Configuration
   Exceptions; Configuration
   TYPO3_CONF_VARS; SYS
.. _error-handling-configuration:

=============
Configuration
=============

All configuration options related to error and exception handling are
part of :php:`$GLOBALS['TYPO3_CONF_VARS'][SYS]`:

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
           exceptions),the configured :php:`productionExceptionHandler` is used as
           exception handler

         - 1 = Display error messages with the registered error handler, the
           configured :php:`debugExceptionHandler` is used as exception handler

         - -1 = Default setting. With this option, you can override the PHP
           setting :php:`display_errors`. If :php:`devIPmask` matches the users IP address
           the configured :php:`debugExceptionHandler` is used for exceptions, if not
           :php:`productionExceptionHandler` will be used.


 - :Key:
         errorHandler
   :Data type:
         string
   :Description:
         Classname to handle PHP errors. Leave empty to disable error handling.

         Default: :php:`\TYPO3\CMS\Core\Error\ErrorHandler`. This class will register itself
         as error handler. It is able to write error messages to all available
         logging systems in TYPO3. See :ref:`logging` for more.

         Additionally the errors can be displayed as flash messages in the
         Backend or in the adminpanel in Frontend. The flash messages in
         Backend are only displayed if the error and exception handling is in
         "debug-mode", which is the case when the configured
         "debugExceptionHandler" is registered as exception handler (see:
         :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']`).

         Errors which are registered as "exceptionalErrors" will be turned into
         exceptions (to be handled by the configured exceptionHandler).


 - :Key:
         errorHandlerErrors
   :Data type:
         integer
   :Description:
         The :php:`E_*` constant that will be handled by the error handler

         Default: :php:`E_ALL ^ E_NOTICE`


 - :Key:
         exceptionalErrors
   :Data type:
         integer
   :Description:
         The :php:`E_*` constant that will be handled as an exception by the error
         handler.

         Default: :php:`E_ALL ^ E_NOTICE ^ E_WARNING ^ E_USER_ERROR ^ E_USER_NOTICE ^ E_USER_WARNING`
         (4341) and "0" if :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 0`.

         Refer to the PHP documentation for more details on this value.


 - :Key:
         productionExceptionHandler
   :Data type:
         string
   :Description:
         Classname to handle exceptions that might happen in the TYPO3-code.

         Leave empty to disable exception handling.

         Default: :php:`\TYPO3\CMS\Core\Error\ProductionExceptionHandler`. This
         exception handler displays a nice error message when something went
         wrong. The error message is logged to the configured logs.

         .. note::

            The configured productionExceptionHandler is used if
            :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']` is set to "0" or to "-1"
            and :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']` doesn't match.


 - :Key:
         debugExceptionHandler
   :Data type:
         string
   :Description:
         Classname to handle exceptions that might happen in the TYPO3 code.

         Leave empty to disable exception handling.

         Default: :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`. This exception
         handler displays the complete stack trace of any encountered
         exception. The error message and the stack trace is logged to the
         configured logs.

         .. note::

            The configured debugExceptionHandler is used if
            :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']` is set to "1" or
            if :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors']` is "-1" or "2" and
            the :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']` matches.

 - :Key:
         belogErrorReporting
   :Data type:
         integer
   :Description:
         Configures which PHP errors should be logged to the "sys\_log" table
         (extension: belog). If set to "0" no PHP errors are logged to the
         "sys\_log" table.

         Default: :php:`E_ALL ^ E_NOTICE` (6135).




The table below shows which values can be set by the user and which
are set by TYPO3.

Values in plain text can be changed in LocalConfiguration.php.

**Values in bold are set by TYPO3.**

+-------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|displayErrors| errorHandlerErrors | exceptionalErrors | errorHandler   | devIPmask | exceptionHandler            | display\_errors |
|             |                    |                   |                |           |                             |    (php\_ini)   |
+=============+====================+===================+================+===========+=============================+=================+
|    -1       | E_ALL ^ E_NOTICE   | E_ALL ^ E_NOTICE  | \TYPO3\CMS     | Matters   | If devIPmask matches:       | Not changed     |
|             |                    | ^ E_WARNING       | \Core\Error    |           | debugExceptionHandler       |                 |
|             |                    | ^ E_USER\_ERROR   | \ErrorHandler  |           |                             |                 |
|             |                    | ^ E_USER\_NOTICE  |                |           +-----------------------------+-----------------+
|             |                    |                   |                |           | If devIPmask doesn't match: | Not changed     |
|             |                    |                   |                |           | productionExceptionHandler  |                 |
+-------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|     0       | E_ALL ^ E_NOTICE   | **0**             | \TYPO3\CMS     | Doesn't   | production                  | **0 (Off)**     |
|             |                    | **(no errors are  | \Core\Error    | matter    | ExceptionHandler            |                 |
|             |                    | turned into       | \ErrorHandler  |           |                             |                 |
|             |                    | exceptions)**     |                |           |                             |                 |
+-------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+
|     1       | E_ALL ^ E_NOTICE   | E_ALL ^ E_NOTICE  | \TYPO3\CMS     | Doesn't   | debugException              | **1 (On)**      |
|             |                    | ^ E_WARNING       | \Core\Error    | matter    | Handler                     |                 |
|             |                    | ^ E_USER\_ERROR   | \ErrorHandler  |           |                             |                 |
|             |                    | ^ E_USER\_NOTICE  |                |           |                             |                 |
|             |                    | ^ E_USER\_WARNING |                |           |                             |                 |
+-------------+--------------------+-------------------+----------------+-----------+-----------------------------+-----------------+

.. seealso::

   `PHP predefined constants for errors and logging
   <http://php.net/manual/en/errorfunc.constants.php>`__

.. tip::

   Search for **php error calculator** in the web.

..index:: Errors; PHP constants

*PHP constants:*

.. code-block:: none

       1  E_ERROR            Fatal run-time errors.
       2  E_WARNING           Run-time warnings (non-fatal errors).
       4  E_PARSE             Compile-time parse errors.
       8  E_NOTICE            Run-time notices.
      16  E_CORE_ERROR        Fatal errors that occur during PHP's initial startup.
      32  E_CORE_WARNING      Warnings (non-fatal errors) that occur during PHP's initial startup.
      64  E_COMPILE_ERROR     Fatal compile-time errors.
     128  E_COMPILE_WARNING   Compile-time warnings (non-fatal errors).
     256  E_USER_ERROR        User-generated error message.
     512  E_USER_WARNING      User-generated warning message.
    1024  E_USER_NOTICE       User-generated notice message.
    2048  E_STRICT            Enable to have PHP suggest changes to your code.
    4096  E_RECOVERABLE_ERROR Catchable fatal error. It indicates that a probably dangerous error occurred, but did not leave the Engine in an unstable state. If the error is not caught by a user defined handle (see also set_error_handler()), the application aborts as it was an E_ERROR. 	Since PHP 5.2.0
    8192  E_DEPRECATED        Run-time notices.
   16384  E_USER_DEPRECATED   User-generated warning message.
   ----------------------------------------------------------------------------
   32767  E_ALL               (Use ~0 in the code to set all bits.)


Defaults:

.. code-block:: none

   30711                      SYS/belogErrorReporting  = E_ALL & ~(E_STRICT | E_NOTICE)

   30466                      SYS/errorHandlerErrors  = E_WARNING     | E_USER_ERROR        | E_USER_WARNING |
                                                        E_USER_NOTICE | E_RECOVERABLE_ERROR | E_DEPRECATED   |
                                                        E_USER_DEPRECATED

   30711                      SYS/syslogErrorReporting = E_ALL & ~(E_STRICT | E_NOTICE)


Typical in TYPO3 for production:

.. code-block:: none


   20480                      SYS/exceptionalErrors   = E_RECOVERABLE_ERROR | E_USER_DEPRECATED


Typical in TYPO3 for development:

.. code-block:: none

   28674                      SYS/exceptionalErrors   = E_WARNING | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED



The following sections highlight the roles and goals of the various classes
related to error and exception handling. Examples and custom handlers are also
discussed.

