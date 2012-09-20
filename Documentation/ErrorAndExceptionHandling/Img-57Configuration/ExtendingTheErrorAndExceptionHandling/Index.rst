

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


Extending the error and exception handling
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you want to register your own error or exception handler, simply
include the class and insert its name to "productionExceptionHandler",
"debugExceptionHandler" or "errorHandler".

**Example:**

::

   $TYPO3_CONF_VARS['SYS']['errorHandler'] = 'myOwnErrorHandler';
   $TYPO3_CONF_VARS['SYS']['debugExceptionHandler'] = 'myOwnDebugExceptionHandler';
   $TYPO3_CONF_VARS['SYS']['productionExceptionHandler'] = 'myOwnProductionExceptionHandler';

An error or exception handler class must register an error (exception)
handler in its constructor. Have a look at the files in t3lib/error/
to see how this should be done.

If you want to use the built-in error and exception handling but
extend it by your own functionality, simply derive your class from the
error and exception handling classes shipped with TYPO3 and register
this class as error (exception) handler.

**Example:**

::

   class tx_postExceptionsOnTwitter extends t3lib_error_DebugExceptionHandler {
       function echoExceptionWeb(Exception $exception) {
           $this->postExceptionsOnTwitter($exception);
       }
       function postExceptionsOnTwitter($exception) {
           // do it ;-)
       }
   }
   $TYPO3_CONF_VARS['SYS']['debugExceptionHandler'] = 'tx_postExceptionsOnTwitter';
   $TYPO3_CONF_VARS['SYS']['productionExceptionHandler'] = 'tx_postExceptionsOnTwitter';

