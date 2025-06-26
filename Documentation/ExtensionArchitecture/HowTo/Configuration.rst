:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  index:: Extension; Configuration
..  _extension-configuration:

====================================
Configuration methods for extensions
====================================

There are several possibilities to make your extension configurable. From the
various options described here each differs in:

*   the scope to what the configuration applies (extension, pages,
    plugin)
*   the access level required to make the change (editor, admin)

.. index::
   TypoScript
   Configuration; TypoScript

TypoScript and constants
========================

You can define configuration options using TypoScript.
These options can be changed via TypoScript constants and setup in the backend.
The changes apply to the current page and all subpages.

.. seealso::

   * :ref:`Extbase TypoScript configuration <extbase_typoscript_configuration>`

   * :ref:`t3tsref:typoscript-syntax-what-are-constants`


.. index::
   Configuration; Extension configuration
   Files; ext_conf_template.txt

Extension configuration
=======================

Extension configuration is defined in the file :file:`ext_conf_template.txt`
using TypoScript constant syntax.

The configuration options you define in this file can be changed in the
backend :guilabel:`Admin Tools > Settings > Extension Configuration` and is stored in :file:`config/system/settings.php`.

Use this file for general options that should be globally applied to the extension.

.. seealso::

   * :ref:`extension-options`


.. index:: FlexForms

FlexForms
=========

FlexForms can be configured in the backend by editors. With FlexForms you can
configure each plugin or content element individually without adding extra fields to the :sql:`tt_content` table.

In Extbase plugins, settings made in the FlexForm of a plugin
override settings made in the TypoScript configuration of that plugin.

..  note::

    If you wish to access a setting set via FlexForm in Extbase from your controller via
    :php:`$this->settings`, the name of the setting must begin with **settings**,
    directly followed by a dot (`.`).

..  seealso::

    *   :ref:`flexforms`


Example
-------

..  include:: /CodeSnippets/Extbase/Configuration/PluginSettings.rst.txt


Access settings
===============

The settings can be read using :php:`$this->settings` in an
Extbase controller action and via :html:`{settings}` within Fluid.

Example: Access settings in an Extbase controller
--------------------------------------------------

.. include:: /CodeSnippets/Extbase/Controllers/Settings.rst.txt

YAML
====

Some extensions offer configuration in the format YAML,
see :ref:`config-overview-yaml`.

There is a :ref:`YamlFileLoader <yamlFileLoader>` which can be used to load YAML
files.
