.. include:: /Includes.rst.txt
.. index:: Extension development; Naming conventions
.. _extension-naming:

==================
Naming conventions
==================

The first thing you should decide on is the :ref:`extension key <extension-key>`
for your extension and the vendor name. A significant part of the names below
are based on the extension key.

.. tip::

    Some of the names, such as extension key or vendor name, will be spelled differently,
    depending on where they are used, for example:

    * underscores (`_`) in the extension key should be replaced by dashes (`-`), when used in the
      package name in the file :file:`composer.json` (e.g. `cool_shop` becomes `<vendor>/cool-shop`)
    * underscores in the extension key should be removed by converting the extension key
      to UpperCamelCase in namespaces (e.g. `cool_shop` becomes :php:`VendorName\CoolShop`)


Abbreviations & Glossary
========================

UpperCamelCase
    `UpperCamelCase <https://en.wikipedia.org/wiki/Camel_case>`__ begins
    with a capital letter and begins all following subparts of a word with a
    capital letter. The rest of each word is in lowercase with no spaces,
    e.g. `CoolShop`.

lowerCamelCase
    `lowerCamelCase <https://en.wikipedia.org/wiki/Camel_case>`__ is
    the same as UpperCamelCase, but begins with a lowercase letter.

TER
    The `"TYPO3 Extension Repository" <https://extensions.typo3.org/>`__:
    A catalogue of extensions where you can find information about
    extensions and where you can search and filter by TYPO3 version
    etc. Once registered on https://my.typo3.org, you can login and register
    an extension key for your extension in https://extensions.typo3.org
    :guilabel:`My Extensions`.

extkey
    The extension key.

ExtensionName
    The term ExtensionName means the extension key in UpperCamelCase.

    Example: for an extkey `bootstrap_package` the ExtensionName would be `BootstrapPackage`.

    The ExtensionName is used as first parameter in the Extbase methods
    :php:`ExtensionUtility::configurePlugin()` or :php:`ExtensionUtility::registerModule()`.

modkey
    The backend module key.

Public extensions
   Public extensions are publicly available. They are usually registered in TER
   and available via Packagist_.

Private extensions
   These are not published to the TER or Packagist.




Some of these "Conventions" are actually mandatory, meaning you **will** most likely
run into problems if you do not adhere to them.

We **very strongly recommend** to always use these naming conventions. Hard requirements
are emphasized by using the words MUST, etc. as specified in
`RFC 2119 <https://www.ietf.org/rfc/rfc2119.txt>`__. SHOULD or MAY indicate
a soft requirement: strongly recommended but will usually work, even if you
do not follow the conventions.


.. tip::
   If you study the naming conventions closely you will find that
   they are complicated due to varying rules derived from the extkey,
   if the extkey contains underscores. Sometimes the underscores are
   stripped off, sometimes not, sometimes a name in UpperCamelCase is created.

   The best practice you can follow is to  *avoid using underscores* in
   your extensions keys altogether. That will make the rules simpler and is
   highly recommended.



.. index:: Extension key
.. _naming-conventions-extkey:

Extension key (extkey)
======================

The extension key (extkey) is used **as is** in:

* directory name of extension in :file:`typo3conf/ext`
  (or :file:`typo3/sysext` for system extensions)

Derived names are:

* package name in :file:`composer.json` `<vendor-name>/<package-name>`.
  Underscores (`_`) should be replaced by dashes (`-`)
* namespaces: Underscores in the extension key are removed by converting the extension key
  to UpperCamelCase in namespaces (e.g. `cool_shop` becomes `VendorName\CoolShop`).


.. important::

   If you plan to :ref:`publish your extension <publish-extension>`,
   the extension key must be unique worldwide. This will be checked
   and enforced once you register the extension key on extensions.typo3.org.

   The *extkey* is valid if the TER accepts it. This also makes sure that the
   name follows the rules and is unique.

   Do this early! An already reserved key can usually only be transferred if the
   original author agrees to this.



#. The *extkey* MUST be unique within your installation.

#. The *extkey* MUST be made up of lowercase alphanumeric characters
   and underscores only and MUST start with a letter.

#. More, see :ref:`extension key <extension-key>`

Examples for *extkeys*:
   * `cool_shop`
   * `blog`

Examples for names that are derived from the extkey:

Here, the *extkey* is `my_extension`:

* namespace: :php:`VendorName\MyExtension\...`
* package name in :file:`composer.json`: ``vendor-name/my-extension`` (the underscore is replaced by
  a dash)

.. index:: Vendor name

Vendor name
===========

The vendor name is used in:

* namespaces
* package name in :file:`composer.json`, e.g. ``myvendor/cool-shop`` (all lowercase)

.. important::

   The vendor name MUST be unique (if you publish your extensions
   on packagist).

   Register your vendor name early on `Packagist <https://packagist.org>`__!


