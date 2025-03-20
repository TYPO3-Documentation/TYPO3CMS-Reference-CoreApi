..  include:: /Includes.rst.txt
..  index:: System registry
..  _registry:

===============
System registry
===============

.. contents::
   :local:

Introduction
============

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

..  index:: System registry; API
..  _registry-api:

The registry API
================

TYPO3 provides an API for using the registry. You can inject an instance of
the :php:`Registry` class via :ref:`dependency injection <DependencyInjection>`.
The instance returned will always be the same, as the registry is a singleton:

..  literalinclude:: _Injection.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php

You can access registry values through its :php:`get()` method. The :php:`get()`
method provides a third parameter to specify a default value that is returned,
if the requested entry is not found in the registry. This happens, for example,
the first time an entry is accessed. A value can be set with the :php:`set()`
method.

..  note::
    Do not store binary data in the registry, it is not intended for this
    purpose. Use the file system instead, if you have such needs.


..  _registry-examples:

Example
-------

The registry can be used, for example, to write run information of a
:ref:`console command <symfony-console-commands>` into the registry:

..  literalinclude:: _MyCommand.php
    :language: php
    :caption: EXT:my_extension/Classes/Command/MyCommand.php

This information can be retrieved later using:

..  literalinclude:: _MyClass.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php


API
---

..  include:: /CodeSnippets/Manual/Registry/Registry.rst.txt


..  index:: Table; sys_registry
..  _registry-table:

The registry table (`sys_registry`)
===================================

Following a description of the fields that can be found in the `sys_registry`
table:

..  confval:: uid
    :name: sys-registry-uid
    :type: int

    Primary key, needed for replication and also useful as an index.

..  confval:: entry_namespace
    :name: sys-registry-entry-namespace
    :type: varchar(128)

    Represents an entry's namespace. In general, the namespace is an
    extension key starting with `tx_`, a user script's prefix `user_`,
    or `core` for entries that belong to the Core.

    The purpose of namespaces is that entries with the same key can exist
    within different namespaces.

..  confval:: entry_key
    :name: sys-registry-entry-key
    :type: varchar(128)

    The entry's key. Together with the namespace, the key is unique for the
    whole table. The key can be any string to identify the entry. It is
    recommended to use dots as dividers, if necessary. In this way, the
    naming is similar to the syntax already known in TypoScript.

..  confval:: entry_value
    :name: sys-registry-entry-value
    :type: mediumblob

    The entry's actual value. The value is stored as a serialized string,
    thus you can even store arrays or objects in a registry entry – it is
    not recommended though. The value in this field is stored as a binary.
