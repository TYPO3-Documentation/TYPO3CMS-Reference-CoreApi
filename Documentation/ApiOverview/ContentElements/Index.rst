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

..  _cePluginsIntroduction:

Introduction
============

..  contents::
    :local:

In TYPO3, content elements and plugins are both used to present and manage
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
to your extension or :ref:`site package <t3sitepackage:start>`.

It is also possible to use an extension such as :composer:`contentblocks/content-blocks`,
:composer:`mask/mask`, or :composer:`t3/dce` to add custom content elements to
your projects.

:ref:`Adding custom content elements <adding-your-own-content-elements>` is
possible without writing PHP code and can therefore also be done by
TYPO3 integrators.



..  _plugins:
..  _plugins-extbase:
..  todo: Introduce Extbase plugins

What are plugins?
-----------------

**Plugins** are a specific type of content elements. Plugins use the CType='list'.
Each plugin has its own plugin type, which is used in the database field
tt_content.list_type. The list_type could be understood as subtype of CType.

Typical characteristics of
plugins are:

*   Plugins often use additional database tables which contain records which are
    dynamically displayed via the plugin - often in a list view, a single view,
    optionally with pagination and search functionality. An extension may provide
    several plugins, each with a dedicated function, such as the list view.
*   Plugins are often used if more complex functionality is required (than in non-
    plugin content elements)
*   Plugins can be created using the Extbase framework or by Core functionality.
*   ``tt_content.CType`` = ``list`` and ``tt_content.list_type`` contains the
    :ref:`plugin signature <naming-conventions-plugin-signature>`.

A typical extension with plugins is the 'news' extension which comes with plugins
to display news records in lists or as a single view with only one news record.
The news records are stored in a custom database table (tx_news_domain_model_news)
and can be edited in the backend.


..  _plugins-examples:

Examples
--------

..  code-block:: none

    CType='textmedia'
    list_type=''

Content element type "Text & Media" shipped with the TYPO3 core

..  code-block:: none

    CType='list'
    list_type='indexedsearch_pi2'

Indexed search plugin type, provided by the TYPO3 core.

..  _plugins-editing:

Editing
-------

The :ref:`Editors Tutorial <t3editors:start>` describes how to work with
:ref:`page content <t3editors:content-working>` and
lists the :ref:`basic TYPO3 content elements <t3editors:content-types>`
and how to work with them.

Additional descriptions can be found the
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
