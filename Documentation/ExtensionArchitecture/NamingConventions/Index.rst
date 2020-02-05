.. include:: ../../Includes.txt


.. _extension-naming:

==================
Naming Conventions
==================

Based on the extension key of an extension these naming conventions
should be followed:

Extension key
=============

* Lowercase "alnum" + underscores.
* Assigned by the TYPO3 Extension Repository.


Example:
   cool\_shop


.. tip::
   If you study the naming conventions above closely you will find that
   they are complicated due to varying rules for underscores in key
   names. Sometimes the underscores are stripped off, sometimes not.

   The best practice you can follow is to  *avoid using underscores* in
   your extensions keys at all! That will make the rules simpler. This is
   highly encouraged.


.. seealso::

  * :ref:`extension-key`

Database tables and fields
==========================

* Prefix with "tx\_[ *key* ]\_" where key is  *without* underscores!

Examples:
   * tx\_coolshop\_products
   * tx\_coolshop\_categories


.. t3-field-list-table::
 :header-rows: 1

 - :Context,20:
   :General,20: General
   :Example,20: Example
   :User-specific,20: User-specific
   :Example-2,20: Example



 - :Context:
         Backend module key (= modkey)

         (Names are always  *without* underscores!)
   :General:
         Name: The extension key name  *without* underscores, prefixed "tx"
   :Example:
         txcoolshop
   :User-specific:
         Name: No underscores, prefixed "u"
   :Example-2:
         uMyShop or umyshop or ...

Plugin key
==========

The plugin key is registered in:

* second parameter in :php:`registerPlugin()` (Extbase)
* or in :php:`addPlugin()` (for non Extbase plugins)

The same plugin key is then used in the following:

* second parameter in :php:`configurePlugin()` (Extbase): MUST match registered plugin key exactly
* the :ref:`plugin signature <naming-conventions-plugin-signature>`
* in TypoScript, e.g. :ts:`plugin.tx_myexample_myplugin`
* in TCA
* etc.

The plugin key can be freely chosen by the extension author, but you SHOULD follow these conventions:

* do not use underscore
* use UpperCamelCase, e.g. InventoryList
* use alphanumeric characters

For the plugin key, `Pi1`, `Pi2` etc. are often used, but it can be named differently.

The plugin key used in :php:`registerPlugin()` and :php:`configurePlugin()` MUST match.



.. _naming-conventions-plugin-signature:

Plugin signature
================

The plugin signature is automatically created by TYPO3 from the extension key and plugin
key.

For this, all underscores in extension key are omitted and all characters lowercased.
The extkey and plugin key are separated by an underscore (`_`):

`extkey_pluginkey`

The plugin signature is used in:

* the database field `tt_content.list_type`
* when defining a :ref:`FlexForm <flexforms>` to be used for the plugin in
  :php:`addPiFlexFormValue()`


Examples:
    Assume the following:

    * extkey is `my_extension`
    * plugin key is `InventoryList`

    The derived name for the "plugin signature" is:

    * `myextension_inventorylist` This is used in tt_content.list_type and as
      first parameter of :php:`addPiFlexFormValue()`.


Class name
==========

Class names SHOULD be in UpperCamelCase.

Examples:
    * :php:`CodeCompletionController`
    * :php:`AjaxController`

.. seealso::

   This follows `PSR-1 <https://www.php-fig.org/psr/psr-1/>`__ conventions.



More information
================

You may also want to refer to the TYPO3 :ref:`Core Coding Guidelines <cgl>` for
more on general naming conventions in TYPO3.


.. _extension-old-extensions :

Note on "old" extensions
========================

Some the "classic" extensions from before the extension structure came
about do not comply with these naming conventions. That is an
exception made for backwards compatibility. The assignment of new keys
from the TYPO3 Extension Repository will make sure that any of these
old names are not accidentially reassigned to new extensions.

Further, some of the classic plugins (tt\_board, tt\_guest etc) users
the "user\_" prefix for their classes as well.

