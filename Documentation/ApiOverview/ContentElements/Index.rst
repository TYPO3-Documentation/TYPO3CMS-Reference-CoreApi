..  include:: /Includes.rst.txt

..  _content-element-and-plugin:

==========================
Content Elements & Plugins
==========================

This chapter handles content elements & plugins: What they are, how they can be
created, how existing content elements or plugins can be customized etc.

..  toctree::
    :titlesonly:
    :caption: Table of Contents

    AddingYourOwnContentElements
    CustomDataProcessing
    CreatePlugins
    CustomBackendPreview
    ContentElementsWizard
    BestPractices
    MigrationListType

..  _cePluginsIntroduction:

Introduction
============

..  contents::
    :local:

In TYPO3, Content elements and plugins are both stored as :ref:`database-records`
in table :sql:`tt_content`. They are usually edited in the backend in module
:guilabel:`Web > Page`.

Content elements and plugins are both used to present and manage
content on a website, but they serve different purposes and have distinct
characteristics:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :card-height: 100

    ..  card:: :ref:`Content elements <content-elements>`

        ..  card-image:: /Images/ManualScreenshots/Backend/content_element_example.png
            :alt: Content element Text & Media

        A content element is a standard unit for managing and displaying content,
        such as text, images, videos, tables, and more.
        TYPO3 provides a variety of built-in content elements. It is possible
        to define custom content elements.

        ..  card-footer:: :ref:`Content elements <content-elements>` :ref:`Custom content elements <adding-your-own-content-elements>`
            :button-style: btn btn-primary

    ..  card:: :ref:`Plugins <plugins>`

        ..  card-image:: /Images/ManualScreenshots/Backend/plugin_example.png
            :alt: Plugin news article detail

        A plugin in TYPO3 is more complex, typically providing dynamic
        or interactive functionality. Plugins are usually provided by extensions
        that introduce new features to the website.

        The data to be displayed is usually supplied by a special PHP class
        called a "controller". Depending on the technology used in the controller
        the plugin can be an Extbase plugin or a plain plugin.

        ..  card-footer:: :ref:`Plugins <plugins>` :ref:`Extbase plugins <plugins-extbase>`
            :button-style: btn btn-secondary

..  _content-elements:

Content elements in TYPO3
-------------------------

A **content element** is a standard unit for managing and displaying content,
such as text, images, videos, tables, and more.

In the TYPO3 backend, content elements are commonly managed in module
:guilabel:`Web > Page`.

From a technical point of view content elements are records stored in the
database table `tt_content`. Each content
element has a specific content element type, specified by the database field
`tt_content.CType`. This type influences both the backend form and the frontend
output.

The appearance of a content element in the backend form is defined via the
:ref:`TYPO3 Configuration Array (TCA) <t3tca:start>` of table `tt_content`.
Each content element type is configured by one entry in the section
:ref:`$TCA['types'] <t3tca:types>`.

The output of the content element in the frontend is configured by an entry in
the :ref:`TypoScript  <t3tsref:start>` top-level object `tt_content` using the
same key as in TCA. In most cases a :ref:`FLUIDTEMPLATE <t3tsref:cobj-template>`
is used delegating the actual output to the templating engine
:ref:`Fluid <fluid>`.

A content element can be of a type
supplied by TYPO3, such as `textmedia` (text with or without images or videos).
Or it can have a custom type supplied by an extension such as `carousel`
provided by the :composer:`bk2k/bootstrap-package` extension.

You can :ref:`add custom content elements <adding-your-own-content-elements>`
to your extension or :ref:`site package <site-package>`.

It is also possible to use an extension such as :composer:`contentblocks/content-blocks`,
:composer:`mask/mask`, or :composer:`t3/dce` to add custom content elements to
your projects.

:ref:`Adding custom content elements <adding-your-own-content-elements>` is
possible without writing PHP code and can therefore also be done by
TYPO3 integrators.

..  _plugins:

Plugins in TYPO3
----------------

A **plugin** in TYPO3 is a more complex implementation, typically providing dynamic
or interactive functionality. Plugins are usually provided by extensions
that introduce new features to the website.

The data to be displayed is usually supplied by a special PHP class
called a "controller". Depending on the technology used in the controller
the plugin can be an Extbase plugin or a plain plugin.

..  _plugins-extbase:

Extbase plugins
~~~~~~~~~~~~~~~

For usage in the TYPO3 backend Extbase plugins are registered with utility
functions of class :php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility` (not to
be confused with :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility`).

