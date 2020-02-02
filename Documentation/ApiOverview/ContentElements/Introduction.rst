.. include:: ../../Includes.txt


.. _cePluginsIntroduction:

============
Introduction
============

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


What are plugins?
=================

**Plugins** are a specific type of content elements. Typical characteristics of
plugins are:

* Used if more complex functionality is required
* Plugins can be created using the Extbase framework or as pibase (AbstractPlugin)
  plugin.
* ``tt_content.CType`` = ``list`` and ``tt_content.list_type`` contains the
  :ref:`plugin signature <naming-conventions-plugin-signature>`.

A typical extension with plugins is the 'news' extension which comes with plugins
to display news records in lists or as a single view. The news records are stored
in a custom database table and can be edited in the backend (in the list module).

Editing
=======

How to work with content elements and plugins?

The "Getting Started Tutorial" describes how to work with :ref:`page content <t3start:page-content>`
The "Tutorial for Editors" describes the :ref:`basic TYPO3 content elements <t3editors:content-types>`
and how to work with them. Additional descriptions can be found the
:ref:`fluid_styled_content <fsc:content-elements>` documentation.

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
* Page TSconfig can be used to :ref:`configure <content-element-wizard>` what is displayed in the "Content Element
  Wizard".

Creating new content elements
=============================

The following chapters handle how to create your own content element types and plugins.
Specifically, check out:

* :ref:`adding-your-own-content-elements`
* :ref:`t3extbasebook:configuring-the-plugin` in the "Extbase / Fluid book"
* How to make your plugins or content elements configurable by editors with
  :ref:`flexforms`
