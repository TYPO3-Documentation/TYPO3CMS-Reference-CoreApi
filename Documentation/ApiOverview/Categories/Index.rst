.. include:: /Includes.rst.txt

.. _categories:

=================
System categories
=================

TYPO3 CMS provides a generic categorization system.
Categories can be created in the backend like any other type of record.

A TCA field of the column type :ref:`category<t3tca:columns-category>`

Pages, content elements and files contain category fields by default.

.. versionchanged:: 11.4
   Starting with v11.4 the formerly used php function
   :php:`ExtensionManagementUtility::makeCategorizable()` is deprecated.
   Use a TCA field of the type :ref:`category<t3tca:columns-category>` instead.


.. _categories-using:

Using Categories
================


.. _categories-managing:

Managing Categories
-------------------

System categories are defined just like any other record. Each category
can have a parent, making for a tree-like structure.

.. include:: /Images/AutomaticScreenshots/Categories/Editing.rst.txt

The "items" tab shows all related records, for example all records that have
been marked as belonging to this category.

.. _categories-activating:

Adding categories to a table
----------------------------

Categories can be added to a table by defining a TCA field of the TCA column
type :ref:`category<t3tca:columns-category>`. While using this type, TYPO3
takes care of generating the necessary TCA configuration and also adds
the database column automatically. Developers only have to configure the
TCA column and add it to the desired record types:

.. include:: /CodeSnippets/Manual/Categoy/CategorySimple.rst.txt

This is the result of the above code:

.. include:: /Images/AutomaticScreenshots/Categories/AddingWithApi.rst.txt


.. _categories-flexforms:

Using categories in FlexForms
=============================

It is possible to create relations to categories also in
:ref:`Flexforms <t3tca:columns-flex>`.

Due to some limitations in FlexForm, the property
:ref:`relationship<t3tca:columns-category-properties-relationship>`
`manyToMany` is not supported. Therefore, the default value for this property
is `oneToMany`.

.. include:: /CodeSnippets/Manual/Categoy/CategoryFlexform.rst.txt

.. _categories-api:

System categories API
=====================

.. _categories-collections:

Category Collections
====================

The :php:`\TYPO3\CMS\Core\Category\Collection\CategoryCollection`
class provides the API for retrieving records related
to a given category. Since TYPO3 CMS 6.2, it is extended by class
:php:`\TYPO3\CMS\Frontend\Category\Collection\CategoryCollection`
which does the same job but in the frontend, i.e.
respecting all enable fields and performing version
and language overlays.

The main method is :code:`load()` which will return a
traversable list of items related to the given category.
Here is an example usage, taken from the RECORDS content object:

.. code-block:: php

   $collection = \TYPO3\CMS\Frontend\Category\Collection\CategoryCollection::load(
      $aCategory,
      TRUE,
      $table,
      $relationField
   );
   if ($collection->count() > 0) {
      // Add items to the collection of records for the current table
      foreach ($collection as $item) {
         $tableRecords[$item['uid']] = $item;
         // Keep track of all categories a given item belongs to
         if (!isset($categoriesPerRecord[$item['uid']])) {
            $categoriesPerRecord[$item['uid']] = array();
         }
         $categoriesPerRecord[$item['uid']][] = $aCategory;
      }
   }

As all collection classes in the TYPO3 CMS Core implement the
Iterator interface, it is also possible to use expected methods like
:code:`next()`, :code:`rewind()`, etc. Note that methods such as
:code:`add()` will only add items to the collection temporarily.
The relations are not persisted in the database.


.. _categories-typoscript:

Usage with TypoScript
=====================

In the frontend, it is possible to get collections of
categorized records loaded into a RECORDS content object
for rendering. Check out the
:ref:`categories property <t3tsref:cobj-records-properties-categories>`.

The HMENU object also has a :ref:`"categories" special type <t3tsref:hmenu-special-categories>`,
to display a menu based on categorized pages.

User permissions for system categories
======================================

In most aspects system categories are treated like any other record. They can
be viewed or edited by editors if they are stored in a folder where the editor
has access to and if the table :sql:`sys_category` is allowed in the field
:guilabel:`Tables (listing)` and :guilabel:`Tables (modify)` in the tab
:guilabel:`Access Lists` of the user group.

Additionally it is possible to set :guilabel:`Mounts and Workspaces >
Category Mounts` in the user group. If at least one category is set in the
category mounts only the chosen categories are allowed to be attached to records.
