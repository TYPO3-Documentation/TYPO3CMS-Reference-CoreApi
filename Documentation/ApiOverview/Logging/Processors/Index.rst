.. include:: /Includes.rst.txt
.. index:: Logging; Processors
.. _logging-processors:

==============
Log processors
==============

The purpose of a log processor is (usually) to modify a log record or add more detailed information to it.

Log processors allow to manipulate log records without changing the code
where the log method actually is called (inversion of control).
This enables you to add any information from outside the scope of the actual calling function,
for example webserver environment variables. The TYPO3 Core  ships some basic log processors,
but more can be added with extensions.


.. index:: Logging; Processors, Built-in
.. _logging-processors-builtin:

Built-in log processors
=======================

This section describes the log processors shipped with the TYPO3 Core .
Some processors have options to allow customization of the particular processor.
See the :ref:`Configuration <logging-configuration-processor>` section for how to use these options.


.. index:: Logging; IntrospectionProcessor
.. _logging-processors-introspection:

IntrospectionProcessor
----------------------

The introspection processor adds backtrace data about where the log event was triggered.

By default the following parameters from the original function call are added:

file
  absolute path to the file.
line
  line number.
class
  class name.
function
  function name.

If :code:`appendFullBackTrace` is set, the full backtrace stack is added instead.

====================  =========  ===========================================================================  ============
Option                Mandatory  Description                                                                   Default
====================  =========  ===========================================================================  ============
appendFullBackTrace   no         Adds a full backtrace stack to the log.                                      :code:`FALSE`
shiftBackTraceLevel   no         Removes the given number of entries from the top of the backtrace stack.     :code:`0`
====================  =========  ===========================================================================  ============


.. index:: Logging; MemoryUsageProcessor
.. _logging-processors-memory:

MemoryUsageProcessor
--------------------

The memory usage processor adds the amount of used memory to the log record
(result from `memory_get_usage()`__).

__ http://www.php.net/manual/en/function.memory-get-usage.php

================  =========  ===========================================================================   ============
Option            Mandatory  Description                                                                   Default
================  =========  ===========================================================================   ============
realMemoryUsage   no         Use real__ size of memory allocated from system instead of emalloc() value.   :code:`TRUE`
formatSize        no         Whether the size is formatted with GeneralUtility::formatSize()               :code:`TRUE`
================  =========  ===========================================================================   ============

__ http://www.php.net/manual/en/function.memory-get-usage.php


.. index:: Logging; MemoryPeakUsageProcessor
.. _logging-processors-memory-peak:

MemoryPeakUsageProcessor
------------------------

The memory peak usage processor adds the peak amount of used memory to the log record
(result from `memory_get_peak_usage()`__).

__ http://www.php.net/manual/en/function.memory-get-peak-usage.php

================  ==========  ===========================================================================   ============
Option            Mandatory   Description                                                                   Default
================  ==========  ===========================================================================   ============
realMemoryUsage   no          Use real__ size of memory allocated from system instead of emalloc() value.   :code:`TRUE`
formatSize        no          Whether the size is formatted with GeneralUtility::formatSize()               :code:`TRUE`
================  ==========  ===========================================================================   ============

__ http://www.php.net/manual/en/function.memory-get-peak-usage.php


.. index:: Logging; Processors
.. _logging-processors-web:

WebProcessor
------------

The web processor adds selected webserver environment variables to the log record,
i.e. all possible values from :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('_ARRAY')`.


.. index::
   Logging; Custom log processors
   Logging; ProcessorInterface
.. _logging-processors-custom:

Custom log processors
=====================

Custom log processors can be added through extensions. Every log processor has to implement
the interface :code:`\TYPO3\CMS\Core\Log\Processor\ProcessorInterface`.
It is suggested to extend the abstract class :code:`\TYPO3\CMS\Core\Log\Processor\AbstractProcessor`
which allows you use configuration options by adding the corresponding properties and setter methods.

Please keep in mind that TYPO3 will silently continue operating,
in case a log processor is throwing an exception while executing
the :code:`processLogRecord()` method.
