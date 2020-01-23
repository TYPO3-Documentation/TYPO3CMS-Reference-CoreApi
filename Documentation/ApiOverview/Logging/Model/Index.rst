.. include:: ../../../Includes.txt


.. _logging-model:

The LogRecord model
^^^^^^^^^^^^^^^^^^^

All logging data is modeled using
:php:`\TYPO3\CMS\Core\Log\LogRecord`.

This model has the following properties:

requestId
  A unique identifier for each request which is created by the TYPO3 bootstrap.

created
  The micro-timestamp when the record is created.

component
  The name of the logger which created the LogRecord, usually the fully qualified
  class name where the Logger has been instanciated.

level
  An integer severity level from :ref:`\\TYPO3\\CMS\\Core\\Log\\LogLevel <logging-logger-log>`.

message
  The log message string.

data
  Any additional data, encapsulated within an array.

The API to create a new instance of LogRecord is
:code:`\TYPO3\CMS\Core\Log\Logger:log()` or one of the :ref:`shorthand methods <logging-logger-shortcuts>`.

:code:`LogRecord` implements the :code:`ArrayAccess` interface so that the properties
can be accessed like a native array, for example: :code:`$logRecord['requestId']`.
It also implements a :code:`__toString()` method for your convenience,
which returns the log records as a simplified string.

A :code:`LogRecord` can be processed using :ref:`LogProcessors <logging-processors>`
or :ref:`LogWriters <logging-writers>`. :code:`LogProcessors` are meant to add values
to the :code:`data` property of :code:`LogRecord`. For example,
if you would like to add a stack trace, use
:php:`\TYPO3\CMS\Core\Log\Processor\IntrospectionProcessor`.

:code:`LogWriters` are used to write a :code:`LogRecord` to a particular target,
for example a log file.
