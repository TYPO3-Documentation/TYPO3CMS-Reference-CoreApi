..  include:: /Includes.rst.txt

..  _logging-writers:

===========
Log writers
===========

The purpose of a log writer is (usually) to save all log records into a
persistent storage, like a log file, a database table, or to a remote syslog
server.

Different log writers offer possibilities to log into different targets.
:ref:`Custom log writers <logging-writers-custom>` can extend the functionality
shipped with TYPO3 Core.

..  contents:: **Table of Contents**
    :local:


..  _logging-writers-builtin:

Built-in log writers
====================

This section describes the log writers shipped with the TYPO3 Core.
Some writers have options to allow customization of the particular writer.
See the :ref:`configuration <logging-configuration-writer>` section on how to
use these options.


..  _logging-writers-database:

DatabaseWriter
--------------

The database writer logs into a database table. This table has to reside
in the database used by TYPO3 and is **not** automatically created.

The following option is available:

..  confval:: logTable

    :type: string
    :Mandatory: no
    :Default: :sql:`sys_log`

    The database table to write to.

    ..  warning::
        The :guilabel:`Admin Tools > Log` module is not adapted to the records
        written by the :php:`DatabaseWriter` into the :sql:`sys_log` table. If
        you write such records there, you will not be able to see them using
        that module.

    ..  tip::
        There is the third-party extension :t3ext:`logs` available for viewing
        such records in the TYPO3 backend.

    Example of a :sql:`CREATE TABLE` statement for :php:`logTable`:

    ..  literalinclude:: _ext_tables.sql
        :language: sql
        :caption: EXT:my_extension/ext_tables.sql

    The corresponding configuration might look like this for the example class
    :php:`\T3docs\Examples\Controller`:

    ..  literalinclude:: _ext_localconf.php
        :language: php
        :caption: EXT:my_extension/ext_localconf.php

..  warning::
    If you are using a MariaDB Galera Cluster you should definitely add a
    primary key field to the database definition, since it is required by
    Galera (this can be a normal :sql:`uid` autoincrement field as known from
    other tables):
    `MariaDB Galera Cluster - Known Limitations <https://mariadb.com/kb/en/mariadb/mariadb-galera-cluster-known-limitations/>`__.


..  _logging-writers-FileWriter:

FileWriter
----------

The file writer logs into a log file, one log record per line. If the log file
does not exist, it will be created (including parent directories, if needed).

Please make sure:

*   Your web server has write permissions to that path.
*   The path is below the root directory of your website (defined by
    :ref:`Environment::getPublicPath() <Environment-public-path>`).

The filename is appended with a hash, that depends on the
:ref:`encryption key <typo3ConfVars_sys_encryptionKey>`. If
:ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['generateApacheHtaccess'] <typo3ConfVars_sys_generateApacheHtaccess>`
is set, an :file:`.htaccess` file is added to the directory. It protects your
log files from being accessed from the web. If the :php:`logFile` option is not
set, TYPO3 will use a filename containing a random hash, like
:file:`typo3temp/logs/typo3_7ac500bce5.log`.

The following options are available:

..  confval:: logFile

    :type: string
    :Mandatory: no
    :Default: :file:`typo3temp/logs/typo3_<hash>.log`
              (for example, like :file:`typo3temp/logs/typo3_7ac500bce5.log`)

    The path to the log file.

..  confval:: logFileInfix

    :type: string
    :Mandatory: no
    :Default: (empty string)

    This option allows to set a different name for the log file that is created
    by the :php:`FileWriter` without having to define a full path to the file.
    For example, the settings :php:`'logFileInfix' => 'special'` results in
    :file:`typo3_special_<hash>.log`.


The corresponding configuration might look like this for the example class
:php:`\T3docs\Examples\Controller`:

..  literalinclude:: _ext_localconf_FileWriter.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php


..  _logging-writers-RotatingFileWriter:

RotatingFileWriter
------------------

..  versionadded:: 13.0

TYPO3 log files tend to grow over time if not manually cleaned on a regular
basis, potentially leading to full disks. Also, reading its contents may be
hard when several weeks of log entries are printed as a wall of text.

To circumvent such issues, established tools like `logrotate`_ are available for
a long time already. However, TYPO3 may be installed on a hosting environment
where "logrotate" is not available and cannot be installed by the customer.
To cover such cases, a simple log rotation approach is available, following the
"copy/truncate" approach: when rotating files, the currently opened log file is
copied (for example, to `typo3_<hash>.log.20230616094812`) and the original log
file is emptied.

..  _logrotate: https://linux.die.net/man/8/logrotate

Example of the :file:`var/log/` folder with rotated log files:

..  code-block:: console

    $ ls -1 var/log
    typo3_<hash>.log
    typo3_<hash>.log.20230613065902
    typo3_<hash>.log.20230614084723
    typo3_<hash>.log.20230615084756
    typo3_<hash>.log.20230616094812

The file writer :php:`\TYPO3\CMS\Core\Log\Writer\RotatingFileWriter` extends the
`FileWriter <logging-writers-FileWriter>` class. The :php:`RotatingFileWriter`
accepts all options of :php:`FileWriter` in addition of the following:

..  confval:: interval

    :type: :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval`, string
    :Mandatory: no
    :Default: :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval::DAILY`

    The interval defines how often logs should be rotated. Use one of the
    following options:

    *   :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval::DAILY` or :php:`daily`
    *   :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval::WEEKLY` or :php:`weekly`
    *   :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval::MONTHLY` or :php:`monthly`
    *   :php:`\TYPO3\CMS\Core\Log\Writer\Enum\Interval::YEARLY` or :php:`yearly`

