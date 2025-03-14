.. include:: /Includes.rst.txt
.. index:: Extbase; TypoScript configuration
.. _extbase-typoscript-configuration:

========================
TypoScript configuration
========================

Each Extbase extension has some settings which can be modified using TypoScript.
Many of these settings affect aspects of the internal configuration of Extbase
and Fluid. There is also a block :typoscript:`settings` in which you can
set extension specific settings that can be accessed in the controllers and
Fluid templates of your extension.

TypoScript for all frontend plugins can be set in the typoscript block
:typoscript:`plugin.tx_[lowercasedextensionname]`, for example
:typoscript:`plugin.tx_blogexample`.

TypoScript for a specific frontend plugin can be set in the typoscript block
:typoscript:`plugin.tx_[lowercasedextensionname]_[pluginname]`, for example
:typoscript:`plugin.tx_blogexample_postsingle`. Settings made here override
settings from :typoscript:`plugin.tx_blogexample`.

TypoScript for all :ref:`backend modules <backend-module-typoscript>` can be set
in :typoscript:`module.tx_[lowercasedextensionname]`, for example
:typoscript:`module.tx_blogexample`, for a specific backend module in
:typoscript:`module.tx_<lowercaseextensionname>_<lowercasepluginname>`.

For details of the available configuration values see
:ref:`plugin in the TypoScript Reference <t3tsref:plugin>`.

.. _extbase-typoscript-configuration-plugin:

Plugin configuration
====================

..  literalinclude::  _TypoScriptConfiguration/_pluginconf.typoscript
    :language: typoscript
    :caption: EXT:blog_example/Configuration/TypoScript/setup.typoscript

In the controller use `$this->settings['postsPerPage']` to access the TypoScript
setting.
