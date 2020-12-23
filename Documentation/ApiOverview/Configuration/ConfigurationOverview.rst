.. include:: /Includes.rst.txt

.. _config-overview:

======================
Configuration overview
======================

This page will give you an overview of various configuration files, syntax
languages and :ref:`configuration methods <classification-config-methods>`
in `TYPO3`:pn:. For more extensive information we will refer you to the
respective chapter or reference.

A primary feature of TYPO3 is its configurability. Not only can
it be configured by users with special user privileges in the backend.
Most configuration can also be changed by extensions or
configuration files. Additionally, configuration can be extended by
extensions.


Configuration overview: files
=============================


Global files
------------

:file:`<webroot>/typo3conf/LocalConfiguration.php`:
   Contains the persisted :ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>` array.
   Settings configured in the backend by system maintainers in
   :guilabel:`ADMIN TOOLS > Settings > Configure Installation-Wide Options`
   are written to this file.

:file:`<webroot>/typo3conf/AdditionalConfiguration.php`:
   Can be used to **override** settings defined in :file:`LocalConfiguration.php`

:file:`config/sites/<site>/config.yaml`
   This file is located in :file:`webroot/typo3conf/sites` in non-`Composer`:pn: installations.
   The Site configuration configured in the :guilabel:`SITE MANAGEMENT > Sites`
   backend module is written to this file.

Extension files
---------------

:ref:`composer.json <composer-json>`
   `Composer`:pn: configuration

:ref:`ext_emconf.php <extension-declaration>`
   (required) Extension declaration

:ref:`ext_tables.php <extension-configuration-files>`
   Various configuration. Is used only for backend or CLI requests or when a
   valid backend user is authenticated.

:ref:`ext_localconf.php <extension-configuration-files>`
   Various configuration. Is always included, whether frontend or backend.

:ref:`ext_conf_template.txt <extension-configuration>`
   Define the "Extension Configuration" settings that can be changed in the backend.

:file:`Configuration/Services.yaml`
   Can be used to configure :ref:`Console commands <symfony-console-commands>`,
   :ref:`Dashboard widgets <t3dashboard:register-new-widget>`,
   :ref:`Event listeners <EventDispatcher>` and
   :ref:`Dependency injection <DependencyInjection>`.

:file:`Configuration/TCA`
   :ref:`TCA configuration <t3tca:start>`.

:file:`Configuration/TSconfig/`
   :ref:`TSconfig configuration <t3tsconfig:start>`.

:file:`Configuration/TypoScript/`
   :ref:`TypoScript configuration <t3tsref:start>`.


.. hint::
   The files are explained in more depth in:

   * :ref:`extension-files-locations`

Configuration languages
=======================

These are the main languages TYPO3 uses for configuration:

* :ref:`TypoScript syntax <typoscript-syntax-start>` is used for `TypoScript`:pn:
  and `TSconfig`:pn:.
* :ref:`TypoScript constant syntax <t3tsref:typoscript-syntax-constant-editor>` is
  used for Extension Configuration and for defining constants for `TypoScript`:pn:.
* :ref:`Yaml <yaml-syntax>` is the configuration language of choice for newer
  TYPO3 system extensions like :ref:`rte_ckeditor <ckedit:start>`,
  :ref:`form <form:start>` and the :ref:`sites module <sitehandling>`. It has
  partly replaced `TypoScript`:pn: and `TSconfig`:pn: as configuration languages.
* XML is used in :ref:`Flexforms <flexforms>`.
* PHP is used for the :php:`$GLOBALS` array which includes `TCA`:pn:
  (:php:`$GLOBALS['TCA']`, Global Configuration (:php:`GLOBALS['TYPO3_CONF_VARS']`),
  User Settings (:php:`$GLOBALS['TYPO3_USER_SETTINGS']`, etc.

What is most important here, is that `TypoScript`:pn: has its own syntax. And the
`TypoScript`:pn: syntax is used for the configuration methods **TypoScript and `TSconfig`:pn:**.
The syntax for both is the same, while the semantics (what variables can be used and
what they mean) are not.

.. tip::

   Hence, the term **TypoScript** is used to both define the pure syntax `TypoScript`:pn:
   and the configuration method `TypoScript`:pn:. These are different things. To avoid
   confusion, we will use the terms:

   #. "TypoScript syntax" or "TypoScript language"
   #. "TypoScript configuration method" or "TypoScript Templating"

Configuration methods
=====================

:ref:`TSconfig <t3tsconfig:start>`
----------------------------------

While frontend `TypoScript`:pn: is used to steer the rendering of the frontend, `TSconfig`:pn: is used
to configure **backend** details for backend users. Using `TSconfig`:pn: it is possible to enable or
disable certain views, change the editing interfaces, and much more. All that without coding a single
line of PHP. `TSconfig`:pn: can be set on a page (page `TSconfig`:pn:), as well as a user / group (user `TSconfig`:pn:)
basis.

`TSconfig`:pn: uses the same syntax as frontend `TypoScript`:pn:, the syntax is outlined in detail
in :ref:`typoscript-syntax-start`. Other than that, `TSconfig`:pn: and frontend `TypoScript`:pn:
don't have much more in common - they consist of entirely different properties.

A full reference of properties as well as an introduction to explain details configuration usage, API and
load orders can be found in the :ref:`TSconfig Reference document <t3tsconfig:start>`. While Developers
should have an eye on this document, it is mostly used as a reference for Integrators who make life as
easy as possible for backend users.



:ref:`TypoScript Templating <t3tsref:start>`
--------------------------------------------

`TypoScript`:pn: - or more precisely "TypoScript Templating" - is used in TYPO3 to steer
the frontend rendering (the actual website) of a TYPO3 instance. It is based on the
`TypoScript`:pn: syntax which is outlined in detail in :ref:`typoscript-syntax-start`.

`TypoScript`:pn: templating is very powerful and has been the backbone of frontend rendering ever since.
However, with the rise of the `Fluid`:pn: templating engine, many parts of  frontend `TypoScript`:pn: are much less
often used. Nowadays, `TypoScript`:pn: in real life projects is often not much more than a way to
set a series of options for plugins, to set some global config options, and to act as a simple
pre processor between database data and `Fluid`:pn: templates.

Still, the :ref:`TypoScript Reference <t3tsref:start>` manual that goes deep into
the incredible power of `TypoScript`:pn: Templating is daily bread for Integrators.


For an introduction, you may want to read one of the following tutorials:


* :ref:`t3ts45:start` - Introduction to `TypoScript`:pn: templating.
* :ref:`t3sitepackage:start` - Start a Sitepackage Extension to create a theme
  for your site using `TypoScript`:pn: and `Fluid`:pn:.

.. note::

   There is some overlap between templating and configuration. `TypoScript`:pn: is
   used mostly for templating, but is still used quite heavily to define
   configuration options for extensions.


:ref:`PHP $GLOBALS <globals-variables>`
---------------------------------------

.. code-block:: none

   $GLOBALS
   ├── $GLOBALS['TCA'] = "TCA"
   ├── GLOBALS['TYPO3_CONF_VARS'] = "Global configuration"
   │   ├── GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'] = "Extension configuration"
   │   └── GLOBALS['TYPO3_CONF_VARS']['SYS']['features'] = "Feature Toggles"
   └── $GLOBALS['TYPO3_USER_SETTINGS'] = "User settings"
   └── ...

The :php:`$GLOBALS` PHP array consists of:

:ref:`$GLOBALS['TCA'] <t3tca:start>`:
   `TCA`:pn: is the backbone of database tables displayed in the backend, it configures
   how data is stored if editing records in the backend, how fields are displayed,
   relations to other tables and much more. It is a huge array loaded in almost all
   access contexts. `TCA`:pn: is documented in the :ref:`TCA Reference <t3tca:start>`.
   Next to a small introduction, the document forms a complete reference of all
   different `TCA`:pn: options, with bells and whistles. The document is a must-read for
   Developers, partially for Integrators, and is often used as a reference book
   on a daily basis. See :ref:`extending-tca` about how to extend the `TCA`:pn: in
   extensions.

:ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>`:
   is used for system wide configuration. Most of the settings can be
   modified in the backend :guilabel:`ADMIN TOOLS > Settings > Global Configuration`
   and will be persisted to the file file:`typo3conf/LocalConfiguration.php`.
   The settings can be overridden by using :file:`typo3conf/AdditionalConfiguration.php`.

