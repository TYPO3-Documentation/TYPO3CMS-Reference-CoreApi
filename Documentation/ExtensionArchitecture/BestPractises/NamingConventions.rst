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
      package name in the file :file:`composer.json <extension-composer-json>` (e.g. `cool_shop` becomes `<vendor>/cool-shop`)
    * underscores in the extension key should be removed by converting the extension key
      to UpperCamelCase in namespaces (e.g. `cool_shop` becomes :php:`MyVendor\CoolShop`)


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
    The extension key as is (e.g. 'my_extension').

extkeyprefix
    The extension key with stripped away underscores (e.g. extkey='my_extension'
    becomes extkeyprefix='myextension').

..  _extension-naming-extensionName:

ExtensionName
    The term ExtensionName means the extension key in UpperCamelCase.

    Example: for an extkey `bootstrap_package` the ExtensionName would be `BootstrapPackage`.

    The ExtensionName is used as first parameter in the Extbase method
    :php:`ExtensionUtility::configurePlugin()` and as value for the
    :php:`extensionName` key when
    :ref:`registering a backend module <backend-modules-configuration>`.

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

* package name in :file:`composer.json <extension-composer-json>` `<vendor-name>/<package-name>`.
  Underscores (`_`) should be replaced by dashes (`-`)
* namespaces: Underscores in the extension key are removed by converting the extension key
  to UpperCamelCase in namespaces (e.g. `cool_shop` becomes `MyVendor\CoolShop`).


.. attention::

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

* namespace: :php:`MyVendor\MyExtension\...`
* package name in :file:`composer.json <extension-composer-json>`: ``vendor-name/my-extension`` (the underscore is replaced by
  a dash)

.. index:: Vendor name

Vendor name
===========

The vendor name is used in:

* namespaces
* package name in :file:`composer.json <extension-composer-json>`, e.g. ``myvendor/cool-shop`` (all lowercase)

.. attention::

   The vendor name MUST be unique (if you publish your extensions
   on packagist).

   Register your vendor name early on `Packagist <https://packagist.org>`__!


Use common PHP naming conventions for vendor names in namespaces and check
`PSR-0 <https://www.php-fig.org/psr/psr-0/>`__. There are currently no strict
rules, but commonly used vendor names begin with a capital letter,
followed by all lowercase.

The vendor name (as well as the *extkey*) is spelled with all lowercase when
used in the package name in the file :file:`composer.json <extension-composer-json>`

For the following examples, we assume:

* the vendor name is `MyCompany`
* the extkey is `my_example`


Examples:
   * Namespace: :php:`MyCompany\MyExample\...`
   * package name (in :file:`composer.json <extension-composer-json>`): `my-company/my-example`

.. seealso::

   * `PSR-0 <https://www.php-fig.org/psr/psr-0/>`__

..  _naming-tables:

Database table name
===================

These rules apply to public extensions, but should be followed nevertheless.

Database table names **should** follow this pattern:

.. code-block:: none

   tx_<extkeyprefix>_<table_name>

* `<extkeyprefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<table_name>` should clearly describe the purpose of the table

Examples for an extension named `cool_shop`:

*  :sql:`tx_coolshop_product`
*  :sql:`tx_coolshop_category`

..  _naming-tables-extbase:

Extbase domain model tables
---------------------------

Extbase domain model tables **should** follow this pattern:

.. code-block:: none

   tx_<extkeyprefix>_domain_model_<model-name>

* `<extkeyprefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<model-name>` should match the domain model name

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
   you may need :ref:`manual mapping <extbase_manual_mapping>`.

..  _naming-tables-mm:

MM-tables for multiple-multiple relations between tables
---------------------------------------------------------

**MM** tables (for multiple-multiple relations between tables) follow these rules.

Extbase:

.. code-block:: none

   # rule for Extbase
   tx_<extkeyprefix>_domain_model_<model-name-1>_<model-name-2>_mm
   # example: EXT:blog with relation between post and comment
   tx_blogexample_domain_model_post_comment_mm

Non-Extbase tables usually use a similar rule, without the "domain_model" part:

.. code-block:: none

   # recommendation for non-Extbase third party extensions
   tx_<extkeyprefix>_<model-1>_<model-2>_mm
   # Example
   tx_myextension_address_category_mm

   # example for TYPO3 core:
   sys_category_record_mm

Database column name
====================

When extending a common table like :sql:`tt_content`, column names SHOULD
follow this pattern:

.. code-block:: none

   tx_<extkeyprefix>_<column-name>

* `<extkeyprefix>` is the extension key without underscores, so `foo_bar` becomes `foobar`
* `<column-name>` should clearly describe the purpose of the column

.. _BackendModuleKey:

Backend module key (modkey)
===========================

The **main module key** SHOULD contain only lowercase characters. Do not use an
underscore or dash.

The **submodule key** MUST be made up of alphanumeric characters only. It MAY
contain underscores and MUST start with a letter.

Example:
   * `Coolshop`

Example usage:

.. code-block:: php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

    return [
        // Submodule key
        'web_productmanagement' => [
            // Main module key (use existing main module 'web' here)
            'parent' => 'web',
            // ...
        ],
    ];

For more details have a look into the :ref:`backend-modules-configuration`
chapter.