..  confval:: maxFiles

    :type: integer
    :Mandatory: non
    :Default: :php:`5`

    This option configured how many files should be retained (use :php:`0` to
    never delete any file).

..  note::
    When configuring the :php:`RotatingFileWriter` in
    :file:`system/settings.php`, the string representations of the
    :php:`Interval` cases must be used for the option :php:`interval` option,
    as otherwise this might break the Install Tool.

The following example introduces log rotation for the "main" log file:

..  literalinclude:: _additionalRotationFileWriter.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

Another example introduces log rotation for the "deprecation" log file:

..  literalinclude:: _additionalRotationFileWriterForDeprecations.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php


..  _logging-writers-php:

PhpErrorLogWriter
-----------------

This writer logs into the PHP error log using `error_log()`_

..  _error_log(): https://www.php.net/manual/en/function.error-log.php

..  _logging-writers-syslog:

SyslogWriter
------------

The syslog writer logs into the syslog (Unix only).

The following option is available:

..  confval:: facility

    :type: string
    :Mandatory: no
    :Default: ``USER``

    The syslog `facility`_ to log into.

    .. _facility: https://en.wikipedia.org/wiki/Syslog#Facility


..  _logging-writers-custom:

Custom log writers
==================

Custom log writers can be added through extensions. Every log writer has to
implement the interface :t3src:`core/Classes/Log/Writer/WriterInterface.php`. It is
suggested to extend the abstract class :t3src:`core/Classes/Log/Writer/AbstractWriter.php`
which allows you to use configuration options by adding the corresponding
properties and setter methods.

Please keep in mind that TYPO3 will silently continue operating, in case a log
writer is throwing an exception while executing the :php:`writeLog()` method.
Only in the case that all registered writers fail, the log entry with additional
information will be added to the configured fallback logger (which defaults to
the :ref:`PhpErrorLog <logging-writers-php>` writer).

..  _logging-writers-usage:

Usage in a custom class
-----------------------

All log writers can be used in your own classes. If the service is configured to
use autowiring you can inject a logger into the :php:`__construct()` method of
your class :php:`\MyVendor\MyExtension\MyFolder\MyClass`) since TYPO3 v11 LTS.

..  literalinclude:: _MyClassWithConstructorInjection.php
    :caption: EXT:my_extension/Classes/MyClass.php

If autowiring is disabled, the service class however must implement the
interface :php:`\Psr\Log\LoggerAwareInterface` and use the
:php:`\Psr\Log\LoggerAwareTrait`.

..  literalinclude:: _MyClassWithLoggerAwareInterface.php
    :caption: EXT:my_extension/Classes/MyClass.php

One or more log writers for this class are configured in the file
:file:`ext_localconf.php`:

..  literalinclude:: _ext_localconf_FileWriter_config.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  _logging-writers-examples:

Examples
========

Working examples of the usage of different Log writers can be found in the
extension :t3ext:`examples`.