:ref:`Extension Configuration <extension-options>`:
   is a subset of :php:`$GLOBALS['TYPO3_CONF_VARS']`.
   It is stored in :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']`.
   It is used for configuration specific to one extension and can
   be modified in the backend :guilabel:`ADMIN TOOLS > Settings > Extension
   Configuration`. Do not set the values directly, use the
   :ref:`API <extension-options-api>`.

:ref:`feature-toggles`:
   are used to switch a specific functionality of
   TYPO3 on or off. The values are written to
   :php:`GLOBALS['TYPO3_CONF_VARS']['SYS']['features']`.
   The feature toggles can be switched on or off in the backend
   :guilabel:`ADMIN TOOLS > Settings > Feature Toggles` with **Admin**
   privileges. The :ref:`API <feature-toggles-api>` should be used
   to register and read feature toggles.

:ref:`User settings <user-settings>`:
   :php:`$GLOBALS['TYPO3_USER_SETTINGS']` defines configuration for backend users

This is not a complete list of the entire :php:`$GLOBALS` array.

.. hint::

   You can find more and view the configuration in the TYPO3 backend
   :guilabel:`SYSTEM > Configuration` (read only) or by viewing the
   :php:`$GLOBALS` array in a debugger. The backend module is available with
   activated `lowlevel` system extension.