Backend module signature
========================

The backend module signature is a derived identifier which is constructed by
TYPO3 when the module is registered.

The signature is usually constructed by using the :ref:`main module key and submodule
key <BackendModuleKey>`, separated by an underscore.
Conversions, such as underscore to UpperCamelCase or conversions to lowercase
may be applied in this process.

Examples (from TYPO3 Core extensions):

*  web_info
*  web_FormFormbuilder
*  site_redirects

..  tip::
    You can look at existing module signatures in
    :guilabel:`System > Configuration > Backend Modules`.

.. _naming-conventions-plugin-signature:

Plugin signature
================

..  versionchanged:: 14.0
    Adding frontend plugins as a "General Plugin", setting the content
    record :sql:`CType` to :sql:`'list'` and `list_type` to the plugin signature
    is not possible anymore. See :ref:`plugins-list_type-migration`.

The plugin signature of non-Extbase plugins, registered via
:php:`ExtensionManagementUtility::addPlugin()` is an arbitrarily defined string.
By convention it should always be the extension name with all underscores removed
followed by one underscore and then a lowercase, alphanumeric plugin key.
Examples: :php:`"myextension_coolplugin"`, :php:`"examples_pi1"`.

Extbase based plugins are registered via :php:`ExtensionUtility::registerPlugin()`.
This method expects the extension key (UpperCamelCase or with underscores) as
the first parameter and a plugin name in UpperCamelCase (for example :php:`"Pi1"` or
:php:`"CoolPlugin"`). The method then returns the new plugin signature.

.. versionadded:: 12.0
   Starting with TYPO3 v12.0 the method :php:`ExtensionUtility::registerPlugin()`
   automatically returns the correct plugin signature.

If you have to write the signature yourself in other contexts (TypoScript for
example) you can build it yourself from the extension name and the plugin name:

For this, all underscores in the extension key are omitted and all characters set to lowercase.
The extension key and plugin key are separated by an underscore (`_`).

Example:

.. code-block:: php
   :caption: Plugin name and Plugin key listed

   $extensionName = 'my_extension';
   $pluginName = 'MyCoolPlugin';
   $pluginSignature = "myextension_mycoolplugin"

The plugin signature is used in:

*   the database field `tt_content.CType`
*   when defining a :ref:`FlexForm <flexforms>` to be used for the plugin in
    :php:`addPiFlexFormValue()`
*   in TypoScript, :typoscript:`plugin.tx_myexample_myplugin` to define settings
    for the plugin etc.
*   As :ref:`record type <t3tca:types>` in TCA. It can therefore be used to
    define which fields should be visible in the TYPO3 backend.

..  _naming-conventions-plugin-signature-non-extbase:

Example register and configure a non-Extbase plugin:
----------------------------------------------------

..  literalinclude:: _snippets/_tt_content_plugin_register.php
    :caption: EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_htmlparser.php

..  code-block:: typoscript
    :caption: EXT:examples/Configuration/setup.typoscript

    plugin.tx_examples_pi1 {
      settings.pageId = 42
    }

..  _naming-conventions-plugin-key:

Plugin key (Extbase only)
=========================

The plugin key is registered in:

*  second parameter in :php:`ExtensionUtility::registerPlugin()`

The same plugin key is then used in the following:

*  second parameter in :php:`ExtensionUtility::configurePlugin()`

The plugin key can be freely chosen by the extension author, but you **should**
follow these conventions:

*  do not use underscore
*  use UpperCamelCase, e.g. InventoryList
*  use alphanumeric characters

For the plugin key, `Pi1`, `Pi2` etc. are often used, but it can be named differently.

The plugin key used in :php:`registerPlugin()` and :php:`configurePlugin()`
**must** match or the later method will fail.

Example register and configure an Extbase plugin:
-------------------------------------------------

..  code-block:: php
    :caption: EXT:examples/Configuration/TCA/Overrides/tt_content_plugin_htmlparser.php

    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    $extensionKey = 'Examples';
    $pluginName = 'HtmlParser';
    $pluginTitle = 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:htmlparser_plugin_title';

    $pluginSignature = ExtensionUtility::registerPlugin(
        $extensionKey,
        $pluginName,
        $pluginTitle
    );

    // $pluginSignature == "examples_htmlparser"

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;Configuration,pi_flexform,',
        $pluginSignature,
        'after:subheader',
    );

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:example/Configuration/FlexForms/Registration.xml',
        $pluginSignature,
    );

..  code-block:: php
    :caption: EXT:examples/ext_localconf.php

    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    ExtensionUtility::configurePlugin(
        'Examples',
        'HtmlParser',
        [
            \T3docs\Examples\Controller\HtmlParserController::class => 'index',
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
    );

..  code-block:: typoscript
    :caption: EXT:examples/Configuration/setup.typoscript

    plugin.tx_examples_htmlparser {
      settings.pageId = 42
    }

Class name
==========

Class names SHOULD be in UpperCamelCase.

Examples:
    * :php:`CodeCompletionController`
    * :php:`AjaxController`

.. seealso::

   This follows `PSR-1 <https://www.php-fig.org/psr/psr-1/>`__ conventions.

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
   * :ref:`Xliff language file id naming conventions <xliff-id-naming>`
