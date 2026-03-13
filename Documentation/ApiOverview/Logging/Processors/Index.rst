..  include:: /Includes.rst.txt
..  index:: Logging; Processors
..  _logging-processors:

==============
Log processors
==============

The purpose of a log processor is (usually) to modify a
:ref:`log record <logging-model>` or add more detailed information to it.

Log processors allow you to manipulate log records without changing the code
that actually calls the log method (inversion of control). This enables you to
add any information from outside the scope of the actual calling function, such
as webserver environment variables. The TYPO3 Core ships with some basic log
processors, but more can be added with extensions.

..  contents::
    :depth: 2
    :local:

..  index:: Logging; Processors, Built-in
..  _logging-processors-builtin:

Built-in log processors
=======================

This section describes the log processors that are shipped with the TYPO3 Core.
Some processors have options to allow the customization of the particular
processor. See the :ref:`Configuration <logging-configuration-processor>`
section for how to use these options.


..  index:: Logging; IntrospectionProcessor
..  _logging-processors-introspection:

IntrospectionProcessor
----------------------

The introspection processor adds backtrace data about where the log event was
triggered.

By default, the following parameters from the original function call are added:

file
    The absolute path to the file.

line
    The line number.

class
    The class name.

function
    The function name.

Options
~~~~~~~

..  confval:: appendFullBackTrace
    :name: logging-processors-introspection-appendFullBackTrace
    :Mandatory: no
    :Default: :php:`false`

    Adds a full backtrace stack to the log.

..  confval:: shiftBackTraceLevel
    :name: logging-processors-introspection-shiftBackTraceLevel
    :Mandatory: no
    :Default: :php:`0`

    Removes the given number of entries from the top of the backtrace stack.


..  index:: Logging; MemoryUsageProcessor
..  _logging-processors-memory:

MemoryUsageProcessor
--------------------

The memory usage processor adds the amount of used memory to the log record
(result from `memory_get_usage()`_).

..  _memory_get_usage(): https://www.php.net/manual/en/function.memory-get-usage.php

Options
~~~~~~~

..  confval:: realMemoryUsage
    :name: logging-processors-memory-realMemoryUsage
    :Mandatory: no
    :Default: :php:`true`

    Use the `real size of memory <https://www.php.net/manual/en/function.memory-get-usage.php#refsect1-function.memory-get-usage-parameters>`__
    allocated from system instead of :php:`emalloc()` value.

..  confval:: formatSize
    :name: logging-processors-memory-formatSize
    :Mandatory: no
    :Default: :php:`true`

    Whether the size is formatted with :php:`GeneralUtility::formatSize()`.


..  index:: Logging; MemoryPeakUsageProcessor
..  _logging-processors-memory-peak:

MemoryPeakUsageProcessor
------------------------

The memory peak usage processor adds the peak amount of used memory to the
:ref:`log record <logging-model>` (result from `memory_get_peak_usage()`_).

..  _memory_get_peak_usage(): https://www.php.net/manual/en/function.memory-get-peak-usage.php

Options
~~~~~~~

..  confval:: realMemoryUsage
    :name: logging-processors-memory-peak-realMemoryUsage
    :Mandatory: no
    :Default: :php:`true`

    Use the `real size of memory <https://www.php.net/manual/en/function.memory-get-peak-usage.php#refsect1-function.memory-get-peak-usage-parameters>`__
    allocated from system instead of :php:`emalloc()` value.

..  confval:: formatSize
    :name: logging-processors-memory-peak-formatSize
    :Mandatory: no
    :Default: :php:`true`

    Whether the size is formatted with :php:`GeneralUtility::formatSize()`.


..  index:: Logging; Processors
..  _logging-processors-web:

WebProcessor
------------

The web processor adds selected webserver environment variables to the log record,
that means, all possible values from
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('_ARRAY')`.


..  index::
    Logging; Custom log processors
    Logging; ProcessorInterface
..  _logging-processors-custom:

Custom log processors
=====================

Custom log processors can be added through extensions. Every log processor has
to implement the interface :t3src:`core/Classes/Log/Processor/ProcessorInterface.php`.
It is suggested to extend the abstract class
:t3src:`core/Classes/Log/Processor/AbstractProcessor.php` which allows you use
configuration options by adding the corresponding properties and setter methods.

..  rubric:: Example

..  literalinclude:: _MyProcessorWithOptions.php
    :caption: EXT:my_extension/Classes/Log/Processor/MyProcessor.php

Please keep in mind that TYPO3 will silently continue operating,
in case a log processor is throwing an exception while executing
the :php:`processLogRecord()` method.
