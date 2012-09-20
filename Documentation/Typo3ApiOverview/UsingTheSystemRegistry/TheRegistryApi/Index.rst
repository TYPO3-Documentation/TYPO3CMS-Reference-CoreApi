

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


The registry API
^^^^^^^^^^^^^^^^

To use the registry, there's an easy to use API. Simply use
t3lib\_div::makeInstance('t3lib\_Registry')to retrieve an instance of
the registry. The instance returned will always be the same as the
registry is a singleton:

::

   $registry = t3lib_div::makeInstance('t3lib_Registry');

After retrieving an instance of the registry you can access the
registry values through its get() method. The get() method offers an
interesting third parameter to specify a default value, that value is
returned in case the requested entry was not found in the registry.
That happens when accessing an entry for the first time for example.
Setting a value is easy as well by using the set() method.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method

   Parameters
         Parameters

   Description
         Description


.. container:: table-row

   Method
         set

   Parameters
         **$namespace** : namespace in which to set the value

         **$key** : the key of the value to set

         **$value** : the value to store

   Description
         Represents an entry's namespace. In general the namespace is an
         extension key starting with "tx\_", a user script's prefix "user\_",
         or "core" for entries that belong to the core.


.. container:: table-row

   Method
         get

   Parameters
         **$namespace** : namespace to get the value from

         **$key** : the key of the value to retrieve

         **$defaultValue** : a default value if the key was not found in the
         given namespace

   Description
         Used to get a value from the registry.


.. container:: table-row

   Method
         remove

   Parameters
         **$namespace** : namespace to remove the value from

         **$key** : the key of the value to remove

   Description
         Remove an entry from a given namespace.


.. container:: table-row

   Method
         removeAllByNamespace

   Parameters
         **$namespace** : namespace to empty

   Description
         Deletes all value for a given namespace.


.. ###### END~OF~TABLE ######

Note that you should not store binary data into the registry, it's not
designed to do that. Use the filesystem instead, if you have such
needs.


Examples
""""""""

Here's an example taken from the Scheduler system extension:

::

   $registry = t3lib_div::makeInstance('t3lib_Registry');
   $runInformation = array('start' => $GLOBALS['EXEC_TIME'], 'end' => time(), 'type' => $type);
   $registry->set('tx_scheduler', 'lastRun', $runInformation);

It is retrieved later using:

::

   $registry = t3lib_div::makeInstance('t3lib_Registry');
   $lastRun = $registry->get('tx_scheduler', 'lastRun');

