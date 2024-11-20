.. include:: /Includes.rst.txt
.. index:: pair: Add; Content elements
.. _content-element-wizard:

==========================
New content element wizard
==========================

..  versionchanged:: 13.0
    Custom content element types are auto-registered for the
    :guilabel:`New Content Element` wizard. The listing can be configured using
    TCA.

..  contents:: Table of contents

The content element wizard opens when a new content element is
created. It can be fully configured using ref:`Page TSconfig <t3tsref:pagetsconfig>`.

The wizard looks like this:

..  figure:: /Images/ManualScreenshots/Backend/NewContentElementWizardAnnotated.png

1.  The `title` can be a string or, recommended, a language reference.
2.  The `description` can be a string or, recommended, a language reference.
3.  The `group` can be one of the existing group identifiers or a new one.
4.  The `icon` can be one of the existing registered icon keys or a custom
    icon key registered in the :ref:`icon API <icon>`.

Any of these entries can be omitted. You **should** at
least define a title.

New content elements are usually added in extensions in file
:file:`EXT:my_extension/Configuration/Overrides/tt_content.php`.

The following groups are available by default:

default
    ..  versionchanged:: 13.0 This group was renamed from group `common`.

    Default group for commonly used content elements
forms
    Content elements representing forms like a contact form or a login form
lists

menu
    Menus that can be inserted as content elements like a sitemap or a menu
    of all subpages.
plugins
    Plugins provided by extensions
special
    Content elements that are used of special cases

All content element groups are listed in
:php:`$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['itemGroups']` you can
debug them in the TYPO3 backend using the backend module
:guilabel:`System > Configuration` if :composer:`typo3/cms-lowlevel` is installed
and you are an administrator.

Some third party extensions like :composer:`bk2k/bootstrap-package` are altering
the available groups.

.. _content-element-wizard-plain:

Plain content elements or plugins
=================================

You can add a content element or plain plugin (no Extbase) using method
`ExtensionManagementUtility::addPlugin() <https://api.typo3.org/main/classes/TYPO3-CMS-Core-Utility-ExtensionManagementUtility.html#method_addPlugin>`__:
of class :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility`.

..  literalinclude:: _AddingYourOwnContentElements/_tt_content_plugin.php
    :caption: EXT:my_extension/Configuration/Overrides/tt_content.php

The key `value` in the parameter `$itemArray` is used as key of the newly added
content element representing the plugin.

..  versionchanged:: 14.0

    The method's second and third parameter have been dropped. This method can
    only be used with the field `CType` of table `tt_content`.

This method supplies some default values:

`group`
    Defaults to `plugins`

While it is still possible to use
`ExtensionManagementUtility::addTcaSelectItem() <https://api.typo3.org/main/classes/TYPO3-CMS-Core-Utility-ExtensionManagementUtility.html#method_addTcaSelectItem>`__
as is commonly seen in older extensions this method is not specific to content
elements and therefore sets not default values for group and icon.

.. _content-element-wizard-extbase:

Plugins (Extbase) in the "New Content Element" wizard
=====================================================

To add an Extbase plugin you can use `ExtensionManagementUtility::registerPlugin`
of class :php:`\TYPO3\CMS\Extbase\Utility\ExtensionManagementUtility`.

This method is only available for Extbase plugins defined via
`ExtensionUtility::configurePlugin` in file :file:`EXT:my_extension/ext_localconf.php`

..  literalinclude:: _AddingYourOwnContentElements/_tt_content_register_plugin.php
    :caption: EXT:my_extension/Configuration/Overrides/tt_content.php

.. _content-element-wizard-page-tsconfig:

Override the wizard with page TSconfig
======================================

The TCA is always set globally for the complete TYPO3 installation. If you have
a multi-site installation and want to alter the appearance of content elements
in the wizard or remove certain content elements this can be done via
:ref:` page TSconfig <t3tsref:setting-page-tsconfig>`.
This is commonly done on a per site basis so you can use the :ref:`Site set page TSconfig provider <site-sets-page-tsconfig>`
in your :ref:`site package <site-package>`.

You can use the settings of :ref:`newContentElement.wizardItems <t3tsref:pagenewcontentelementwizard>`.


.. _content-element-wizard-page-tsconfig-remove:

Remove items from the "New Content Element" wizard
--------------------------------------------------

Using :confval:`[group].removeItems <t3tsref:mod-wizards-newcontentelement-wizarditems-group-removeitems>`
you can remove a content element type from the wizard.

..  literalinclude:: _AddingYourOwnContentElements/_page_remove_item.tsconfig
    :caption: EXT:my_sitepackage/Configuration/Sets/MySet/page.tsconfig

This removes the content element "Plain HTML" from the group `special`.

..  note::
    The affected content elements are only removed from the specified group and
    only in the wizard. Editors can still switch the `CType` selector to create
    such a content element. The content element might also appear in another tab.

    Use :ref:`User settings configuration <user-settings>` to effectively ban
    usage for non-admin users.

You can also remove whole groups of content elements from the wizard:

..  literalinclude:: _AddingYourOwnContentElements/_page_remove_group.tsconfig
    :caption: EXT:my_sitepackage/Configuration/Sets/MySet/page.tsconfig

.. _content-element-wizard-page-tsconfig-change:

Change title, description, icon and default values in the wizard
----------------------------------------------------------------

You can use the following page tsconfig properties to change the display
of the element in the wizard:

*   :confval:`iconIdentifier <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-iconidentifier>`
*   :confval:`iconOverlay <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-iconoverlay>`
*   :confval:`title <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-title>`
*   :confval:`description <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-description>`
*   :confval:`tt_content_defValues <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-tt-content-defvalues>`
*   :confval:`saveAndClose <t3tsref:mod-wizards-newcontentelement-wizarditems-group-elements-name-saveandclose>`

..  literalinclude:: _AddingYourOwnContentElements/_page_change_item.tsconfig
    :caption: EXT:my_sitepackage/Configuration/Sets/MySet/page.tsconfig

.. _content-element-wizard-create-group:

Register a new group in the "New Content Element" wizard
========================================================

New groups are added on the fly, however it is recommended to set a localized
header:

..  literalinclude:: _AddingYourOwnContentElements/_tt_content_register_group.php
    :caption: EXT:my_extension/Configuration/Overrides/tt_content.php

The headers can also be overridden on a per site basis using page TSconfig.

..  literalinclude:: _AddingYourOwnContentElements/_page_change_group_header.tsconfig
    :caption: EXT:my_sitepackage/Configuration/Sets/MySet/page.tsconfig

.. _content-element-wizard-v12:

Content elements compatible with TYPO3 v12.4 and v13
====================================================

If your extension supplies content elements or plugins and supports both TYPO3
v12.4 and v13 you can keep the :ref:`Page TsConfig for the New Content Element
Wizard <t3coreapi/v12:content-element-wizard>` while you additionally supply
the TCA settings for TYPO3 v13.

You should use the same content element group for both definition ways or
the content element will be displayed twice, once in each group. Group `common`
is automatically migrated to `default` for TYPO3 v13.
