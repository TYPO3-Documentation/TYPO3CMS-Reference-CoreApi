:navigation-title: Plugin Settingss

..  include:: /Includes.rst.txt
..  _plugin-settings:

========================================
Plugin options: Settings at plugin level
========================================

The plugins of many extensions come with settings inside the content
element representing the plugin. These are commonly labeled "Plugin options"

Depending on their permissions, editors may be able to edit the settings of
a plugin.

In general, plugin-specific settings are evaluated in the following order:

#.  `Site settings <https://docs.typo3.org/permalink/t3coreapi:config-overview-backend-site>`_
#.  `TypoScript <https://docs.typo3.org/permalink/t3coreapi:extbase-typoscript-configuration-plugin>`_
#.  Settings made inside the plugin's content element

The settings of a plugin are commonly found in a tab called "Plugin" and
a section called "Plugin Options". Extension authors are, however, free to
chose different labels.

..  figure:: /Images/ManualScreenshots/Backend/PluginOptions.png
    :alt: Plugin Options of the Frontend login plugin

    Example: Plugin options of the Frontend login plugin

Extension authors can use `FlexForms <https://docs.typo3.org/permalink/t3coreapi:flexforms>`_
or `TCA <https://docs.typo3.org/permalink/t3tca:start>`_ to configure
plugin options that can be set in the content element of the plugin.
