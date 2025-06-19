:navigation-title: Logging

..  include:: /Includes.rst.txt
..  index:: ! Logging
..  _logging:

=======================================
The logging framework (developer guide)
=======================================

This chapter is intended for **developers** who want to use the TYPO3 logging
framework in their extensions, middleware, or custom services.

It explains the internal architecture of the logging system and how to interact
with it programmatically.

If you're looking for production-level logging guidance (e.g., log rotation,
monitoring, or security), see:
:ref:`production-logging`.

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

..  seealso::

    Are you looking for information on how to configure logging for production
    environments (log rotation, error monitoring, security)? See
    `Logging in production <https://docs.typo3.org/permalink/t3coreapi:production-logging>`_.

**Contents:**

..  toctree::

    Quickstart/Index
    Logger/Index
    Configuration/Index
    Model/Index
    Writers/Index
    Processors/Index
