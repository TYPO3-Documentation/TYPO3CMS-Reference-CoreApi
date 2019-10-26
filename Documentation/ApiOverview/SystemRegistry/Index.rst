.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _registry:

===============
System Registry
===============


The purpose of the registry (introduced in TYPO3 4.3) is to hold key-
value pairs of information. You can actually think of it being an
equivalent to the Windows registry (just not as complicated).

You might use the registry to store information that your script needs
to store across sessions or request.

An example would be a setting that needs to be altered by a PHP
script, which currently is not possible with TypoScript.

Another example: The scheduler system extension stores when it ran the
last time. The reports system extension then checks that value, in
case it determines that the scheduler hasn't run for a while it issues
a warning. While this might not be of great use to anyone with an
actual cron job set up for the scheduler, it is of use for users that
have to run the scheduler tasks by hand due to missing access to a
cron job.

The registry is not meant to store things that are supposed to go into
a session or a cache, use the appropriate API for these instead.


.. _registry-table:

The registry table (sys\_registry)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Here's a description of the fields found in the sys\_registry table:

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
         Represents an entry's namespace. In general the namespace is an
         extension key starting with "tx\_", a user script's prefix "user\_",
         or "core" for entries that belong to the core.

         The point of namespaces is that entries with the same key can exist
         inside different namespaces.


 - :Field:
         entry\_key
   :Type:
         varchar (255)
   :Description:
         The entry's key. Together with the namespace the key is unique for the
         whole table. The key can be any string to identify the entry. It's
         recommended to use dots as dividers if necessary. This way the naming
         is similar to the already known syntax in TypoScript.


 - :Field:
         entry\_value
   :Type:
         blob
   :Description:
         The entry's actual value. The value is stored as a serialized string,
         thus you can even store arrays or objects in a registry entry – it's
         not recommended though. Using phpMyAdmin's Show BLOB option you can
         check the value in that field although being stored as a binary.


.. _registry-api:

The registry API
^^^^^^^^^^^^^^^^

To use the registry, there's an easy to use API. Simply use
the code below to retrieve an instance of
the registry. The instance returned will always be the same as the
registry is a singleton::

   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Registry');

After retrieving an instance of the registry you can access the
registry values through its :code:`get()` method. The :code:`get()` method offers an
interesting third parameter to specify a default value, that value is
returned in case the requested entry was not found in the registry.
That happens when accessing an entry for the first time for example.
Setting a value is easy as well using the :code:`set()` method.

.. t3-field-list-table::
 :header-rows: 1

 - :Method,20: Method
   :Parameters,30: Parameters
   :Description,50: Description


 - :Method:
         set
   :Parameters:
         **$namespace** : namespace in which to set the value

         **$key** : the key of the value to set

         **$value** : the value to store
   :Description:
         Represents an entry's namespace. In general the namespace is an
         extension key starting with "tx\_", a user script's prefix "user\_",
         or "core" for entries that belong to the core.


 - :Method:
         get
   :Parameters:
         **$namespace** : namespace to get the value from

         **$key** : the key of the value to retrieve

         **$defaultValue** : a default value if the key was not found in the
         given namespace
   :Description:
         Used to get a value from the registry.


 - :Method:
         remove
   :Parameters:
         **$namespace** : namespace to remove the value from

         **$key** : the key of the value to remove
   :Description:
         Remove an entry from a given namespace.


 - :Method:
         removeAllByNamespace
   :Parameters:
         **$namespace** : namespace to empty
   :Description:
         Deletes all value for a given namespace.


Note that you should not store binary data into the registry, it's not
designed to do that. Use the filesystem instead, if you have such
needs.


.. _registry-examples:

Examples
""""""""

Here's an example taken from the Scheduler system extension::

   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Registry');
   $runInformation = array('start' => $GLOBALS['EXEC_TIME'], 'end' => time(), 'type' => $type);
   $registry->set('tx_scheduler', 'lastRun', $runInformation);

It is retrieved later using::

   $registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Registry');
   $lastRun = $registry->get('tx_scheduler', 'lastRun');


