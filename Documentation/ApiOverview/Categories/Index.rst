.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _categories:

System categories
-----------------

Since version 6.0, TYPO3 CMS provides a generic categorization system.
Categories can be created in the backend like any other type of record.
Any table can be made categorizable and thus be attached to system
categories.


.. _categories-using:

Using categories
^^^^^^^^^^^^^^^^


.. _categories-managing:

Managing categories
"""""""""""""""""""

System categories are defined just like any other record. Each category
can have a parent, making for a tree-like structure.


.. figure:: ../../Images/Categories/Editing.png
   :alt: Editing a category

   A category with a parent defined

The "items" tab shows all related records, i.e. all records that have been marked
as belonging to this category.


.. _categories-activating:

Making a table categorizable
""""""""""""""""""""""""""""

There are two way to activate categories on a given table. The first one is to
use the global setting :code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['defaultCategorizedTables']`.
It is a comma-separated list of tables for which categories should be activated.
The default value is :code:`pages,tt_content,sys_file_metadata`.

.. important::

   It is recommended to avoid changing this setting. You should rather use the
   API described just below so as to avoid overriding a default which may
   change in future versions of TYPO3 CMS. The API is also more powerful.

The second way is to call :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable()`.
This method adds a new entry into the registry managed by
:ref:`\\TYPO3\\CMS\\Core\\Category\\CategoryRegistry <t3cmsapi:TYPO3\\CMS\\Core\\Category\\CategoryRegistry>`.
The registry will take care of adding the relevant :ref:`$TCA <t3tca:start>` definition to
create a field for making relations to the system categories.
The call to :code:`makeCategorizable()` must be located in an extension's
:file:`ext_tables.php` file.

The default :code:`$TCA` structure provided by the registry
can be overridden by an array options passed to :code:`makeCategorizable()`.
The example below illustrates how this is done:

.. code-block:: php

	// Add an extra categories selection field to the pages table
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
		'examples',
		'pages',
		// Do not use the default field name ("categories"), which is already used
		// Also do not use a field name containing "categories" (see http://forum.typo3.org/index.php/t/199595/)
		'tx_examples_cats',
		array(
			// Set a custom label
			'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:additional_categories',
			// Override generic configuration, e.g. sort by title rather than by sorting
			'fieldConfiguration' => array(
				'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC',
			)
		)
	);

The above code will add a categories field to the "pages" table,
which will be called :code:`tx_examples_cats`. The :code:`fieldConfiguration`
part of the options array is the one which overrides the base
:code:`$TCA` structure. In this case we would like categories to be
listed alphabetically instead of using the "sorting" field.

If no :code:`label` part is set in the options array, the field will
be labelled "Categories".

This is the result of the above code:


.. figure:: ../../Images/Categories/AddingWithApi.png
   :alt: The new categories-relation field

   The newly added field to define relations to categories (on top of the default one)

.. warning::

   In TYPO3 CMS 6.1, it is not possible to add more than one categories field
   to a given table. Although this is a bug, fixing it implied so many changes
   that the correction was applied only in the next version (hence version 6.2).


.. _categories-flexforms:

Using categories in flexforms
"""""""""""""""""""""""""""""

It is possible to create relations to categories also in
:ref:`Flexforms <t3tca:columns-flex>`, although this has
to be done manually since no API exists for this.

The code will look something like:

.. code-block:: xml

	<settings.categoriesList>
		<TCEforms>
		<exclude>1</exclude>
		<label>Categories:</label>
		<config>
			<type>select</type>
			<autoSizeMax>50</autoSizeMax>
			<foreign_table>sys_category</foreign_table>
			<foreign_table_where> AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.sorting ASC</foreign_table_where>
			<MM>sys_category_record_mm</MM>
			<MM_opposite_field>items</MM_opposite_field>
			<MM_match_fields>
				<tablenames>tt_content</tablenames>
			</MM_match_fields>
			<maxitems>9999</maxitems>
			<renderMode>tree</renderMode>
			<size>10</size>
			<treeConfig>
				<appearance>
					<expandAll>1</expandAll>
					<showHeader>1</showHeader>
				</appearance>
				<parentField>parent</parentField>
			</treeConfig>
		</config>
		</TCEforms>
	</settings.categoriesList>

Property :code:`tablenames` would need to be adjusted.


.. _categories-api:

System categories API
^^^^^^^^^^^^^^^^^^^^^

Beyond :code:`makeCategorizable()`, class
:ref:`\\TYPO3\\CMS\\Core\\Category\\CategoryRegistry <t3cmsapi:TYPO3\\CMS\\Core\\Category\\CategoryRegistry>`
has many other methods related to the management of
categorized table. The best way to discover is to follow
the link above and explore the methods provided by this class.
They are all quite specialized and should not be needed
most of the time.


.. _categories-collections:

Category collections
^^^^^^^^^^^^^^^^^^^^

The :ref:`\\TYPO3\\CMS\\Core\\Category\\Collection\\CategoryCollection <t3cmsapi:TYPO3\\CMS\\Core\\Category\\Collection\\CategoryCollection>`
classe provides the API for retrieving records related
to a given category.

.. warning::

   Be careful if you want to use this API in the frontend, as
   it does not take care of enabel fields.

The main method is :code:`load()` which will return a
traversable list of items related to the given category.
Here is some sample code:

.. code-block:: php

	$categoryUid = 1;
	$tableName = 'tt_content';
	$collection = \TYPO3\CMS\Core\Category\Collection\CategoryCollection::load(
		$categoryUid,
		# Populates the entries directly on load, might be bad for memory on large collections
		TRUE,
		$tableName
	);

	// Tell how many tt_content element are categorized for category.uid = 1.
	echo $collection->count();

	// Return all tt_content items categorized by category.uid = 1
	$items = $collection->getItems();

	// Set the cursor at the beginning
	$collection->rewind();

	// Return the first item of the collection
	$item = $collection->current();

	// Move the cursor to the next one
	$item = $collection->next();


Note that methods such as :code:`add()` will only add items to the collection temporarily.
The relations are not persisted in the database.