:php:`$GLOBALS['TYPO3_CONF_VARS']`, Extension configuration and feature toggles
can be changed in the backend in :guilabel:`ADMIN TOOLS > Settings` by
system maintainers. `TCA`:pn: cannot be modified in the backend.

Configuration of the :ref:`Logging Framework <logging-configuration>` and
:ref:`Caching Framework <caching-configuration>` - while being a part of the
:php:`$GLOBALS['TYPO3_CONF_VARS']` array - can also not be changed in the
backend. They must be modified in the file :file:`typo3conf/AdditionalConfiguration.php`.


:ref:`Flexform <flexforms>`
---------------------------

`FlexForms`:pn: are used to define some options in plugins and content elements.
With `FlexForms`:pn:, every content element can be configured differently.

`Flexform`:pn: values can be changed while editing content elements in the backend.

A schema defining the values that can be changed in the `Flexform`:pn: is
specified in the extension which supplies the plugin or content element.


YAML
----

Some system extensions use YAML for configuration:

* :ref:`Site <sitehandling>` configuration is stored in :file:`<project-root>/config/sites/<identifier>/config.yaml`.
  It can be configured in the backend module "Site" or changed directly in
  the configuration file.

* :ref:`routing` is also defined in the file :file:`<project-root>/config/sites/<identifier>/config.yaml`.

* :ref:`form <form:concepts-configuration>`: The Form engine is a system
  extension which supplies Forms to use in the frontend

* :ref:`rte_ckeditor <ckedit:configuration>`: RTE ckeditor is a system
  extension. It is used to enable rich text editing in the backend.

* A file :file:`<extension>/Configuration/Services.yaml` can be used to configure
  :ref:`Event listeners <EventDispatcher>` and :ref:`Dependency injection <DependencyInjection>`

There is a :ref:`YamlFileLoader <yamlFileLoader>` which can be used to load YAML
files.







