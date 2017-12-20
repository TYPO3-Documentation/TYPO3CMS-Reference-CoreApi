.. include:: ../../../Includes.txt

.. _fal-using-fal-tca:

TCA definition
^^^^^^^^^^^^^^

This chapter explains how to create a field that makes it possible to
create relations to files.

TYPO3 CMS provides a convenient API for this.
Let's look at the TCA configuration the "image" field of the "tt\_content"
table for example (with some parts skipped).

.. code-block:: php

	'image' => array(
		'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.images',
		'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', array(
			'appearance' => array(
				'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
			),
			// custom configuration for displaying fields in the overlay/reference table
			// to use the imageoverlayPalette instead of the basicoverlayPalette
			'foreign_types' => array(
				...
			)
		), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
	),


The API call is :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig()`.
The first argument is the name of the current field, the second argument is an override
configuration array, the third argument is the list of allowed file extensions and the
fourth argument is the list of disallowed file extensions. All arguments but the first
are optional.

A call to :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig()`
will generate a standard TCA configuration for an :ref:`inline-type field <t3tca:columns-inline>`,
with relation to the "sys\_file" table via the "sys\_file\_reference"
table as "MM" table.

The override configuration array (the second argument) can be used to tweak
this default TCA definition. Any valid property from the "config" section
of inline-type fields can be used.

.. note::

   Such FAL-enabled fields can also be used inside FlexForms, but there's no API
   to generate the code in such a case.


On the database side, the corresponding field needs just store an integer,
as is usual for relations field:

.. code-block:: sql

	CREATE TABLE tt_content (
		...
		image int(11) unsigned DEFAULT '0' NOT NULL,
		...
	);

