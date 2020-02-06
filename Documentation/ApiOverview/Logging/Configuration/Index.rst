.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _logging-configuration:

Configuration of the Logging system
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Instantiation of Loggers is configuration-free, as the LogManager automatically applies its configuration.

The Logger configuration is read from :code:`$GLOBALS['TYPO3_CONF_VARS']['LOG']`, which contains an array reflecting the namespace
and class hierarchy of your TYPO3 project.

Example:

To apply a configuration for all Loggers within the :code:`\TYPO3\CMS\Core\Cache` namespace,
the configuration is read from :code:`$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['Core']['Cache']`.
So every logger requested for classes like :code:`\TYPO3\CMS\Core\Cache\CacheFactory`,
:code:`\TYPO3\CMS\Core\Cache\Backend\NullBackend`, etc. will get this configuration applied.
The same holds for the old pseudo-namespaces with underscore separator which
are still common in extensions.

Configuring Logging for extensions works the same. If an extension uses namespaces,
the syntax for the configuration is as above.

For older extensions, configuration is
searched for in :code:`$GLOBALS['TYPO3_CONF_VARS']['LOG']['tx']` or :code:`$GLOBALS['TYPO3_CONF_VARS']['LOG']['Tx']` to differentiate extension classes
from Core classes (as extension class names start with :code:`tx` or :code:`Tx`).


.. _logging-configuration-writer:

Writer configuration
""""""""""""""""""""

The Log Writer configuration is read from the subkey :code:`writerConfiguration` of the configuration array:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'] = array(
       // configuration for ERROR level log entries
     \TYPO3\CMS\Core\Log\LogLevel::ERROR => array(
         // add a FileWriter
       'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
           // configuration for the writer
         'logFile' => 'typo3temp/logs/typo3_7ac500bce5.log'
       )
     )
   );

The above configuration applies to **all** log entries of level "ERROR" or above.

To apply a special configuration for the controllers of the *examples* extension,
use the following configuration:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['Documentation']['Examples']['Controller']['writerConfiguration'] = array(
		// configuration for WARNING severity, including all
		// levels with higher severity (ERROR, CRITICAL, EMERGENCY)
       \TYPO3\CMS\Core\Log\LogLevel::WARNING => array(
        // add a SyslogWriter
           'TYPO3\\CMS\\Core\\Log\\Writer\\SyslogWriter' => array(),
       ),
   );

This overwrites the default configuration shown in the first example for classes
located in the namespace :code:`\Documentation\Examples\Controller`.

For extension "foo" with key "tx_foo" (not using namespaces), the configuration would be located at:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['Tx']['Foo']['writerConfiguration'] = array(
   	...
   );

An arbitrary number of writers can be added for every severity level (INFO, WARNING, ERROR, ...).
The configuration is applied to log entries of the particular severity level
plus all levels with a higher severity. Thus, a log messages created with :code:`$logger->warning()`
will be affected by the writerConfiguration for the log levels:

* :php:`LogLevel::DEBUG`
* :php:`LogLevel::INFO`
* :php:`LogLevel::NOTICE`
* :php:`LogLevel::WARNING`

For the above example code that means:

- Calling :code:`$logger->warning($msg);` will result in $msg being written to the computer's syslog
  on top of the default configuration.
- Calling :code:`$logger->debug($msg);` will result in $msg being written
  only to the default log file (:file:`typo3temp/logs/typo3.log`).

For a list of writers shipped with the TYPO3 Core see the section about
:ref:`logging-writers`.


.. _logging-configuration-processor:

Processor configuration
"""""""""""""""""""""""

Similar to the writer configuration, log record processors can be configured on a per-class and per-namespace
basis from the subkey :code:`processorConfiguration`

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['LOG']['Documentation']['Examples']['Controller']['processorConfiguration'] = array(
       // configuration for ERROR level log entries
     \TYPO3\CMS\Core\Log\LogLevel::ERROR => array(
         // add a MemoyUsageProcessor
       'TYPO3\\CMS\\Core\\Log\\Processor\\MemoryUsage' => array(
         'formatSize' => TRUE
       )
     )
   );

For a list of processors shipped with the TYPO3 Core, see the section about :ref:`logging-processors`.
