:navigation-title: TypoScript

..  include:: /Includes.rst.txt
..  index:: Backend modules; TypoScript
..  _backend-module-typoscript:

===================================
TypoScript configuration of modules
===================================

The backend module of an extension can be configured via TypoScript.
The configuration is done
in :typoscript:`module.tx_<lowercaseextensionname>_<lowercasepluginname>` or
in :typoscript:`module.tx_<lowercaseextensionname>`.
If the part :typoscript:`_<lowercasepluginname>` is omitted, then the setting is used
for all backend modules of that extension.

Even in the backend the frontend TypoScript setup is used. The settings should
be done globally and not changed on a per-page basis. Register them with
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup()`
in the extension's :file:`ext_localconf.php`:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

    ExtensionManagementUtility::addTypoScriptSetup('
      module.tx_myextension.settings.itemsPerPage = 25
    ');

Do not use :ref:`ext_typoscript_setup.typoscript <ext-typoscript-setup-typoscript>`
for this. It is not loaded on sites that use site sets, so a module showing a
page of such a site does not see it. A module without a page tree only sees
global TypoScript, see :ref:`Breaking: #105728
<changelog:breaking-105728-1732882067>`.

See the :ref:`toplevel object "module" <t3tsref:tlo-module>` in the
TypoScript reference for the available options.
