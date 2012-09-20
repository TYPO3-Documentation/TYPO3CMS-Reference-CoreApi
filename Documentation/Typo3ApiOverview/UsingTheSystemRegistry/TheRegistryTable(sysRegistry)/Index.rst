

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


The registry table (sys\_registry)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Here's a description of the fields found in the sys\_registry table:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Field
         Field

   Type
         Type

   Description
         Description


.. container:: table-row

   Field
         uid

   Type
         int

   Description
         Primary key, needed for replication and also usfull as an index.


.. container:: table-row

   Field
         entry\_namespace

   Type
         varchar (128)

   Description
         Represents an entry's namespace. In general the namespace is an
         extension key starting with "tx\_", a user script's prefix "user\_",
         or "core" for entries that belong to the core.

         The point of namespaces is that entries with the same key can exist
         inside different namespaces.


.. container:: table-row

   Field
         entry\_key

   Type
         varchar (255)

   Description
         The entry's key. Together with the namespace the key is unique for the
         whole table. The key can be any string to identify the entry. It's
         recommended to use dots as dividers if necessary. This way the naming
         is similar to the already known syntax in TypoScript.


.. container:: table-row

   Field
         entry\_value

   Type
         blob

   Description
         The entry's actual value. The value is stored as a serialized string,
         thus you can even store arrays or objects in a registry entry – it's
         not recommended though.Using phpMyAdmin's Show BLOB option you can
         check the value in that field although being stored as a binary.


.. ###### END~OF~TABLE ######

