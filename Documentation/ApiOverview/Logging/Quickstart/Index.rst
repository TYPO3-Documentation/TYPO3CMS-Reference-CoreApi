.. include:: /Includes.rst.txt
.. index:: Logging; Quickstart
.. _logging-quickstart:

==========
Quickstart
==========


.. index::
   Logging; Instantiation
   Logging; LoggerInterface
.. _logging-quicksart-instantiate-logger:

Instantiate a logger for the current class
==========================================

.. versionadded:: 11.4
   :doc:`Changelog/11.4/Feature-95044-SupportAutowiredLoggerInterfaceInjection`

Constructor injection can be used to automatically instantiate the logger:

.. code-block:: php

   use Psr\Log\LoggerInterface;

   class MyClass {
       private LoggerInterface $logger;

       public function __construct(LoggerInterface $logger) {
           $this->logger = $logger;
       }
   }

.. _logging-quickstart-log:

.. index::
   Logging; Write to Log
   Logging; logger->log
   Logging; logger->info
   Logging; logger->warning

Log
===

Log a simple message:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   $this->logger->warning('Something went awry, check your configuration!');


Provide additional context information with the log message:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   $this->logger->error('Passing {value} was unwise.', [
       'value' => $value,
       'other_data' => $foo,
   ]);

Values in the message string that should vary based on the error (such as
specifying what an invalid value was) should use placeholders, denoted by
`{ }`.  Provide the value for that placeholder in the context array.

:php:`$this->logger->warning()` etc. are only shorthands - you can also call
:php:`$this->logger->log()` directly and pass the severity level:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   $this->logger->log(
      \TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
      'This is an utter failure!'
   );


.. index::
   Logging; Output
   Logging; FileWriter

Set logging output
==================

TYPO3 has the :ref:`FileWriter <logging-writers-FileWriter>` enabled by default
for warnings (:php:`LogLevel::WARNING`) and lower, so all matching log entries
are written to a file.

If the filename is not set, then the file will contain a hash like
:file:`var/log/typo3_<hash>.log`, for example
:file:`var/log/typo3_7ac500bce5.log`.

A sample output looks like this:

.. code-block:: none

   Fri, 08 Mar 2013 09:45:00 +0100 [WARNING] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Something went awry, check your configuration!
   Fri, 08 Mar 2013 09:45:00 +0100 [ERROR] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This was not a good idea - {"foo":"bar","bar":{}}
   Fri, 08 Mar 2013 09:45:00 +0100 [CRITICAL] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This is an utter failure!
