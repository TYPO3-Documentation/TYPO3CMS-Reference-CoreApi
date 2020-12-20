.. include:: /Includes.rst.txt


.. _registry:

===============
System Registry
===============

The purpose of the registry is to store key-value pairs of information. It can
be considered an equivalent to the Windows registry (only not as complicated).

You might use the registry to hold information that your script needs
to store across sessions or requests.

An example would be a setting that needs to be altered by a PHP
script, which currently is not possible with TypoScript.

Another example: The Scheduler system extension stores when it ran the
last time. The Reports system extension then checks that value, in
case it determines that the Scheduler hasn't run for a while, it issues
a warning. While this might not be of much use to someone who has set up an
actual cron job for the Scheduler, but it is useful for users who
need to run the Scheduler tasks manually due to a lack of access to a
cron job.

The registry is not intended to store things that are supposed to go into
a session or a cache, use the appropriate API for them instead.


.. _registry-table:

The Registry Table (sys\_registry)
==================================

Here's a description of the fields that can be found in the `sys_registry`
table:

.. t3-field-list-table::
 :header-rows: 1

 - :Field,20: Field
   :Type,20: Type
   :Description,60: Description


 - :Field:
         uid
   :Type:
         int
   :Description:
         Primary key, needed for replication and also useful as an index.


 - :Field:
         entry\_namespace
   :Type:
         varchar (128)
   :Description:
         Represents an entry's namespace. In general, the namespace is an
         extension key starting with `tx_`, a user script's prefix `user_`,
         or `core` for entries that belong to the Core.

         The purpose of namespaces is that entries with the same key can exist
         within different namespaces.


 - :Field:
         entry\_key
   :Type:
         varchar (255)
   :Description:
         The entry's key. Together with the namespace, the key is unique for the
         whole table. The key can be any string to identify the entry. It's
         recommended to use dots as dividers if necessary. In this way, the
         naming is similar to the syntax already known in TypoScript.


 - :Field:
         entry\_value
   :Type:
         blob
   :Description:
         The entry's actual value. The value is stored as a serialized string,
         thus you can even store arrays or objects in a registry entry – it's
         not recommended though. Using phpMyAdmin's `Show BLOB` option allows
         you to check the value in this field even though it is stored as a
         binary.


.. _registry-api:

The Registry API
================

There is an easy-to-use API for using the registry. Simply call the following
code to retrieve an instance of the registry. The instance returned will always
be the same, as the registry is a singleton::

   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);

After retrieving an instance of the registry, you can access the registry values
through its :php:`get()` method. The :php:`get()` method provides an
interesting third parameter to specify a default value that is returned if the
requested entry is not found in the registry. This happens, for example, the
first time an entry is accessed. Setting a value is also easy with the
:php:`set()` method.

.. t3-field-list-table::
 :header-rows: 1

 - :Method,20: Method
   :Parameters,30: Parameters
   :Description,50: Description


 - :Method:
         set
   :Parameters:
         **$namespace** : namespace in which the value to set

         **$key** : the key of the value to set

         **$value** : the value to store
   :Description:
         Represents an entry's namespace. In general, the namespace is an
         extension key that starts with `tx_`, a user script's prefix `user_`,
         or `core` for entries that belong to the Core.


 - :Method:
         get
   :Parameters:
         **$namespace** : namespace from which the value is to be obtained

         **$key** : the key of the value to be retrieved

         **$defaultValue** : a default value if the key was not found in the
         given namespace
   :Description:
         Used to get a value from the registry.


 - :Method:
         remove
   :Parameters:
         **$namespace** : namespace from which the value is to be removed

         **$key** : the key of the value to be removed
   :Description:
         Remove an entry from a given namespace.


 - :Method:
         removeAllByNamespace
   :Parameters:
         **$namespace** : namespace to be emptied
   :Description:
         Deletes all values for a given namespace.


.. note::
   Do not store binary data in the registry, it it not intended for this
   purpose. Use the file system instead, if you have such needs.


.. _registry-examples:

Examples
--------

Here's an example taken from the Scheduler system extension::

   $context = GeneralUtility::makeInstance(Context::class);
   $requestStartTimestamp = $context->getPropertyFromAspect('date', 'timestamp');
   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);
   $runInformation = array('start' => $requestStartTimestamp, 'end' => time(), 'type' => $type);
   $registry->set('tx_scheduler', 'lastRun', $runInformation);

It is retrieved later using::

   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);
   $lastRun = $registry->get('tx_scheduler', 'lastRun');

