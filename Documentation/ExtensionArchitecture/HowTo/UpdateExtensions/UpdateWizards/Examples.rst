:navigation-title: Examples

..  include:: /Includes.rst.txt
..  _upgrade-wizard-examples:

===================================
Examples for common upgrade wizards
===================================

..  _upgrade-wizard-examples-switchable-controller-actions:

Upgrade wizard to replace switchable controller actions
=======================================================

Switchable controller actions in Extbase plugins have been deprecated with
TYPO3 v10.3 (see also :ref:`Deprecation: #89463 - Switchable Controller
Actions <changelog:deprecation-89463>`) and removed with TYPO3 v12.4.

On migration of existing installations using plugins with switchable controller
actions all plugins have to be changed to a new type. It is recommended to
also change them from being defined via field `list-type` to field `CType`.

See also :ref:`Registration of frontend plugins <t3coreapi:extbase_registration_of_frontend_plugins>`.

The following upgrade wizard can be run on any installation which still has
plugins of the outdated type and configuration. It is then not needed anymore
to upgrade the plugins manually:

..  literalinclude:: _SwitchableControllerActionUpgradeWizard.php
    :caption: EXT:my_extension/Classes/Upgrades/SwitchableControllerActionUpgradeWizard.php

You find real world examples of such upgrade wizards for example in
:composer:`georgringer/news`:
`\\GeorgRinger\\News\\Updates\\PluginUpdater <https://github.com/georgringer/news/blob/main/Classes/Updates/PluginUpdater.php>`__.
