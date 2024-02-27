..  include:: /Includes.rst.txt
..  index::
    Logging; LogRecord
    Logging; Model
..  _logging-model:

===================
The LogRecord model
===================

All logging data is modeled using :php:`\TYPO3\CMS\Core\Log\LogRecord`.

This model has the following properties:

requestId
    A unique identifier for each request which is created by the
    :ref:`TYPO3 bootstrap <bootstrapping>`.

created
    The timestamp with microseconds when the record is created.

component
    The name of the :ref:`logger <logging-logger>` which created the log record,
    usually the fully-qualified class name where the logger has been
    instantiated.

level
    An integer severity level from
    :ref:`\\Psr\\Log\\LogLevel <logging-logger-log>`.

message
    The log message string.

data
    Any additional data, encapsulated within an array.

The API to create a new instance of LogRecord is
:php:`\TYPO3\CMS\Core\Log\Logger:log()` or one of the
:ref:`shorthand methods <logging-logger-shortcuts>`.

The :php:`LogRecord` class implements the :php:`\ArrayAccess` interface so that
the properties can be accessed like a native array, for example:
:php:`$logRecord['requestId']`.
It also implements a :php:`__toString()` method for your convenience,
which returns the log record as a simplified string.

A log record can be processed using :ref:`log processors <logging-processors>`
or :ref:`log writers <logging-writers>`. Log processors are meant to add
values to the :php:`data` property of a log record. For example,
if you would like to add a stack trace, use
:php:`\TYPO3\CMS\Core\Log\Processor\IntrospectionProcessor`.

Log writers are used to write a log record to a particular target,
for example, a log file.