An Extbase plugin is configured for the frontend with
:php:`ExtensionUtility::configurePlugin()` in file
:file:`EXT:my_extension/ext_localconf.php`:

..  literalinclude:: _Plugins/_ext_localconf_extbase_plugin.php
    :caption: EXT:my_extension/ext_localconf.php

..  deprecated:: 13.4
    Setting the fifth parameter to any value but `ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT`
    is deprecated. See :ref:`plugins-list_type-migration`.

Method :php:`ExtensionUtility::configurePlugin()` also takes care of registering
the plugin for frontend output in TypoScript using an object of type
:ref:`EXTBASEPLUGIN <t3tsref:cobj-extbaseplugin>`.

If it is desired that editors can insert the Extbase plugin like a content
element into the page it also needs to be registered with
:php:`ExtensionUtility::registerPlugin()` in the TCA Overrides, for example file
:file:`EXT:my_extension/Configuration/TCA/Overrides/tt_content.php`:

..  literalinclude:: _Plugins/_tt_content_extbase_plugin.php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

For a detailed explanation of Extbase plugins including examples for controllers
see chapter :ref:`extbase`.

..  _plugins-non-extbase:

Plugins without Extbase
~~~~~~~~~~~~~~~~~~~~~~~

It is possible to create a plugin without using Extbase by creating a plain PHP
class as a controller.

In this case you have to define the TypoScript configuration yourself. A
:ref:`USER or USER_INT <t3tsref:cobj-user-int>` TypoScript object can be used
to delegate the rendering to your controller:

..  literalinclude:: _Plugins/_plugin.typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

To register such a plugin as content element you can use function
:php:`ExtensionManagementUtility::addPlugin()` in the TCA overrides, for example
:file:`EXT:my_extension/Configuration/TCA/Overrides/tt_content.php`:

..  literalinclude:: _Plugins/_tt_content_plugin.php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

..  versionchanged:: 14.0

    The methods second and third parameter have been dropped. This method can
    only be used with the field `CType` of table `tt_content`.

..  _plugins-characteristics:

Typical characteristics of plugins
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

*   Plugins often use additional database tables which contain records which are
    dynamically displayed via the plugin - often in a list view, a single view,
    optionally with pagination and search functionality. An extension may provide
    several plugins, each with a dedicated function, such as the list view.
*   Plugins are often used if more complex functionality is required (than in non-
    plugin content elements)
*   Plugins can be created using the Extbase framework or by Core functionality.

A typical extension with plugins is the :composer:`georgringer/news` extension
which comes with plugins to display news records in lists or as a single view
with only one news record.

The news records are stored in a custom database table (`tx_news_domain_model_news`)
and can be edited in the backend.

There are also system extensions that have plugins. :composer:`typo3/cms-felogin`
has a plugin that allow frontend users, stored in table `fe_users` to log into
the website. :composer:`typo3/cms-indexed-search` has a plugin that can be
used to search in the index and display search results.


..  _plugins-editing:

Editing
-------

The :ref:`Editors Tutorial <t3editors:start>` describes how to work with
:ref:`page content <t3editors:content-working>` and
lists the :ref:`basic TYPO3 content elements <t3editors:content-types>`
and how to work with them.

Additional descriptions can be found in the
:ref:`fluid_styled_content <typo3/cms-fluid-styled-content:content-elements>` documentation.

..  _cePluginsCustomize:

Customizing
-----------

:ref:`Backend Layouts <be-layout>` can be configured to define how content elements
are arranged in the TYPO3 backend (in rows, columns, grids). This can be used in
the frontend to determine how the content elements are to be arranged (e.g. in
the footer of the page, left column etc.).

Often content elements and plugins contain a number of fields. Not all of these may
be relevant for your site. It is good practice to configure which fields will be
displayed in the backend. There are a number of ways to do this:

*   :ref:`Backend user and group permissions <access-options>` can be used to restrict access to
    content elements, to content on specific pages etc.
*   Fields can be hidden in the backend by using :ref:`TSconfig TCEFORM <t3tsconfig:tceform>`.
*   page TSconfig can be used to :ref:`configure <content-element-wizard>` what is displayed in the "Content Element
    Wizard".

..  _content-element-and-plugin-creation:

Creating custom content element types or plugins
------------------------------------------------

The following chapters handle how to create custom content element types and
plugins:

*   :ref:`adding-your-own-content-elements`
*   :ref:`Registering frontend plugins in
    Extbase <extbase_registration_of_frontend_plugins>`

How to make your plugins or content elements configurable by editors with

*  :ref:`flexforms`
