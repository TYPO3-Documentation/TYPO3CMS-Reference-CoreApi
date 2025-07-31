:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  index:: pair: Logging; Configuration
..  _logging-configuration:

===================================
Configuration of the logging system
===================================

The instantiation of :ref:`loggers <logging-logger>` is configuration-free, as
the log manager automatically applies its configuration.

The logger configuration is read from :php:`$GLOBALS['TYPO3_CONF_VARS']['LOG']`,
which contains an array reflecting the namespace and class hierarchy of your
TYPO3 project.

..  seealso::

    Are you configuring logging for a live TYPO3 instance?
    See :ref:`production-logging` for best practices on logging in production
    environments, including log rotation, log levels, file storage, and
    monitoring tools like Sentry.

For example, to apply a configuration for all loggers within the
:php:`\TYPO3\CMS\Core\Cache` namespace, the configuration is read from
:php:`$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['Core']['Cache']`.
So every logger requested for classes like :php:`\TYPO3\CMS\Core\Cache\CacheFactory`,
:php:`\TYPO3\CMS\Core\Cache\Backend\NullBackend`, etc. will get this
configuration applied.

Configuring the logging for extensions works the same.


..  index:: Logging; Writer configuration
..  _logging-configuration-writer:

Writer configuration
====================

The :ref:`log writer <logging-writers>` configuration is read from the sub-key
:php:`writerConfiguration` of the configuration array:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'] = [
        // Configuration for ERROR level log entries
        \Psr\Log\LogLevel::ERROR => [
            // Add a FileWriter
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                // Configuration for the writer
                'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/typo3_7ac500bce5.log'
            ],
        ],
    ];

The above configuration applies to **all** log entries of level "ERROR" or above.

..  note::
    The default folder for log files is :file:`<var-path>/log`.
    The `<var-path>` is :file:`<project-root>/var/` for Composer-based
    installations and :file:`typo3temp/var/` for Classic mode installations.

To apply a special configuration for the controllers of the *examples* extension,
use the following configuration:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']['writerConfiguration'] = [
        // Configuration for WARNING severity, including all
        // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
        \Psr\Log\LogLevel::WARNING => [
            // Add a SyslogWriter
            \TYPO3\CMS\Core\Log\Writer\SyslogWriter::class => [],
        ],
    ];

This overwrites the default configuration shown in the first example for classes
located in the namespace :php:`\T3docs\Examples\Controller`.

One more example:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    // Configure logging ...

    // For class \T3docs\Examples\Controller\FalExampleController
    $GLOBALS['TYPO3_CONF_VARS']['LOG']
        ['T3docs']['Examples']['Controller']['FalExampleController']
        ['writerConfiguration'] = [
            // ...
        ];

    // For channel "security"
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['security']['writerConfiguration'] = [
        // ...
    ];

For more information about channels, see :ref:`logging-channels`.

An arbitrary number of writers can be added for every severity level (INFO,
WARNING, ERROR, ...). The configuration is applied to log entries of the
particular severity level plus all levels with a higher severity. Thus, a log
message created with :php:`$logger->warning()` will be affected by the
writer configuration for the log levels:

*   :php:`LogLevel::DEBUG`
*   :php:`LogLevel::INFO`
*   :php:`LogLevel::NOTICE`
*   :php:`LogLevel::WARNING`

For the above example code that means:

*   Calling :php:`$logger->warning($msg);` will result in :php:`$msg` being
    written to the computer's syslog on top of the default configuration.
*   Calling :php:`$logger->debug($msg);` will result in :php:`$msg` being
    written only to the default log file (:file:`var/log/typo3_<hash>.log`).

For a list of writers shipped with the TYPO3 Core see the section about
:ref:`logging-writers`.


..  index:: Logging; Processor configuration
..  _logging-configuration-processor:

Processor configuration
=======================

Similar to the writer configuration, :ref:`log record processors <logging-processors>`
can be configured on a per-class and per-namespace basis with the sub-key
:php:`processorConfiguration`:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']['processorConfiguration'] = [
        // Configuration for ERROR level log entries
        \Psr\Log\LogLevel::ERROR => [
            // Add a MemoryUsageProcessor
            \TYPO3\CMS\Core\Log\Processor\MemoryUsageProcessor::class => [
                'formatSize' => TRUE
            ],
        ],
    ];

For a list of processors shipped with the TYPO3 Core, see the section about
:ref:`logging-processors`.

..    _logging-configuration-disable:

Disable all logging
===================

In some setups it is desirable to disable all logs and to only enable them on demand.
You can disable all logs by unsetting :php:`$GLOBALS['TYPO3_CONF_VARS']['LOG']` at the
end of your :ref:`additional.php <typo3ConfVars-additional>`:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    // disable all logging
    unset($GLOBALS['TYPO3_CONF_VARS']['LOG']);

You can then temporarily enable logging by commenting out this line:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    // unset($GLOBALS['TYPO3_CONF_VARS']['LOG']);
    // By commenting out the line above you can enable logging again.
