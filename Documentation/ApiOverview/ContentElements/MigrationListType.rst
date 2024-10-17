..  include:: /Includes.rst.txt
..  _plugins-list-type:
..  _plugins-list-type-migration:

=========================================
Migration: `list_type` plugins to `CType`
=========================================

..  deprecated:: 13.4
    The plugin content element (:php:`list`) and the plugin sub types
    field (:php:`list_type`) have been marked as deprecated in TYPO3 v13.4 and
    will be removed in TYPO3 v14.0.

Several steps are important in the migration from `list_type` plugins to `CType`
plugins:

*   Register plugins using the `CType` record type
*   Create update wizard which extends :php:`\TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate`
    and add :php:`list_type` to :php:`CType` mapping for each plugin to migrate.
*   Migrate possible FlexForm registration and add dedicated :php:`showitem` TCA
    configuration
*   Migrate possible `PreviewRenderer` registration in TCA
*   Adapt possible content element wizard items in page TSconfig, where
    :php:`list_type` is used
*   Adapt possible content element restrictions in backend layouts or container
    elements defined by third-party extensions like :t3ext:`content_defender`

..  contents:: Table of content

..  _plugins-list-type-migration-extbase:

Migration example: Extbase plugin
=================================

..  _plugins-list-type-migration-extbase-configuration:

1. Adjust the Extbase plugin configuration
------------------------------------------

Extbase plugins are usually registered using the utility method
:php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()` in file
:file:`EXT:my_extension/ext_localconf.php`.

Add value `ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT` as fifth parameter,
`$pluginType`, to the method :php:`ExtensionUtility::configurePlugin()`:

..  literalinclude:: _Migration/_ext_localconf.php.diff
    :caption: EXT:examples/ext_localconf.php (difference)

If the fourth parameter, `$nonCacheableControllerActions` was missing you can
set it to an empty array, the default value.

It is theoretically possible that the extension author did not use this utility
method. In that case you have to change the TypoScript used to display your
plugin manually. This step is similar to adjusting the TypoScript of a
Core-based plugin.

..  _plugins-list-type-migration-extbase-flexform:

2. Adjust the registration of FlexForms and additional fields
-------------------------------------------------------------

..  literalinclude:: _Migration/_tca_registration.php.diff
    :caption: EXT:examples/Configuration/TCA/Overrides/tt_content.php (difference)

The `CType` based plugin does not inherit the standard fields provided by the
TCA of the content-element "List". These where in many cases removed by
using :confval:`subtypes_excludelist <t3tca:types-subtypes-excludelist>`.

As these fields are not displayed automatically anymore you can remove this
definition without replacement: Line 15 in the diff. If they have not been
removed and still needed you need to add them manually to your plugins type.

The :confval:`subtypes_addlist <t3tca:types-subtypes-addlist>` was used to
display the field containing the FlexForm, an possibly other fields in the
`list_type` plugin. We remove this definition (Line 17) and replace it
by using the utility method
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes()`
(Line 25-30).

The utility method :php:`ExtensionManagementUtility::addPiFlexFormValue()`
needs to be changed from using the first parameter for the `$pluginSignature`
to using the third parameter. The first parameter requires a certain `list_type`
setting it to the wildcard `*` allows all list types. The third parameter limits
it to the `CType`.

..  _plugins-list-type-migration-extbase-upgrade-wizard:

3. Provide an upgrade wizard
----------------------------

..  versionadded:: 13.4

You can extend class :php-short:`TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate`
to provide a custom upgrade wizard that moves existing plugins from the
`list_type` definition to the `CType` definition. The resulting upgrade wizard
will even adjust backend user permissions for the defined plugins:

..  include:: /CodeSnippets/Extbase/Upgrades/ExtbasePluginListTypeToCTypeUpdate.rst.txt

..  _plugins-list-type-migration-extbase-replace:

4. Search your code and replace any mentioning of `list_type`
-------------------------------------------------------------

Search your code. If you used the `list_type` of you plugin in any custom
database statement or referred to the according

Search your TCA definitions for any use of the now outdated configuration
options

..  _plugins-list-type-migration-core:

Migration example: Core-based plugin
====================================

..  _plugins-list-type-migration-core-registration:

1.  Adjust the plugin registration
==================================
