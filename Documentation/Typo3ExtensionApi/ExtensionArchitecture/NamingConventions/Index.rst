

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


Naming conventions
^^^^^^^^^^^^^^^^^^

Based on the extension key of an extension these naming conventions
should be followed:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   a
   
   
   General
         General
   
   Example
         Example
   
   User specific
         User specific
   
   Example-2
         Example


.. container:: table-row

   a
         Extension key
         
         (Lowercase “alnum” + underscores. )
   
   General
         Assigned by the TYPO3 Extension Repository.
   
   Example
         cool\_shop
   
   User specific
         Determined by yourself, but prefixed “user\_”
   
   Example-2
         user\_my\_shop


.. container:: table-row

   a
         Database tables and fields
   
   General
         Prefix with “tx\_[ *key* ]\_” where key is  *without* underscores!
   
   Example
         **Prefix:** tx\_coolshop\_
         
         **Examples:**
         
         tx\_coolshop\_products
         
         tx\_coolshop\_categories
   
   User specific
         Prefix with “[ *key* ]\_”
   
   Example-2
         **Prefix:** user\_my\_shop\_
         
         **Examples:**
         
         user\_my\_shop\_products
         
         user\_my\_shop\_categories


.. container:: table-row

   a
         Backend module
         
         (Names are always  *without* underscores!)
   
   General
         Name: The extension key name  *without* underscores, prefixed “tx”
   
   Example
         txcoolshop
   
   User specific
         Name: No underscores, prefixed “u”
   
   Example-2
         uMyShop or umyshop or ...


.. container:: table-row

   a
         Frontend PHP classes
   
   General
         *(Same as database tables and fields. Prepend class file names
         “class.” though.)*


.. ###### END~OF~TABLE ######

You may also want to refer to the TYPO3 Core Coding Guidelines for
more on general naming conventions in TYPO3.


Best practice on using underscores
""""""""""""""""""""""""""""""""""

If you study the naming conventions above closely you will find that
they are complicated due to varying rules for underscores in key
names. Sometimes the underscores are stripped off, sometimes not.

The best practice you can follow is to  *avoid using underscores* in
your extensions keys at all! That will make the rules simpler. This is
highly encouraged.


Note on “old” and default extensions:
"""""""""""""""""""""""""""""""""""""

Some the “classic” extensions from before the extension structure came
about does not comply with these naming conventions. That is an
exception made for backwards compatibility. The assignment of new keys
from the TYPO3 Extension Repository will make sure that any of these
old names are not accidentially reassigned to new extensions.

Further, some of the classic plugins (tt\_board, tt\_guest etc) users
the “user\_” prefix for their classes as well.

