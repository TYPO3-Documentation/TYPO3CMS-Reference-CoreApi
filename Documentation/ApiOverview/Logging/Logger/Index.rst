.. include:: /Includes.rst.txt
.. index:: Logging; Logger
.. _logging-logger:

======
Logger
======


.. index:: Logging; LoggerAwareTrait
.. _logging-logger-instantiation:

Instantiation
=============

.. versionadded:: 9.0
   You no longer need to call makeInstance to create an
   instance of the logger. You can use the LoggerAwareTrait:
   :doc:`Changelog/9.0/Feature-82441-InjectLoggerWhenCreatingObjects`

Use the :code:`LoggerAwareTrait` in your class to automatically instantiate :code:`$this->logger`:

.. code-block:: php

   use Psr\Log\LoggerAwareInterface;
   use Psr\Log\LoggerAwareTrait;

   class Example implements LoggerAwareInterface
   {
      use LoggerAwareTrait;
   }


Or, you can instantiate the Logger with :code:`makeInstance`.

The :code:`LogManager` enables an auto-configured usage of loggers in your PHP code
by reading the logging configuration and setting the minimum severity level of the Logger
accordingly.

.. code-block:: php

   /** @var $logger \TYPO3\CMS\Core\Log\Logger */
   $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);


Using :code:`__CLASS__` as name for the logger is recommended to enable logging configuration
based on the class hierarchy.


.. index::
   Logging; logger->log
   Logging; LogLevels
.. _logging-logger-log:

Log() Method
============

:code:`\TYPO3\CMS\Core\Log\Logger` provides a central point for submitting log messages,
the :code:`log()` method:

.. code-block:: php

   $this->logger->log($level, $message, $data);

which takes three parameters:


.. t3-field-list-table::
 :header-rows: 1

 - :Parameter,20: Parameter
   :Type,20: Type
   :Description,60: Description

 - :Parameter: $level
   :Type: Type
         integer
   :Description:
         One of either:

         - :code:`\TYPO3\CMS\Core\Log\LogLevel::EMERGENCY`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::ALERT`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::CRITICAL`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::ERROR`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::WARNING`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::NOTICE`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::INFO`
         - :code:`\TYPO3\CMS\Core\Log\LogLevel::DEBUG`

 - :Parameter: $message
   :Type: Type
         string
   :Description:
         The log message itself.

 - :Parameter: $data
   :Type: Type
         array
   :Description:
         Optional parameter, can contain additional data, which is added to the log record
         in the form of an array.

An early return in the :code:`log()` method prevents unneeded computation work to be done.
So you are safe to call :code:`$this->logger->debug()` frequently without slowing down your code too much.
The Logger will know by its configuration, what the most explicit severity level is.

As next step, all registered :ref:`Processors <logging-processors>` are notified.
They can modify the log records or add extra information.

The Logger then forwards the log records to all of its configured :ref:`Writers <logging-writers>`,
which will then persist the log record.


.. index::
   Logging; Shorthand methods
   Logging; logger->debug
   Logging; logger->info
   Logging; logger->warning
.. _logging-logger-shortcuts:

Shorthand methods
=================

For each of the severity levels mentioned above, a shorthand method exists in
:code:`\TYPO3\CMS\Core\Log\Logger`, like

- :code:`$this->logger->debug($message, array $data = array());`
- :code:`$this->logger->info($message, array $data = array());`
- :code:`$this->logger->notice($message, array $data = array());`
- etc.

.. _logging-logger-examples:

Examples
========

Examples of the usage of the Logger can be found in the extension
`examples <https://extensions.typo3.org/extension/examples/>`__. in file
:file:`/Classes/Controller/ModuleController.php`


.. index:: Logging; Best practices
.. _logging-logger-best-practices:

Best practices
==============

There are no strict rules or guidelines about logging.
Still it can be considered to be best practice to follow these rules:

Meaningful message
------------------


The message itself has to be meaningful, for example exception messages.

Bad example:

.. code-block:: none

    "Something went wrong"

Good example:

.. code-block:: none

    "Could not connect to database"


Searchable message
------------------

Most of the times log entries will be stored.
They are most important if something goes wrong within the system.
In such situations people might search for specific issues or situations,
considering this while writing log entries will reduce debugging time in future.

Messages should therefore contain keywords that might be used in searches.

Good example:

.. code-block:: none

   "Connection to `MySQL`:pn: database could not be established"


This includes "connection", "mysql" and "database" as possible keywords.


Distinguishable and grouped
---------------------------

Log entries might be collected and people might scroll through them.
Therefore it is helpful to write log entries that are distinguishable,
but are also grouped.

Bad examples:

.. code-block:: none

   "Connection to mysql database could not be established."
   "Could not establish connection to memcache."

Good examples:

.. code-block:: none

   "Connection to mysql database could not be established."
   "Connection to memcache could not be established."

This way the same issue is grouped by the same structure,
and one can scan the same position for either "mysql" or "memcache".


Provide useful information
--------------------------

`TYPO3`:pn: already uses the component of the logger to give some context.
Still further individual context might be available that should be added.
In case of an exception, the code, stacktrace, file and line number would be helpful.

Keep in mind that it is hard to add information afterwards.
Logging is there to get information if something got wrong.
All necessary information should be available to get the state of the system
and why something happened.
