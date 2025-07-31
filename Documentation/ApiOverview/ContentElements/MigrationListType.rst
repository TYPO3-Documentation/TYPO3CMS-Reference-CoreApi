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
    :linenos:

The `CType` based plugin does not inherit the default fields provided by the
TCA of the content element "List". These where in many cases removed by
using :confval:`subtypes_excludelist <t3tca:types-subtypes-excludelist>`.

As these fields are not displayed automatically anymore you can remove this
definition without replacement: Line 15 in the diff. If they have not been
removed and are still needed, you will need to manually add them to your plugin type.

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
    If your extension also should support TYPO3 version 12.4 or even 11.5 see
    Example: :ref:`plugins-list-type-migration-core-plugin-migration`.

You can extend class :php-short:`TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate`
to provide a custom upgrade wizard that moves existing plugins from the
`list_type` definition to the `CType` definition. The resulting upgrade wizard
will even adjust backend user permissions for the defined plugins:

..  include:: /CodeSnippets/Extbase/Upgrades/ExtbasePluginListTypeToCTypeUpdate.rst.txt

..  _plugins-list-type-migration-extbase-replace:

4. Search your code and replace any mentioning of `list_type`
-------------------------------------------------------------

Search your code. If you used the `list_type` of your plugin in any custom
database statement or referred to the according key within TypoScript,
you will need to do the possible proper replacement.

Search your TCA definitions for any use of the now outdated configuration
options.

Note, that if your old key was something like "example_pi1" you are not
forced to set the CType to "ExamplePi1" with UpperCamelCase,
but you could keep the old identifier. This makes replacements less time consuming.

..  _plugins-list-type-migration-core:

Migration example: Core-based plugin
====================================

..  _plugins-list-type-migration-core-plugin-registration:

1.  Adjust the plugin registration
----------------------------------

..  literalinclude:: _Migration/_non_extbase_tca.diff
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php (diff)

..  _plugins-list-type-migration-core-plugin-typoscript:

2.  Adjust the TypoScript of the plugin
---------------------------------------

If your plugin was rendered using :composer:`typo3/cms-fluid-styled-content` you are
probably using the top level TypoScript object
:ref:`tt_content <t3tsref:tlo-tt_content>` to render the plugin. The path to
the plugin rendering needs to be adjusted as you cannot use the deprecated content
element "list" anymore:

..  literalinclude:: _Migration/_typoscript.diff
    :caption: EXT:my_extension/Configuration/Sets/MyPluginSet/setup.typoscript (diff)

..  _plugins-list-type-migration-core-plugin-migration:

3.  Provide an upgrade wizard for automatic content migration for TYPO3 v13.4 and v12.4
---------------------------------------------------------------------------------------

If your extension only supports TYPO3 v13 and above you can extend the Core class
:php:`\TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate`.

If your extension also supports TYPO3 v12 and maybe even TYPO3 v11 you can use
class :php:`Linawolf\ListTypeMigration\Upgrades\AbstractListTypeToCTypeUpdate`
instead. Require via composer: :composer:`linawolf/list-type-migration` or
copy the file into your extension using your own namespaces:

..  literalinclude:: _Migration/PluginListTypeToCTypeUpdate.php
    :caption: EXT:my_extension/Classes/Upgrades/PluginListTypeToCTypeUpdate.php

If you also have to be compatible with TYPO3 v11, register the upgrade wizard
manually:
:ref:`Registering wizards for TYPO3 v11 <t3coreapi/11:upgrade-wizards-register>`.
