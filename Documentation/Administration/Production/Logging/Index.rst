:navigation-title: Logging

..  include:: /Includes.rst.txt
..  _production-logging:

========================================
Logging considerations during production
========================================

In production environments, improperly configured logging can lead to issues
such as bloated log files, degraded performance, and even website outages due
to full disk space.

TYPO3 has several configuration options and tools to keep log files
manageable, secure, and relevant. This guide covers practical strategies for
controlling log volume, reducing noise, and monitoring critical events.

..  seealso::

    For an overview of how logging works inside TYPO3 and how to use it in
    custom code or extensions, see the :ref:`logging` chapter in the API section.

..  warning::

    Log files can grow rapidly in production and may eventually exhaust
    available disk space, causing TYPO3 to become unresponsive or inaccessible.

..  contents:: Table of contents

..  _production-logging-level:

Limit the level to be logged
============================

Each log entry in TYPO3 is associated with a severity level. For details on
log levels, refer to the TYPO3 documentation:
`Log levels <https://docs.typo3.org/permalink/t3coreapi:logging-logger-shortcuts>`_.

During development, it is often useful to log detailed information. In
production, logging should be limited to important issues—typically messages at
the `ERROR` level or higher—to reduce disk usage and improve performance.

By default, when the
`Application Context <https://docs.typo3.org/permalink/t3coreapi:application-context>`_
is set to `Production`, only messages with a severity of
:php-short:`\Psr\Log\LogLevel::ERROR` or higher are logged.

You can also configure different writers for specific log levels. This allows
you to, for example, write warnings and errors to separate files, or ignore
lower-severity messages altogether.

The following example demonstrates how to configure log writers per log
level:

..  literalinclude:: _codesnippets/_loglevels.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

..  _production-logging-monitor:

Monitor the log and address common log entries
==============================================

Some log messages may appear frequently without indicating a critical or
harmful issue. For example, an outdated
`TypoScript condition <https://docs.typo3.org/permalink/t3tsref:typoscript-syntax-conditions-examples>`_
written in legacy syntax can trigger log entries every time TypoScript is
evaluated for a page.

Fixing such recurring issues helps reduce the size of your log files and
improves the overall quality and maintainability of your code base.

..  _production-logging-rotation:

Use log rotation
================

..  versionadded:: 13.0

Replace :php-short:`\TYPO3\CMS\Core\Log\Writer\FileWriter`
with :php-short:`\TYPO3\CMS\Core\Log\Writer\RotatingFileWriter`. Define a
rotation interval and specify how many rotated files should be retained.

..  seealso::

    *   `RotatingFileWriter configuration <https://docs.typo3.org/permalink/t3coreapi:logging-writers-rotatingfilewriter>`_

The following example adds log rotation for the "main" log file:

..  literalinclude:: /ApiOverview/Logging/Writers/_additionalRotationFileWriter.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

If you are using extensions such as
:composer:`apache-solr-for-typo3/solr` that configure custom log files,
you also need to switch those log files to use the
:php-short:`\TYPO3\CMS\Core\Log\Writer\RotatingFileWriter`.

..  _production-logging-system-tools:

Use system-Level log management tools
=====================================

In addition to TYPO3's internal logging features, it is common practice to
use server-level tools to manage log files. These tools can rotate, archive,
compress, and delete log files based on size, age, or other criteria.

On Linux systems, consider using the following tools:

*   **logrotate** – A standard utility for automatic log rotation, commonly
    pre-installed on most Linux distributions. It can be configured to manage
    TYPO3 logs and system logs.

*   **systemd-journald** – If your server uses systemd, you can use
    journald for logging, with configurable rotation and retention.

*   **cron jobs with custom scripts** – For more specific needs, administrators
    can use scheduled scripts to archive or delete logs periodically.

..  tip::

    If using `logrotate`, ensure the log directory (e.g.,
    :file:`var/log/`) is included in the configuration, and set appropriate
    permissions so the rotation process can access the files.

..  _production-logging-centralized:

Use centralized error monitoring (e.g., Sentry)
===============================================

In many production environments, it is common to offload error tracking to a
centralized service like `Sentry <https://sentry.io>`_. These tools
capture unhandled exceptions and application errors with full context,
including stack traces, request details, and environment variables.

Sentry can often **replace the need for local error log management**,
especially when it is used as the main tool for observing application behavior
and alerting failures. However, local logs may still be useful for storing
lower-level messages, audit trails, or when dealing with infrastructure-related
issues.

TYPO3 supports Sentry integration via third-party extensions such as:

*   :composer:`networkteam/sentry-client` (A Sentry client for TYPO3)

..  tip::

    Sentry is best suited for tracking uncaught exceptions and user-facing
    errors. It is not designed to store full application logs such as debug
    output or access logs.

..  _deprecation-disable-errors:

Disabling the deprecation log on production
===========================================

By default, when the
`Application Context <https://docs.typo3.org/permalink/t3coreapi:application-context>`_
is set to `Production`, the deprecation log is disabled.

Check the log directory, for example :path:`/path/to/project/var/log` and ensure
no logfile has been written with `deprecation` in the name.

As best practice you should only configure
deprecation logs for `Development` contexts, for example:

..  literalinclude:: /ApiOverview/Deprecation/_additional.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

If the deprecation log is still being written in production,
you can explicitly disable it by unsetting its configuration:

..  literalinclude:: _codesnippets/_disableDeprecationLog.php
    :caption: config/system/additional.php | typo3conf/system/additional.php

If the deprecation log continues to be written, check the following:

#.  **Verify the Application Context**

    The current context (e.g., `Production`) is shown in the top bar of the TYPO3
    backend under the :guilabel:`System Information` module.

#.  **Check the resolved configuration**

    Use the :guilabel:`System > Configuration` module (requires
    :composer:`typo3/cms-lowlevel`) to inspect the effective value of
    `$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']`.

#.  **Look for overrides in extensions**

    Some extensions may override logging settings in their
    :file:`ext_localconf.php` or :file:`ext_tables.php`. Check these files
    if your configuration appears to be ignored.

..  _production-logging-security:

Securing TYPO3 logs in production
=================================

TYPO3 logs may contain sensitive information that could be exploited by an
attacker to gain information about your system. Logs may also include personal
data such as IP addresses, which must be handled with care to ensure
privacy compliance.

**In Composer-based TYPO3 installations**, logs are written to
:path:`/path/to/project/var/log` by default. Since this directory is
located *outside* the web server’s document root
(:path:`/path/to/project/public`), it cannot be accessed directly from the
internet—providing a level of built-in security.

**In Classic-mode TYPO3 installations**, logs are stored in
:path:`/path/to/project/typo3conf/var/log`. Because the document root in
Classic mode typically points to :path:`/path/to/project`, this log
directory is publicly accessible by default. **Additional precautions must
be taken** to prevent unauthorized access.

..  seealso::

    *   `Secure file permissions (operating system level) <https://docs.typo3.org/permalink/t3coreapi:security-file-directory-permissions>`_
    *   `Restrict HTTP access <https://docs.typo3.org/permalink/t3coreapi:security-restrict-access-server-level>`_ (for Classic mode)
