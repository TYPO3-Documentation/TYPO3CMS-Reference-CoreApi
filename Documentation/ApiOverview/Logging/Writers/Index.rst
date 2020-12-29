.. include:: /Includes.rst.txt


.. _logging-writers:

===========
Log Writers
===========

The purpose of a log writer is (usually) to save all log records into a persistent storage,
like a log file, a database table, or to a remote syslog server.

Different log writers offer possibilities to log into different targets.
Custom log writers can extend the functionality shipped with TYPO3 Core .


.. _logging-writers-builtin:

Built-in Log Writers
====================

This section describes the log writers shipped with the TYPO3 Core .
Some writers have options to allow customization of the particular writer.
See the :ref:`Configuration <logging-configuration-writer>` section for how to use these options.


.. _logging-writers-database:

DatabaseWriter
--------------

The database writer logs into a database table. This table has to reside
in the database used by TYPO3 and is **not** automatically created.

========  =========  ==============  ===============
Option    Mandatory  Description     Default
========  =========  ==============  ===============
logTable  no         Database table  :code:`sys_log`
========  =========  ==============  ===============

.. warning::

   The **ADMIN TOOLS > Log** module is not adapted to the records written by the
   :code:`DatabaseWriter` into the :code:`sys_log` table. If you write such records
   there, you will not be able to see them using that module.

*Tip:* There's a tool for viewing such records in the TYPO3 backend at
`gitlab.com/co-stack.com/co-stack.com/typo3-extensions/logs <https://gitlab.com/co-stack.com/co-stack.com/typo3-extensions/logs>`__.

Example of a CREATE TABLE statement for logTable:

.. code-block:: mysql

   #
   # Table structure for table 'tx_examples_log'
   #
   # The KEY on request_id is optional
   #
   CREATE TABLE tx_examples_log (
           request_id varchar(13) DEFAULT '' NOT NULL,
           time_micro double(16,4) NOT NULL default '0.0000',
           component varchar(255) DEFAULT '' NOT NULL,
           level tinyint(1) unsigned DEFAULT '0' NOT NULL,
           message text,
           data text,

           KEY request (request_id)
   );

The corresponding configuration might look like this for the example class :code:`\T3docs\Examples\Controller`:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::DEBUG] = [
      \TYPO3\CMS\Core\Log\Writer\DatabaseWriter::class => [
        'logTable' => 'tx_examples_log'
      ],
   ];


.. warning::

   If you are using a MariaDB Galera Cluster you should definitely add a primary key field
   to the database definition, since it is required by Galera (this can be a normal `uid` field as known from other tables):
   `MariaDB Galera Cluster - Known Limitations <https://mariadb.com/kb/en/mariadb/mariadb-galera-cluster-known-limitations/>`__.

.. _logging-writers-FileWriter:

FileWriter
----------

The file writer logs into a log file, one log record per line.
If the log file does not exist, it will be created (including parent directories, if needed).
Please make sure that your web server has write-permissions to that path
and it is below the root directory of your web site (defined by :code:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`). The filename is
appended with a hash, that depends on the encryption key.
If :code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['generateApacheHtaccess']` is set,
an :file:`.htaccess` file is added to the directory.
It protects your log files from being accessed from the web.
If the log file is not set, then TYPO3 will use a filename containing a random hash,
like :file:`typo3temp/logs/typo3_7ac500bce5.log`.

============  =========  ====================================================  ================
Option        Mandatory  Description                                           Default
============  =========  ====================================================  ================
logFile       no         Path to log file                                      :file:`typo3temp/logs/typo3_<hash>.log` like for example :file:`typo3temp/logs/typo3_7ac500bce5.log`
logFileInfix  no         Different file name to the default log configuration  :php:`'logFileInfix' => 'special'` results in :file:`typo3\_special\_<hash>.log`
============  =========  ====================================================  ================

The corresponding configuration might look like this for the example class :code:`\T3docs\Examples\Controller` :

.. code-block:: php

   // Add example configuration for the logging API
   $GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']['writerConfiguration'] = [
       // configuration for ERROR level log entries
       \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
           // add a FileWriter
           \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
               // configuration for the writer
               'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/typo3_examples.log'
           ]
       ]
   ];


.. _logging-writers-php:

PhpErrorLogWriter
-----------------

Logs into the PHP error log using `error_log()`_

.. _error_log(): http://www.php.net/manual/en/function.error-log.php

.. _logging-writers-syslog:

SyslogWriter
------------

Logs into the syslog (Unix only).


========  =========  ================  ========
Option    Mandatory  Description       Default
========  =========  ================  ========
facility  no         Syslog Facility_  ``USER``
                     to log into.
========  =========  ================  ========

.. _Facility: http://en.wikipedia.org/wiki/Syslog#Facility_Levels


.. _logging-writers-custom:

Custom Log Writers
==================

Custom log writers can be added through extensions.
Every log writer has to implement the interface :code:`\TYPO3\CMS\Core\Log\Writer\WriterInterface`.
It is suggested to extend the abstract class :code:`\TYPO3\CMS\Core\Log\Writer\AbstractWriter`
which allows you use configuration options by adding the corresponding properties and setter methods.

Please keep in mind that TYPO3 will silently continue operating,
in case a log writer is throwing an exception while executing the :code:`writeLog()` method.
Only in the case that all registered writers fail, the log entry plus additional information
will be added to the configured fallback logger (which defaults to
the :ref:`PhpErrorLog <logging-writers-php>` writer).

.. _logging-writers-usage:

Usage in Custom Class
---------------------

All log writers can be used in your own classes. You can initialize the loggers in the __construct method of your class :code:`\MyDomain\MyExtension\MyFolder\MyClass`.

.. code-block:: php

    namespace MyDomain\MyExtension\MyFolder;

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Log\LogManager;

    class MyClass {
        private $logger;

        public function __construct()
        {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }
    }


The logger can be configured via :file:`ext_localconf.php` then:

.. code-block:: php

   // Add example configuration for the logging API
   $GLOBALS['TYPO3_CONF_VARS']['LOG']['MyDomain']['MyExtension']['MyFolder']['MyClass']['writerConfiguration'] = [
       // configuration for ERROR level log entries
       \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
           // add a FileWriter
           \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
               // configuration for the writer
               'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/typo3_examples.log'
           ]
       ]
   ];



.. _logging-writers-examples:

Examples
========

Working examples of the usage of different Log writers can be found in the extension
`examples <https://extensions.typo3.org/extension/examples/>`__. they are configured in
the :file:`ext_localconf.php`.
