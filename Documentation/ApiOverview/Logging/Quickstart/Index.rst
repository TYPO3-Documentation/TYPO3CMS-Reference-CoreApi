.. include:: /Includes.rst.txt
.. index:: Logging; Quickstart
.. _logging-quickstart:

==========
Quickstart
==========


.. index::
   Logging; Instantiation
   Logging; LoggerAwareTrait
.. _logging-quicksart-instantiate-logger:

Instantiate a logger for the current class
==========================================

.. versionadded:: 9.0
   You no longer need to use makeInstance to create an
   instance of the logger yourself. You can use LoggerAwareTrait:
   :doc:`Changelog/9.0/Feature-82441-InjectLoggerWhenCreatingObjects`.
   You must implement the :php:`\Psr\Log\LoggerAwareInterface` interface with your class to have the Trait taking effect.

Use LoggerAwareTrait in your class to automatically instantiate `$this->logger`::

   use Psr\Log\LoggerAwareTrait;

   class Example implements \Psr\Log\LoggerAwareInterface
   {
      use LoggerAwareTrait;

      protected function myFunction() {
         $this->logger->info('entered function myFunction');
      }
   }

Or instantiate the logger in the classic way with makeInstance::

   $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);

.. _logging-quickstart-log:

.. index::
   Logging; Write to Log
   Logging; logger->log
   Logging; logger->info
   Logging; logger->warning

Log
===

Log a simple message::

   $this->logger->info('Everything went fine.');
   $this->logger->warning('Something went awry, check your configuration!');


Provide additional context information with the log message::

   $this->logger->error('Passing {value} was unwise.', [
       'value' => $value,
       'other_data' => $foo,
   ]);

Values in the message string that should vary based on the error (such as specifying what an invalid value was) should use placeholders, denoted by `{ }`.  Provide the value for that placeholder in the context array.

:php:`$this->logger->warning()` etc. are only shorthands - you can also call :php:`$this->logger->log()` directly
and pass the severity level::

   $this->logger->log(
      \TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
      'This is an utter failure!'
   );


.. index::
   Logging; Output
   Logging; FileWriter

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
