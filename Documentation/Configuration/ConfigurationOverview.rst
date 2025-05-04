:navigation-title: Overview

..  include:: /Includes.rst.txt
..  _config-overview:

==========================================
Overview of configuration files and syntax
==========================================

This page introduces TYPO3’s configuration files, syntax, and available
:ref:`configuration methods <classification-config-methods>`. For detailed
information, refer to the relevant chapters or references.

TYPO3 is highly configurable—settings can be adjusted through the backend,
extensions, or configuration files, and extended as needed.

..  _config-overview-files:

Configuration overview: files
=============================

..  _config-overview-global:

Global files
------------

:file:`config/system/settings.php`:
    Contains the persisted :ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>` array.
    Settings configured in the backend by system maintainers in
    :guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`
    are written to this file.

:file:`config/system/additional.php`:
    Can be used to **override** settings defined in :file:`config/system/settings.php`

:file:`config/system/services.php` and :file:`config/system/services.yaml`:
    These two files can be used to set up a global service configuration for
    a project that can be used in several project-specific extensions. This
    is explained in detail in the :ref:`Dependency Injection: Installation-wide
    configuration <dependency-injection-installation-wide>` section.

:file:`config/sites/<site>/config.yaml`
    This file is located in :file:`webroot/typo3conf/sites` in non-Composer installations.
    The site configuration configured in the :guilabel:`Site Management > Sites`
    backend module is written to this file.

..  _config-overview-global-extension:

Extension files
---------------

:ref:`composer.json <composer-json>`
    Composer configuration, required in Composer-based installations

:ref:`ext_emconf.php <extension-declaration>`
    Extension declaration, required in legacy installations

:ref:`ext_tables.php <extension-configuration-files>`
    Various configuration. Is used only for backend or CLI requests or when a valid BE user is authenticated.

:ref:`ext_localconf.php <extension-configuration-files>`
    Various configuration. Is always included, whether frontend or backend.

:ref:`ext_conf_template.txt <extension-configuration>`
    Define the "Extension Configuration" settings that can be changed in the backend.

:file:`Configuration/Services.yaml`
    Can be used to configure :ref:`Console commands <symfony-console-commands>`,
    :ref:`Dashboard widgets <ext_dashboard:register-new-widget>`,
    :ref:`Event listeners <EventDispatcher>` and
    :ref:`Dependency injection <DependencyInjection>`.

:file:`Configuration/TCA`
    :ref:`TCA configuration <t3tca:start>`.

:file:`Configuration/TSconfig/`
    :ref:`TSconfig <t3tsref:typoscript-syntax-using-setting>`.

:file:`Configuration/TypoScript/`
    :ref:`TypoScript configuration <t3tsref:start>`.

.. hint::
    The files are explained in more depth in:

    * :ref:`extension-files-locations`

..  _classification-syntax:
..  _configuration-syntax:

Configuration languages
=======================

TYPO3 uses several languages for configuration:

*   :ref:`TypoScript syntax <t3tsref:typoscript-syntax>` is used for frontend
    TypoScript and backend TypoScript (also called TSconfig). TypoScript has
    a unique syntax, shared by TypoScript and TSconfig. While the syntax is the
    same, their semantics differ.
*   :ref:`YAML <yaml-syntax>` is used to store
    `site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_
    and `site configuration <https://docs.typo3.org/permalink/t3coreapi:sitehandling-basics>`_.
    It is also used to configure dependency injection in the
    `Services.yaml <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-services-yaml>`_ file,
    as well as to configure various system and third-party extensions.
