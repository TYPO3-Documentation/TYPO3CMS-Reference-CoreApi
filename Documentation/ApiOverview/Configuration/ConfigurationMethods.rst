.. include:: ../../Includes.txt


.. _configuration-methods:

==========================
Configuration methods list
==========================

These are the main configuration methods used by TYPO3:

The :php:`$GLOBALS` array consists of:

* :ref:`Global Configuration <typo3ConfVars>` :php:`$GLOBALS['TYPO3_CONF_VARS']`
  is used for system wide configuration.
* A subset of this is
  :ref:`Extension Configuration <extension-options>`
  (:php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']`). It is used for
  configuration specific to one extension.
* :ref:`TCA <t3tca:introduction>` :php:`GLOBALS['TCA']` is specific to
  database fields and how they behave and can be edited in the backend.
* :ref:`User settings <user-settings>` :php:`$GLOBALS['TYPO3_USER_SETTINGS']`
  defines configuration for backend users
* ... you can find more in the TYPO3 backend :guilabel:`SYSTEM > Configuration`
  or by viewing the :php:`$GLOBALS` array in a debugger. Read more about this
  on :ref:`globals-variables`.


Furthermore, we have:

* :ref:`TSconfig <tsconfig>` is used to configure and **customize the backend** on a page (page TSconfig)
  and a user or group basis (user TSconfig).
* :ref:`TypoScript configuration method <t3tsref:introduction>` is used to
  configure plugins (FE) and modules (BE), as well as some
  global settings (config). It is also used to define the rendering, but that is
  beyond the scope of this page, which focuses only on configuration. TypoScript
  is mostly used for configuration that affects the Frontend (FE).
* :ref:`Flexform <flexforms>` is used to configure plugins and content elements.
* :ref:`feature-toggles` are used to switch a specific functionality of TYPO3 on or off.


Additionally, some system extensions use YAML for configuration:

* :ref:`Site <sitehandling>` configuration is stored in :file:`<project-root>/config/sites/<identifier>/config.yaml`
  and can be configured in the sites module.
* :ref:`form <form:concepts-configuration>`: Forms in the frontend
* :ref:`rte_ckeditor <ckedit:configuration>`: configure editing rich text editing
* :ref:`Event listeners <EventDispatcher>` in :file:`Configuration/Services.yaml`
* :ref:`Dependency injection <DependencyInjection>` information in :file:`Configuration/Services.yaml`

There is a :ref:`YamlFileLoader <yamlFileLoader>` which can be used to load YAML
files.

.. _next-steps:

Further Documentation
=====================

This manual covers many different APIs of the TYPO3 CMS Core, but some
other documents exist which cover more specific aspects.


:ref:`TCA Reference <t3tca:start>`
----------------------------------

`TCA` is the backbone of database tables displayed in the backend, it configures
how data is stored if editing records in the backend, how fields are displayed,
relations to other tables and much more. It is a huge array loaded in almost all
access contexts.

A detailed insight on `TCA` is documented in the :ref:`TCA Reference <t3tca:start>`.
Next to a small introduction, the document forms a complete reference of all
different `TCA` options, with bells and whistles. The document is a must-read for
Developers, partially for Integrators, and is often used as a reference book on a daily basis.


:ref:`TypoScript Reference <t3tsref:start>`
-------------------------------------------

`TypoScript` - or more precisely `Frontend TypoScript` - is used in TYPO3 to steer
the frontend rendering (the actual website) of a TYPO3 instance. It is based on the
TypoScript syntax which is outlined in detail :ref:`here in this document <typoscript-syntax-start>`.

Frontend TypoScript is very powerful and has been the backbone of frontend rendering ever since.
However, with the rise of the Fluid templating engine, many parts of Frontend TypoScript are much less
often used. Nowadays, TypoScript in real life projects is often not much more than a way to
set a series of options for plugins, to set some global config options, and to act as a simple
pre processor between database data and Fluid templates.

Still, the :ref:`TypoScript Reference <t3tsref:start>` reference document that goes deep into
the incredible power of Frontend TypoScript is daily bread for Integrators.


:ref:`TSconfig Reference <t3tsconfig:start>`
--------------------------------------------

While `Frontend TypoScript` is used to steer the rendering of the frontend, `TSconfig` is used
to configure backend details for backend users. Using `TSconfig` it is possible to enable or
disable certain views, change the editing interfaces, and much more. All that without coding a single
line of PHP. `TSconfig` can be set on a page (Page TSconfig), as well as a user / group (User TSconfig)
basis.

`TSconfig` uses the same syntax as `Frontend TypoScript`, the syntax is outlined in detail
:ref:`here in this document <typoscript-syntax-start>`. Other than that, TSconfig and Frontend TypoScript
don't have much more in common - they consist of entirely different properties.

A full reference of properties as well as an introduction to explain details configuration usage, API and
load orders can be found in the :ref:`TSconfig Reference document <t3tsconfig:start>`. While Developers
should have an eye on this document, it is mostly used as a reference for Integrators who make life as
easy as possible for backend users.
