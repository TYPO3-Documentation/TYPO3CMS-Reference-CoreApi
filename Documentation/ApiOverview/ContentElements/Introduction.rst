.. include:: /Includes.rst.txt


.. _cePluginsIntroduction:

============
Introduction
============

.. term clarification:
.. 1. "content elements" is used as general term, including plugins
.. 2. use "content element types" when talking about the type

What are content elements?
==========================

**Content elements** (often abbreviated as CE) are the building blocks
that make up a page in TYPO3.

Content elements are stored in the database table ``tt_content``. Each content
element has a specific content element type, specified by the database field
``tt_content.CType``. A content element can be of a type
supplied by TYPO3, such as 'textmedia' (text with or without images or videos).
Or it can have a custom type supplied
by an extension such as 'carousel' provided by the bootstrap_package extension.

Content elements are one of the elements (along with pages) that can be filled
with content by editors and will be rendered in the frontend when a page is
generated.

Content elements are arranged on a page, depending on their

* language (field: ``tt_content.sys_language_uid``)
* sorting (field: ``tt_content.sorting``)
* column (field: ``tt_content.colPos``)
* etc.

.. note::

   Sometimes, the term "content element" is used to mean a content element type
   which is not a plugin. On this page and in this chapter, "content element"
   means any content element type including plugins.

What are plugins?
=================

**Plugins** are a specific type of content elements. Plugins use the CType='list'.
Each plugin has its own plugin type, which is used in the database field
tt_content.list_type. The list_type could be understood as subtype of CType.

Typical characteristics of
plugins are:

* Plugins often use additional database tables which contain records which are
  dynamically displayed via the plugin - often in a list view, a single view,
  optionally with pagination and search functionality. An extension may provide
  several plugins, each with a dedicated function, such as the list view.
* Plugins are often used if more complex functionality is required (than in non-
  plugin content elements)
* Plugins can be created using the Extbase framework or by Core functionality.
* ``tt_content.CType`` = ``list`` and ``tt_content.list_type`` contains the
  :ref:`plugin signature <naming-conventions-plugin-signature>`.

A typical extension with plugins is the 'news' extension which comes with plugins
to display news records in lists or as a single view with only one news record.
The news records are stored in a custom database table (tx_news_domain_model_news)
and can be edited in the backend.

Examples
========

.. code-block:: none

   CType='textmedia'
   list_type=''

Content element type "Text & Media" shipped with the TYPO3 core

.. code-block:: none

   CType='list'
   list_type='indexedsearch_pi2'

Indexed search plugin type, provided by the TYPO3 core.

Editing
=======

The :ref:`Editors Tutorial <t3editors:start>` describes how to work with
:ref:`page content <t3editors:content-working>` and
lists the :ref:`basic TYPO3 content elements <t3editors:content-types>`
and how to work with them.

Additional descriptions can be found the
:ref:`fluid_styled_content <ext_fsc:content-elements>` documentation.

.. _cePluginsCustomize:

Customizing
===========

:ref:`Backend Layouts <be-layout>` can be configured to define how content elements
are arranged in the TYPO3 backend (in rows, columns, grids). This can be used in
the frontend to determine how the content elements are to be arranged (e.g. in
the footer of the page, left column etc.).

Often content elements and plugins contain a number of fields. Not all of these may
be relevant for your site. It is good practice to configure which fields will be
displayed in the backend. There are a number of ways to do this:

* :ref:`Backend user and group permissions <access-options>` can be used to restrict access to
  content elements, to content on specific pages etc.
* Fields can be hidden in the backend by using :ref:`TSconfig TCEFORM <t3tsconfig:tceform>`.
* page TSconfig can be used to :ref:`configure <content-element-wizard>` what is displayed in the "Content Element
  Wizard".

Creating custom content element types or plugins
================================================

The following chapters handle how to create custom content element types and
plugins:

*   :ref:`adding-your-own-content-elements`
*   :ref:`Registering frontend plugins in
    Extbase <extbase_registration_of_frontend_plugins>`

How to make your plugins or content elements configurable by editors with

*  :ref:`flexforms`

