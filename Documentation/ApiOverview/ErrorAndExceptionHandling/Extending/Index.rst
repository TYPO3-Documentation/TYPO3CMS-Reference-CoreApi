.. include:: ../../../Includes.txt


.. _error-handling-extending:

==============================================
How to extend the error and exception handling
==============================================

If you want to register your own error or exception handler, simply
include the class and insert its name into `productionExceptionHandler`,
`debugExceptionHandler` or `errorHandler`::

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler'] = 'Vendor\Ext\Error\MyOwnErrorHandler';
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = 'Vendor\Ext\Error\MyOwnDebugExceptionHandler';
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = 'Vendor\Ext\Error\MyOwnProductionExceptionHandler';


An error or exception handler class must register an error (exception)
handler in its constructor. Have a look at the files in :file:`EXT:core/Classes/Error/`
to see how this should be done.

If you want to use the built-in error and exception handling but
extend it with your own functionality, simply derive your class from the
error and exception handling classes shipped with TYPO3 and register
this class as error (exception) handler::

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
   
Then add the following lines to the `ext_localconf.php` of your extension:

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = 'Vendor\Ext\Error\PostExceptionsOnTwitter';
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = 'Vendor\Ext\Error\PostExceptionsOnTwitter';
