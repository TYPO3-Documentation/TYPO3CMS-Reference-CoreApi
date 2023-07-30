..  include:: /Includes.rst.txt
..  index:: Logging; Logger
..  _logging-logger:

======
Logger
======

..  contents::
    :local:

..  index::
    Logging; Instantiation
    Logging; LoggerInterface
..  _logging-logger-instantiation:

Instantiation
=============

:ref:`Constructor injection <Constructor-injection>` can be used to
automatically instantiate the logger:

..  literalinclude:: _MyClassLoggerInjection.php
    :language: php
    :caption: EXT:my_extension/Classes/Service/MyClass.php

..  tip::
    For examples of instantiation with :php:`LoggerAwareTrait` or
    :php:`GeneralUtility::makeInstance()`, switch to an older TYPO3 version for
    this page. Instantiation with :ref:`dependency injection <DependencyInjection>`
    is now the recommended procedure. Also see the section on
    :ref:`channels <logging-channels>` for information on grouping classes in
    channels.


..  index::
    Logging; logger->log
.. _logging-logger-log:

The log() method
================

The :php:`\TYPO3\CMS\Core\Log\Logger` class provides a central point for
submitting log messages, the :php:`log()` method:

..  code-block:: php

    $this->logger->log($level, $message, $data);

which takes three parameters:

..  option:: $level

    :Type: integer

    One of the defined log levels, see the section
    :ref:`logging-logger-shortcuts`.

..  option:: $message

    :Type: string | :php:`\Stringable`

    The log message itself.

..  option:: $data

    :Type: array

    Optional parameter, it can contain additional data, which is added to the
    :ref:`log record <logging-model>` in the form of an array.

An early return in the :php:`log()` method prevents unneeded computation work to
be done. So you are safe to call the logger with the debug log level frequently
without slowing down your code too much. The logger will know by its
configuration, what the most explicit severity level is.

As a next step, all registered :ref:`processors <logging-processors>` are
notified. They can modify the log records or add extra information.

The logger then forwards the log records to all of its configured
:ref:`writers <logging-writers>`, which will then persist the log record.


..  index::
    Logging; LogLevels
    Logging; Shorthand methods
    Logging; logger->debug
    Logging; logger->info
    Logging; logger->notice
    Logging; logger->warning
    Logging; logger->error
    Logging; logger->critical
    Logging; logger->alert
    Logging; logger->emergency
..  _logging-logger-shortcuts:

Log levels and shorthand methods
================================

The log levels - according to `RFC 3164`_ - start from the lowest level.
For each of the severity levels mentioned below, a shorthand method exists in
:php:`\TYPO3\CMS\Core\Log\Logger`:

..  _RFC 3164: https://datatracker.ietf.org/doc/html/rfc3164

..  _label-Debug:
..  option:: Debug

    :Class constant: :php:`\Psr\Log\LogLevel::DEBUG`
    :Shorthand method: :php:`$this->logger->debug($message, $context);`

    For debug information: give detailed status information during the
    development of PHP code.

..  _label-Informational:
..  option:: Informational

    :Class constant: :php:`\Psr\Log\LogLevel::INFO`
    :Shorthand method: :php:`$this->logger->info($message, $context);`

    For informational messages, some examples:

    *   A user logs in.
    *   Connection to third-party system established.
    *   Logging of SQL statements.

..  _label-notice:
..  option:: Notice

    :Class constant: :php:`\Psr\Log\LogLevel::NOTICE`
    :Shorthand method: :php:`$this->logger->notice($message, $context);`

    For significant conditions. Things you should have a look at, nothing to
    worry about though. Some examples:

    *   A user logs in.
    *   Logging of SQL statements.

..  _label-warning:
..  option:: Warning

    :Class constant: :php:`\Psr\Log\LogLevel::WARNING`
    :Shorthand method: :php:`$this->logger->warning($message, $context);`

    For warning conditions. Some examples:

    *   Use of a deprecated method.
    *   Undesirable events that are not necessarily wrong.

..  _label-error:
..  option:: Error

    :Class constant: :php:`\Psr\Log\LogLevel::ERROR`
    :Shorthand method: :php:`$this->logger->error($message, $context);`

    For error conditions. Some examples:

    *   A runtime error occurred.
    *   Some PHP coding error has happened.
    *   A white screen is shown.

..  _label-critical:
..  option:: Critical

    :Class constant: :php:`\Psr\Log\LogLevel::CRITICAL`
    :Shorthand method: :php:`$this->logger->critical($message, $context);`

    For critical conditions. Some examples:

    *   An unexpected exception occurred.
    *   An important file has not been found.
    *   Data is corrupt or outdated.

..  _label-alert:
..  option:: Alert

    :Class constant: :php:`\Psr\Log\LogLevel::ALERT`
    :Shorthand method: :php:`$this->logger->alert($message, $context);`

    For blocking conditions, action must be taken immediately. Some examples:

    *   The entire website is down.
    *   The database is unavailable.

