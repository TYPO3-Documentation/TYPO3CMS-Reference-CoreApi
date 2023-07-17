..  include:: /Includes.rst.txt
..  index:: ! Logging
..  _logging:

=================
Logging Framework
=================

The chapter :ref:`logging-quickstart` helps you get started.

TYPO3 Logging consists of the following components:

*   A :ref:`Logger <logging-logger>` that receives the log message and related
    details, like a severity.
*   A :ref:`LogRecord model <logging-model>` which encapsulates the data
*   :ref:`Configuration <logging-configuration>` of the logging system
*   :ref:`Writers <logging-writers>` which write the log records to different
    targets (like file, database, rsyslog server, etc.)
*   :ref:`Processors <logging-processors>` which enhance the log record with
    more detailed information.


**Contents:**

..  toctree::

    Quickstart/Index
    Logger/Index
    Configuration/Index
    Model/Index
    Writers/Index
    Processors/Index
