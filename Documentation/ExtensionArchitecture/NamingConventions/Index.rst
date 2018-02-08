.. include:: ../../Includes.txt


.. _extension-naming:

Naming conventions
^^^^^^^^^^^^^^^^^^

Based on the extension key of an extension these naming conventions
should be followed:

((this table is unreadable and about to be removed))

.. t3-field-list-table::
 :header-rows: 1

 - :Context,20:
   :General,20: General
   :Example,20: Example
   :User-specific,20: User-specific
   :Example-2,20: Example

 - :Context:
         Extension key

         (Lowercase "alnum" + underscores. )
   :General:
         Assigned by the TYPO3 Extension Repository.
   :Example:
         cool\_shop
   :User-specific:
         Determined by yourself, but prefixed "user\_"
   :Example-2:
         user\_my\_shop

 - :Context:
         Database tables and fields
   :General:
         Prefix with "tx\_[ *key* ]\_" where key is  *without* underscores!
   :Example:
         **Prefix:** tx\_coolshop\_

         **Examples:**

         tx\_coolshop\_products

         tx\_coolshop\_categories
   :User-specific:
         Prefix with "[ *key* ]\_"
   :Example-2:
         **Prefix:** user\_my\_shop\_

         **Examples:**

         user\_my\_shop\_products

         user\_my\_shop\_categories

 - :Context:
         Backend module

         (Names are always  *without* underscores!)
   :General:
         Name: The extension key name  *without* underscores, prefixed "tx"
   :Example:
         txcoolshop
   :User-specific:
         Name: No underscores, prefixed "u"
   :Example-2:
         uMyShop or umyshop or ...

Abbreviations
   | TER = TYPO3 extension repository
   | *extkey* = extension key
   | *modkey* = backend module key
   

Public extensions
   1. Public extensions are available from the TER.
   
   2. The *extkey* is made up of alphanumeric characters and underscores only
      and should start with a letter.
   
      **Example:** cool\_shop

   3. The *extkey* is valid if the TER accepts it. This makes sure that the
      name follows the rules and is unique.
      
   4. Database tablenames look like 'tx\_' + *extkey* (without underscores) + '\_specification'.
   
      **Examples:** tx\_coolshop\_products, tx\_coolshop\_categories, tx\_coolshop\_more\_categories 

Private extensions
   1. Private extensions are not uploaded to the TER.
   
   2. The *extkey* is made up of alphanumeric characters and underscores only
      and starts with the string 'user\_'.
   
      **Example:** user\_my\_shop

   3. Database tablenames look like *extkey* + '\_specification'.
   
      **Examples:** user\_my\_shop\_products, user\_my\_shop\_categories

Public backend modules
   1. The *modkey* is made up of alphanumeric characters only. It does not
      contain underscores and starts with a letter.
   
      **Example:** coolshop

   2. ((correct?))   
      Database tablenames look like 'tx' (no underscore) + *modkey* + '\_specification'.
   
      **Examples:** txcoolshop\_products, txcoolshop\_categories, txcoolshop\_more\_categories

Private backend modules
   1. The *modkey* is made up of alphanumeric characters only. It does not
      contain underscores and starts with a letter.
  
      **Example:** uMyCoolShop

   2. ((correct?))
      Database tablenames look like 'u' (no underscore) + *modkey* (no underscores) + '\_specification'.
   
      **Examples:** uMyCoolShop\_products, uMyCoolShop\_categories, uMyCoolShop\_more\_categories

Frontend PHP classes
   For frontend PHP classes, follow the same conventions as for
   database tables and field, but prepend class file names with `class`.

You may also want to refer to the TYPO3 Core Coding Guidelines for
more on general naming conventions in TYPO3.

.. tip::
   If you study the naming conventions above closely you will find that
   they are complicated due to varying rules for underscores in key
   names. Sometimes the underscores are stripped off, sometimes not.

   The best practice you can follow is to  *avoid using underscores* in
   your extensions keys at all! That will make the rules simpler. This is
   highly encouraged.

.. _extension-old-extensions :

Note on "old" extensions:
"""""""""""""""""""""""""

Some the "classic" extensions from before the extension structure came
about do not comply with these naming conventions. That is an
exception made for backwards compatibility. The assignment of new keys
from the TYPO3 Extension Repository will make sure that any of these
old names are not accidentially reassigned to new extensions.

Further, some of the classic plugins (tt\_board, tt\_guest etc) users
the "user\_" prefix for their classes as well.

.. _extension-extending:

Extending "extensions classes"
""""""""""""""""""""""""""""""

As a standard procedure you should include the "class extension code"
even in your own extensions. This is placed at the bottom of every
class file::

   if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php'])) {
           include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php']);
   }

Normally the key used as example here ("ext/myext/pi1/class.tx_myext_pi1.php")
would be the full path to the script relative to the PATH\_site
constant. However because modules are required to work from both
:code:`typo3/sysext/`, :code:`typo3/ext/` *and* :code:`typo3conf/ext/` it is a policy that any
path before "ext/" is omitted.

