.. include:: ../../Includes.txt


.. _logging:

Logging with TYPO3
------------------

TYPO3 Logging consists of the following components:

- A :ref:`Logger <logging-logger>` that receives the log message and related details, like a severity
- A :ref:`LogRecord model <logging-model>` which encapsulates the data
- :ref:`Configuration <logging-configuration>` of the logging system
- :ref:`Writers <logging-writers>` which write the log records to different targets
  (like file, database, rsyslog server, etc.)
- :ref:`Processors <logging-processors>` which add more detailed information to the log record.


.. _logging-quickstart:

Quick Usage
^^^^^^^^^^^

Instantiate a logger for the current class:

.. code-block:: php

   /** @var $logger \TYPO3\CMS\Core\Log\Logger */
   $logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);

Log a simple message:

.. code-block:: php

   $logger->info('Everything went fine.');
   $logger->warning('Something went awry, check your configuration!');

Provide additional information with the log message:

.. code-block:: php

   $logger->error(
     'This was not a good idea',
     array(
       'foo' => $bar,
       'bar' => $foo,
     )
   );

:php:`$logger->warning()` etc. are only shorthands - you can also call :php:`$logger->log()` directly
and pass the severity level:

.. code-block:: php

   $logger->log(
      \TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
      'This is an utter failure!'
   );

TYPO3 has the :ref:`FileWriter <filewriter>` enabled by default,
so all log entries are written to a file. If the filename is not set,
then the file will contain a hash like :file:`typo3temp/logs/typo3_<hash>.log`,
eg: :file:`typo3temp/logs/typo3_7ac500bce5.log`.

A sample output looks like this:

.. code-block:: none

   Fri, 08 Mar 2013 09:45:00 +0100 [INFO] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Everything went fine.
   Fri, 08 Mar 2013 09:45:00 +0100 [WARNING] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Something went awry, check your configuration!
   Fri, 08 Mar 2013 09:45:00 +0100 [ERROR] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This was not a good idea - {"foo":"bar","bar":{}}
   Fri, 08 Mar 2013 09:45:00 +0100 [CRITICAL] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This is an utter failure!


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Logger/Index
   Configuration/Index
   Model/Index
   Writers/Index
   Processors/Index
