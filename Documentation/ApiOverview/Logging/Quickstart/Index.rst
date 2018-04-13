.. include:: ../../../Includes.txt



.. _logging-quickstart:

==========
Quickstart
==========

Instantiate $this->logger
=========================

.. note:: 
   As of TYPO3 9.0 you no longer need to use makeInstance to create an instance of the logger yourself. You can use
   `LoggerAwareTrait <https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.0/Feature-82441-InjectLoggerWhenCreatingObjects.html?highlight=loggerawaretrait>`__


Use LoggerAwareTrait in your class to automatically instantiate :code:`$this->logger`::

   use Psr\Log\LoggerAwareTrait;

   class Example
   {
      use LoggerAwareTrait;

    }

Or, if you prefer to instantiate with makeInstance::

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Log\LogManager;

::

   $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);


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


:php:`$logger->warning()` etc. are only shorthands - you can also call :php:`$logger->log()` directly
and pass the severity level::

   $this->logger->log(
      \TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
      'This is an utter failure!'
   );

Output
======


.. note::
   As of TYPO3 8 the default directory for logging has changed from :dir:`typo3temp/logs` to
   :dir:`typo3temp/var/logs`

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