*   XML is used in :ref:`FlexForms <flexforms>`.
*   PHP is used for the :php:`$GLOBALS` array which includes TCA
    (:php:`$GLOBALS['TCA']`, Global Configuration (:php:`GLOBALS['TYPO3_CONF_VARS']`),
    User Settings (:php:`$GLOBALS['TYPO3_USER_SETTINGS']`, etc.

..  _classification-config-methods:

Configuration methods
=====================

..  _classification-config-methods-tsconfig:

Backend TypoScript (TSconfig)
-----------------------------

TSconfig configures **backend** behavior in TYPO3, such as enabling views or
customizing editing interfaces—without writing PHP. It can be applied at the
page level (Page TSconfig) or to users and groups (User TSconfig).

TSconfig shares the same syntax as Frontend TypoScript, detailed in
:ref:`t3tsref:typoscript-syntax`, but uses entirely different properties.

For full usage, API details, and load order, refer to:

*   :ref:`Page TSconfig Reference <t3tsref:pagetoplevelobjects>`
*   :ref:`User TSconfig Reference <t3tsref:usertoplevelobjects>`

Primarily used by integrators, TSconfig helps tailor the backend
experience for users.

..  tip::
    TSconfig can also be used to override the table configuration array TCA,
    which is always defined globally, on a per-site or per-page level.

..  _classification-config-methods-typoscript:

Frontend TypoScript
-------------------

TypoScript (or *TypoScript Templating*) controls frontend rendering in TYPO3. It
uses the syntax described in `
TypoScript Explained <https://docs.typo3.org/permalink/t3tsref:start>`_.

While once central to frontend output, much of its role has been replaced by
Fluid. Today, TypoScript is often used to configure plugins, set global options,
or prepare data for Fluid templates.

Still, the :ref:`TypoScript Reference <t3tsref:start>` remains essential for
integrators.

..  seealso::

    For getting started:

    *   :ref:`TypoScript guide <t3tsref:guide>` – Introduction to TypoScript
    *   :ref:`t3sitepackage:start` – Create a site theme using TypoScript and
        Fluid

    The complete reference:

    *   `TypoScript Explained <https://docs.typo3.org/permalink/t3tsref:start>`_

..  _classification-config-methods-globals-variables:

Global configuration arrays in PHP
----------------------------------

TYPO3 stores global configuration in the :php:`$GLOBALS` PHP array. Key entries:

:doc:`$GLOBALS['TCA'] <t3tca:Index>`:
    Defines how backend forms, fields, and data handling behave. It’s essential
    for developers and integrators. Full reference: :ref:`TCA Reference <t3tca:start>`.
    See also: :ref:`extending-tca`.

:ref:`$GLOBALS['TYPO3_CONF_VARS'] <typo3ConfVars>`:
    Stores system-wide settings. Most can be changed in
    :guilabel:`Admin Tools > Settings > Global Configuration`. Values are saved in
    :file:`config/system/settings.php` and can be overridden via
    :file:`config/system/additional.php`.

:ref:`Extension Configuration <extension-options>`:
    A subset of :php:`TYPO3_CONF_VARS`, located in
    :php:`TYPO3_CONF_VARS['EXTENSIONS']`. Used for extension-specific settings.
    Editable in the backend. Use the :ref:`API <extension-options-api>`.

:ref:`feature-toggles`:
    Enable or disable TYPO3 features via
    :php:`TYPO3_CONF_VARS['SYS']['features']`. Toggle in the backend with
    admin rights. Use the :ref:`Feature Toggle API <feature-toggles-api>`.

:ref:`User settings <user-settings>`:
    Stored in :php:`$GLOBALS['TYPO3_USER_SETTINGS']`, they define backend user
    preferences.

.. hint::

   View configurations in the backend under :guilabel:`System > Configuration`
   (read-only) or use a debugger. This requires the `lowlevel` system extension.

Only system maintainers can change :php:`TYPO3_CONF_VARS`, extension settings,
and feature toggles in the backend. TCA and settings for the
:ref:`Logging <logging-configuration>` and :ref:`Caching <caching-configuration>`
frameworks must be edited manually in
:file:`config/system/additional.php`.


..  _classification-config-methods-globals-flexforms:

FlexForm
--------

:ref:`FlexForms <flexforms>` are used to define options for plugins and content
elements. They allow each element to be configured individually.

Values are editable in the backend when editing the content element. The schema
is defined by the providing extension.

..  _config-overview-yaml:

YAML as a configuration method
------------------------------

YAML is used throughout the TYPO3 Core and can also be used in third-party extensions.
It is used, for example, for the following purposes:

*   :ref:`Site configuration <sitehandling>` is stored in
    :file:`config/sites/<identifier>/config.yaml` and can be edited via the
    :guilabel:`Sites` backend module or directly in the file.

    :ref:`Routing <routing>` is also defined in the same YAML file.

*   Defining and storing
    `site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_,
    which can also be managed in the backend module :guilabel:`Sites > Settings`.

*   :ref:`Form configuration <ext_form:concepts-configuration>` for rendering frontend forms.

*   :ref:`RTE CKEditor <ext_rte_ckeditor:configuration>` configuration for the backend rich text editor.

*   :file:`<extension>/Configuration/Services.yaml` for configuring
    :ref:`event listeners <EventDispatcher>` and
    :ref:`dependency injection <DependencyInjection>`.

YAML files can be loaded using the :ref:`YamlFileLoader <yamlFileLoader>`.
