..  include:: /Includes.rst.txt
..  index:: System registry
..  _registry:

===============
System registry
===============

The purpose of the registry is to store key-value pairs of information. It can
be considered an equivalent to the Windows registry (only not as complicated).

You might use the registry to hold information that your script needs
to store across sessions or requests.

An example would be a setting that needs to be altered by a PHP
script, which currently is not possible with :ref:`TypoScript <t3tsref:start>`.

Another example: The :ref:`Scheduler system extension <ext_scheduler:start>`
stores when it ran the last time. The
:doc:`Reports system extension <ext_reports:Index>` then checks that value, in
case it determines that the Scheduler has not run for a while, it issues
a warning. While this might not be of much use to someone who has set up an
actual cron job for the Scheduler, but it is useful for users who
need to run the Scheduler tasks manually due to a lack of access to a
cron job.

The registry is not intended to store things that are supposed to go into
a :ref:`session <sessions>` or a :ref:`cache <caching>`, use the appropriate
API for them instead.


..  index:: Table; sys_registry
..  _registry-table:

The registry table (`sys_registry`)
===================================

Following a description of the fields that can be found in the `sys_registry`
table:

..  confval:: uid

    :Type: int

    Primary key, needed for replication and also useful as an index.

..  confval:: entry_namespace

    :Type: varchar(128)

    Represents an entry's namespace. In general, the namespace is an
    extension key starting with `tx_`, a user script's prefix `user_`,
    or `core` for entries that belong to the Core.

    The purpose of namespaces is that entries with the same key can exist
    within different namespaces.

..  confval:: entry_key

    :Type: varchar(128)

    The entry's key. Together with the namespace, the key is unique for the
    whole table. The key can be any string to identify the entry. It is
    recommended to use dots as dividers, if necessary. In this way, the
    naming is similar to the syntax already known in TypoScript.

..  confval:: entry_value

    :Type: mediumblob

    The entry's actual value. The value is stored as a serialized string,
    thus you can even store arrays or objects in a registry entry – it is
    not recommended though. The value in this field is stored as a binary.


..  index:: System registry; API
..  _registry-api:

The registry API
================

TYPO3 provides an API for using the registry. You can use the following
code to retrieve an instance of the registry. The instance returned will always
be the same, as the registry is a singleton:

..  literalinclude:: _instance.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php

After retrieving an instance of the registry, you can access the registry values
through its :php:`get()` method. The :php:`get()` method provides an
interesting third parameter to specify a default value that is returned, if the
requested entry is not found in the registry. This happens, for example, the
first time an entry is accessed. A value can be set with the :php:`set()` method.

..  note::
    Do not store binary data in the registry, it it not intended for this
    purpose. Use the file system instead, if you have such needs.


..  _registry-examples:

Examples
--------

Here is an example taken from the Scheduler system extension:

..  code-block:: php
    :caption: typo3/sysext/scheduler/Classes/Scheduler.php

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Registry;

    $context = GeneralUtility::makeInstance(Context::class);
    $requestStartTimestamp = $context->getPropertyFromAspect('date', 'timestamp');
    $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);
    $runInformation = array('start' => $requestStartTimestamp, 'end' => time(), 'type' => $type);
    $registry->set('tx_scheduler', 'lastRun', $runInformation);

It is retrieved later using:

..  code-block:: php
    :caption: typo3/sysext/scheduler/Classes/Scheduler.php

    $registry = GeneralUtility::makeInstance(Registry::class);
    $lastRun = $registry->get('tx_scheduler', 'lastRun');


API
---

..  include:: /CodeSnippets/Manual/Registry/Registry.rst.txt