.. _label-emergency:
..  option:: Emergency

   :Class constant: :php:`\Psr\Log\LogLevel::EMERGENCY`
   :Shorthand method: :php:`$this->logger->emergency($message, $context);`

    Nothing works, the system is unusable. You will likely not be able to reach
    the system. You better have a system administrator reachable when this
    happens.


..  _logging-channels:

Channels
========

It is possible to group several classes into channels, regardless of the
:ref:`PHP namespace <logging-configuration>`.

Services are able to control the component name that an injected logger is
created with. This allows to group logs of related classes and is basically
a channel system as often used in `Monolog`_.

..  _Monolog: https://packagist.org/packages/monolog/monolog

The :php:`\TYPO3\CMS\Core\Log\Channel` attribute is supported for
:ref:`constructor argument injection <Constructor-injection>` as a class and
parameter-specific attribute and for :php:`\Psr\Log\LoggerAwareInterface`
dependency injection services as a class attribute.

This feature is only available with PHP 8. The channel attribute will be
gracefully ignored in PHP 7, and the classic component name will be used
instead.

Registration via class attribute for :php:`\Psr\Log\LoggerInterface` injection:

..  literalinclude:: _MyClassChannel.php
    :language: php
    :caption: EXT:my_extension/Classes/Service/MyClass.php

Registration via parameter attribute for :php:`\Psr\Log\LoggerInterface`
injection, overwrites possible class attributes:

..  literalinclude:: _MyClassChannel2.php
    :language: php
    :caption: EXT:my_extension/Classes/Service/MyClass.php

The instantiated logger will now have the channel "security",
instead of the default one, which would be a combination of namespace and class
of the instantiating class, such as `MyVendor.MyExtension.Service.MyClass`.

Using the channel
-----------------

The channel "security" can then be used in the logging configuration:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    use Psr\Log\LogLevel;
    use TYPO3\CMS\Core\Core\Environment;
    use TYPO3\CMS\Core\Log\Writer\FileWriter;

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['security']['writerConfiguration'] = [
        LogLevel::DEBUG => [
            FileWriter::class => [
                'logFile' => Environment::getVarPath() . '/log/security.log'
            ]
        ],
    ];

The written log messages will then have the component name `"security"`, such as:

..  code-block:: text
    :caption: var/log/security.log

    Fri, 21 Jul 2023 16:26:13 +0000 [DEBUG] ... component="security": ...

For more examples for configuring the logging see the
:ref:`logging-configuration-writer` section.


.. _logging-logger-examples:

Examples
========

Examples of the usage of the logger can be found in the extension
:t3ext:`examples`. in file
:file:`/Classes/Controller/ModuleController.php`


..  index:: Logging; Best practices
..  _logging-logger-best-practices:

Best practices
==============

There are no strict rules or guidelines about logging.
Still it can be considered to be best practice to follow these rules:

Use placeholders
----------------

Adhere to the `PSR-3 placeholder specification`_. This is
necessary in order to use proper PSR-3 logging.

..  _PSR-3 placeholder specification: https://www.php-fig.org/psr/psr-3/

Bad example:

..  code-block:: php

    $this->logger->alert(
        'Password reset requested for email "'
        . $emailAddress . '" but was requested too many times.'
    );

Good example:

..  code-block:: php

    $this->logger->alert(
        'Password reset requested for email "{email}" but was requested too many times.',
        ['email' => $emailAddress]
    );

The first argument is the message, the second (optional) argument is a context.
A message can use :php:`{placeholders}`. All Core provided log writers will
substitute placeholders in the message with data from the context array,
if a context array key with same name exists.


Meaningful message
------------------

The message itself has to be meaningful, for example, exception messages.

Bad example:

..  code-block:: text

    "Something went wrong"

Good example:

..  code-block:: text

    "Could not connect to database"


Searchable message
------------------

Most of the times log entries will be stored.
They are most important, if something goes wrong within the system.
In such situations people might search for specific issues or situations,
considering this while writing log entries will reduce debugging time in future.

Messages should therefore contain keywords that might be used in searches.

Good example:

..  code-block:: text

    "Connection to MySQL database could not be established"


This includes "connection", "mysql" and "database" as possible keywords.


Distinguishable and grouped
---------------------------

Log entries might be collected and people might scroll through them.
Therefore it is helpful to write log entries that are distinguishable,
but are also grouped.

Bad examples:

..  code-block:: text

    "Database not reached"
    "Could not establish connection to memcache"

Good examples:

..  code-block:: text

    "Connection to MySQL database could not be established"
    "Connection to memcache could not be established"

This way the same issue is grouped by the same structure,
and one can scan the same position for either "MySQL" or "memcache".


Provide useful information
--------------------------

TYPO3 already uses the component of the logger to give some context.
Still further individual context might be available that should be added.
In case of an exception, the code, stacktrace, file and line number would be
helpful.

Keep in mind that it is hard to add information afterwards.
Logging is there to get information if something got wrong.
All necessary information should be available to get the state of the system
and why something happened.
