.. include:: ../../../Includes.txt



.. _logging-quickstart:

==========
Quickstart
==========

.. _logging-quicksart-instantiate-logger:

Instantiate a logger for the current class
==========================================

.. note::
   As of TYPO3 9.0 you no longer need to use makeInstance to create an 
   instance of the logger yourself. You can use `LoggerAwareTrait 
   <https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.0/Feature-82441-InjectLoggerWhenCreatingObjects.html?highlight=loggerawaretrait>`__
   
Use LoggerAwareTrait in your class to automatically instantiate `$this->logger`::

   use Psr\Log\LoggerAwareTrait;

   class Example
   {
      use LoggerAwareTrait;
   }
   
Or instantiate the logger in the classic way with makeInstance::

   $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);

.. _logging-quickstart-log:

Log
===

Log a simple message::

   $this->logger->info('Everything went fine.');
   $this->logger->warning('Something went awry, check your configuration!');


Provide additional information with the log message::

   $this->logger->error(
     'This was not a good idea',
     array(
       'foo' => $bar,
       'bar' => $foo,
     )
   );


:php:`$this->logger->warning()` etc. are only shorthands - you can also call :php:`$this->logger->log()` directly
and pass the severity level::

   $this->logger->log(
      \TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
      'This is an utter failure!'
   );


Set logging output
==================

TYPO3 has the :ref:`FileWriter <logging-writers-FileWriter>` enabled by default,
so all log entries are written to a file. If the filename is not set,
then the file will contain a hash like :file:`typo3temp/var/logs/typo3_<hash>.log`,
for example :file:`typo3temp/var/logs/typo3_7ac500bce5.log`.

A sample output looks like this:

.. code-block:: none

   Fri, 08 Mar 2013 09:45:00 +0100 [INFO] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Everything went fine.
   Fri, 08 Mar 2013 09:45:00 +0100 [WARNING] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Something went awry, check your configuration!
   Fri, 08 Mar 2013 09:45:00 +0100 [ERROR] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This was not a good idea - {"foo":"bar","bar":{}}
   Fri, 08 Mar 2013 09:45:00 +0100 [CRITICAL] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This is an utter failure!
