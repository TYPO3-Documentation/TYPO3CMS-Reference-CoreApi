.. include:: /Includes.rst.txt


.. _error-handling-extending:

==============================================
How to extend the error and exception handling
==============================================

If you want to register your own error or exception handler:

#. Create a corresponding class in your extension

#. Override the core defaults for `productionExceptionHandler`, `debugExceptionHandler`
   or `errorHandler` in :file:`typo3conf/AdditionalConfiguration.php`::

      $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler'] = \Vendor\Ext\Error\MyOwnErrorHandler::class;
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = \Vendor\Ext\Error\MyOwnDebugExceptionHandler::class;
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = \Vendor\Ext\Error\MyOwnProductionExceptionHandler::class;

.. tip::

   We use :file:`typo3conf/AdditionalConfiguration.php` and **not** :file:`ext_localconf.php`
   in the extension (as previously documented) because that will be executed
   **after** the error / exception handlers are initialized in the bootstrap process.

An error or exception handler class must register an error (exception)
handler in its constructor. Have a look at the files in :file:`EXT:core/Classes/Error/`
to see how this should be done.

If you want to use the built-in error and exception handling but
extend it with your own functionality, derive your class from the
error and exception handling classes shipped with TYPO3.

Example Debug Exception Handler
===============================

This uses the default core exception handler `DebugExceptionHandler` and overrides some
of the functionality::


   namespace Vendor\Ext\Error;

   class PostExceptionsOnTwitter extends \TYPO3\CMS\Core\Error\DebugExceptionHandler
   {
       public function echoExceptionWeb(Exception $exception)
       {
           $this->postExceptionsOnTwitter($exception);
       }

       public function postExceptionsOnTwitter($exception)
       {
           // do it ;-)
       }
   }

:file:`typo3conf/AdditionalConfiguration.php`::

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = \Vendor\Ext\Error\PostExceptionsOnTwitter::class;