Use common PHP naming conventions for vendor names in namespaces and check
`PSR-0 <https://www.php-fig.org/psr/psr-0/>`__. There are currently no strict
rules, but commonly used vendor names begin with a capital letter,
followed by all lowercase.

The vendor name (as well as the *extkey*) is spelled with all lowercase when
used in the package name in the file :file:`composer.json`

For the following examples, we assume:

* the vendor name is `MyCompany`
* the extkey is `my_example`


Examples:
   * Namespace: :php:`MyCompany\MyExample\...`
   * package name (in :file:`composer.json`): `my-company/my-example`

.. seealso::

   * `PSR-0 <https://www.php-fig.org/psr/psr-0/>`__


Database table name
===================

These rules apply to public extensions, but should be followed nevertheless.

Database table names SHOULD follow this pattern::

   tx_<extension-prefix>_<table-name>

* `<extension-prefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<table-name>` should clearly describe the purpose of the table

Examples for an extension named `cool_shop`:

    * :sql:`tx_coolshop_product`
    * :sql:`tx_coolshop_category`

Extbase domain model tables SHOULD follow this pattern::

   tx_<extension-prefix>_domain_model_<table-name>

* `<extension-prefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<table-name>` should match the domain model name

Examples for Extbase domain models and table names of an extension named `cool_shop`:

+-----------------------------------------------------+-------------------------------------------------+
| Domain model                                        | Table name                                      |
+=====================================================+=================================================+
| :php:`Vendor\BlogExample\Domain\Model\Post`         | :sql:`tx_blogexample_domain_model_post`         |
| :php:`Vendor\CoolShop\Domain\Model\Tag`             | :sql:`tx_coolshop_domain_model_tag`             |
| :php:`Vendor\CoolShop\Domain\Model\ProcessedOrder`  | :sql:`tx_coolshop_domain_model_processedorder`  |
| :php:`Vendor\CoolShop\Domain\Model\Billing\Address` | :sql:`tx_coolshop_domain_model_billing_address` |
+-----------------------------------------------------+-------------------------------------------------+

.. tip::

   You may notice, that the names above use the singular form, e.g. `post` and
   not `posts`. This is recommended, but not always followed. If you do not follow this pattern,
   you may need :ref:`manual mapping <t3extbasebook:using-foreign-data-sources>`.

Database column name
====================

When extending a common table like :sql:`tt_content`, column names SHOULD follow this pattern::

   tx_<extension-prefix>_<column-name>

* `<extension-prefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<column-name>` should clearly describe the purpose of the column

Backend module key
==================

The **main module key** SHOULD contain only lowercase characters. Do not use an
underscore or dash.

The **submodule key** MUST be made up of alphanumeric characters only. It MAY
contain underscores and MUST start with a letter.

Example:
   * `Coolshop`

Example usage::

    // Module System > Backend Users
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        // ExtensionName
        'CoolShop',
        // Main module key (use existing main module 'web' here)
        'web',
        // Submodule key
        'ProductManagement'
        // ...
    );

.. tip::

   Registered modules are added to :php:`$GLOBALS['TBE_MODULES']`. TYPO3 may derive
   the full module signature from the extkey and modkey. Conversions, such as underscore to
   UpperCamelCase may be applied in this process.

   You can look at existing module signatures in :guilabel:`System > Configuration`.




Plugin key
==========

The plugin key is registered in:

* second parameter in :php:`registerPlugin()` (Extbase)
* or in :php:`addPlugin()` (for non Extbase plugins)

The same plugin key is then used in the following:

* second parameter in :php:`configurePlugin()` (Extbase): MUST match registered plugin key exactly
* the :ref:`plugin signature <naming-conventions-plugin-signature>`
* in TypoScript, e.g. :typoscript:`plugin.tx_myexample_myplugin`
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


Extbase
=======

Extbase has some of its own conventions.

.. seealso::

    * :ref:`Extbase CGL <t3extbasebook:extbase-cgl>`.

Upgrade wizard identifier
=========================

You SHOULD use the following naming convention for the identifier:

`extKey_wizardName`

This is not enforced.

Please see :ref:`upgrade-wizards-identifier` in the Upgrade Wizard chapter
for further explanations.


.. _extension-old-extensions:

Note on "old" extensions
========================

Some the "classic" extensions from before the extension structure came
about do not comply with these naming conventions. That is an
exception made for backwards compatibility. The assignment of new keys
from the TYPO3 Extension Repository will make sure that any of these
old names are not accidentally reassigned to new extensions.

Furthermore, some of the classic plugins (tt\_board, tt\_guest etc) use
the "user\_" prefix for their classes as well.


.. _TER: https://extensions.typo3.org/
.. _Packagist: https://packagist.org/

Further reading
===============

.. seealso::

   * :ref:`extension key <extension-key>`
   * :ref:`publish-extension`
   * :ref:`cgl`
   * :ref:`Extbase CGL <t3extbasebook:extbase-cgl>`
   * :ref:`Xliff language file id naming conventions <xliff-id-naming>`
