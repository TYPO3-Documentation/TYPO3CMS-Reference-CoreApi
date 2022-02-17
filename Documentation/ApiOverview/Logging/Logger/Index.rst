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


.. index::
   Logging; logger->log
   Logging; LogLevels
   Logging; Shorthand methods
   Logging; logger->debug
   Logging; logger->info
   Logging; logger->warning
.. _logging-logger-shortcuts:


Log levels and shorthand methods
================================

Log levels according to RFC 3164, starting from the lowest level.
For each of the severity levels mentioned above, a shorthand method exists in
:code:`\TYPO3\CMS\Core\Log\Logger`, like


.. _label-Debug:
.. rst-class:: dl-parameters

Debug
   :sep:`|` debug information
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::DEBUG`
   :sep:`|` :code:`$this->logger->debug($message, array $context = array());`
   :sep:`|`

   Detailed status information during the development of new PHP code.

.. _label-Informational:
.. rst-class:: dl-parameters

Informational
   :sep:`|` informational messages
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::INFO`
   :sep:`|` :code:`$this->logger->info($message, array $context = array());`
   :sep:`|`

   User logs in, SQL logs.

.. _label-notice:
.. rst-class:: dl-parameters

Notice
   :sep:`|` significant condition
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::NOTICE`
   :sep:`|` :code:`$this->logger->notice($message, array $context = array());`
   :sep:`|`

   Things you should have a look at, nothing to worry about though. 
   Example: User log ins, SQL logs.

.. _label-warning:
.. rst-class:: dl-parameters

Warning
   :sep:`|` warning condition
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::WARNING`
   :sep:`|` :code:`$this->logger->warning($message, array $context = array());`
   :sep:`|`

   Use of deprecated APIs. Undesirable events that are not necessarily wrong.
   Example: Use of a deprecated method.

.. _label-error:
.. rst-class:: dl-parameters

Error
   :sep:`|` error condition
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::ERROR`
   :sep:`|` :code:`$this->logger->error($message, array $context = array());`
   :sep:`|`

   Runtime error. Some PHP coding error has happened. A white screen is shown.

.. _label-critical:
.. rst-class:: dl-parameters

Critical
   :sep:`|` critical condition
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::CRITICAL`
   :sep:`|` :code:`$this->logger->critical($message, array $context = array());`
   :sep:`|`

   Unexpected exception.  An important file has not been found, data is corrupt or outdated.

.. _label-alert:
.. rst-class:: dl-parameters

Alert
   :sep:`|` blocking condition
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::ALERT`
   :sep:`|` :code:`$this->logger->alert($message, array $context = array());`
   :sep:`|`

   Action must be taken immediately. Entire website down, database unavailable.

.. _label-emergency:
.. rst-class:: dl-parameters

Emergency
   :sep:`|` nothing works
   :sep:`|` :code:`\TYPO3\CMS\Core\Log\LogLevel::EMERGENCY`
   :sep:`|` :code:`$this->logger->emergency($message, array $context = array());`
   :sep:`|`

   The system is unusable. You will likely not be able to reach the system.
   You better have a system admin reachable when this happens.


.. _logging-logger-log:

log() Method
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
         See the chapter above.

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



Channels
========

It is possible to group several classes into channels, regardless of the
PHP namespace.

Services are able to control the component name that an
injected logger is created with.
This allows to group logs of related classes and is basically
a channel system as often used in monolog.

The :php:`TYPO3\CMS\Core\Log\Channel` attribute is supported for constructor
argument injection as a class and parameter specific attribute and for
:php:`LoggerAwareInterface` dependency injection services as a class attribute.

This feature is only available with PHP 8.
The channel attribute will be gracefully ignored in PHP 7,
and the classic component name will be used instead.

Registration via class attribute for :php:`LoggerInterface` injection:

.. code-block:: php

   use Psr\Log\LoggerInterface;
   use TYPO3\CMS\Core\Log\Channel;
   #[Channel('security')]
   class MyClass
   {
     private LoggerInterface $logger;
     public function __construct(LoggerInterface $logger)
     {
         $this->logger = $logger;
         // do your magic
     }
   }

Registration via parameter attribute for :php:`LoggerInterface` injection,
overwrites possible class attributes:

.. code-block:: php

   use Psr\Log\LoggerInterface;
   use TYPO3\CMS\Core\Log\Channel;
   class MyClass
   {
     private LoggerInterface $logger;
     public function __construct(
         #[Channel('security')]
         LoggerInterface $logger
     ) {
         $this->logger = $logger;
         // do your magic
     }
   }


Registration via class attribute for :php:`LoggerAwareInterface` services.

.. code-block:: php

   use Psr\Log\LoggerAwareInterface;
   use Psr\Log\LoggerAwareTrait;
   use TYPO3\CMS\Core\Log\Channel;
   #[Channel('security')]
   class MyClass implements LoggerAwareInterface
   {
     use LoggerAwareTrait;
   }


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

Use placeholders
----------------

Adhere to the PSR-3
`placeholder specification <https://www.php-fig.org/psr/psr-3/>`__. This is
necessary in order to use proper PSR-3 Logging.

Bad example:

.. code-block:: php

   // $this->logger->alert(
      'Password reset requested for email "' .
      $emailAddress . '" . but was requested too many times.');

Good example:

.. code-block:: php

   $this->logger->alert(
      'Password reset requested for email {email} but was requested too many times.',
      ['email' => $emailAddress]);

The first argument is 'message', second (optional) argument is 'context'.
A message can use :php:`{placeholders}`. All Core provided log writers will
substitute placeholders in the message with data from the context array,
if a context array key with same name exists.


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

   "Connection to mysql database could not be established"


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

TYPO3 already uses the component of the logger to give some context.
Still further individual context might be available that should be added.
In case of an exception, the code, stacktrace, file and line number would be helpful.

Keep in mind that it is hard to add information afterwards.
Logging is there to get information if something got wrong.
All necessary information should be available to get the state of the system
and why something happened.
