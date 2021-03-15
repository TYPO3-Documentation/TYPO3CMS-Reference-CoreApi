.. include:: /Includes.rst.txt


.. _logging-logger:

======
Logger
======


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


.. _logging-logger-shortcuts:

Shorthand Methods
=================

For each of the severity levels mentioned above, a shorthand method exists in
:code:`\TYPO3\CMS\Core\Log\Logger`, like

- :code:`$this->logger->debug($message, array $data = array());`
- :code:`$this->logger->info($message, array $data = array());`
- :code:`$this->logger->notice($message, array $data = array());`
- etc.
