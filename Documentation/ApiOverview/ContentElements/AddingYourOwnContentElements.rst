.. include:: /Includes.rst.txt

.. _adding-your-own-content-elements:

==============================
Create Custom Content Elements
==============================

This page explains how to create your own custom content element types, in
addition to the content elements already supplied by TYPO3. You can find
more code examples in the system extension `fluid_styled_content`.

A content element can be based on fields already available in the `tt_content` table.

It is also possible to add extra fields that can be added to the `tt_content` table.
Adding fields is done by :ref:`extending the TCA <extending>`.

Depending on the data in the `tt_content` table,
the data can be passed to the :ref:`cobj-fluidtemplate`.
Some data might need additional processing by
:ref:`data processor <t3tsref:cobj-fluidtemplate-properties-dataprocessing>` e.g. to resolve file relations.
The content elements in the extension *fluid_styled_content* are using both methods.
A data processor can be used to convert a string to an array,
like done for the *table* content element with the field `bodytext`,
or to fetch a related record, e.g. a FAL file.
In these cases Fluid does not have to deal with these manipulations or transformation.


Prerequisites
=============

Some of the following steps (specifically the ones using ``lib.contentElement``) require the system
extension :ref:`fluid_styled_content <fsc:start>`. If you do not use **fluid_styled_content**, you
must create and initialize the ``lib.contentElement`` TypoScript object yourself.

.. _AddingCE-use-an-extension:

Use an Extension
================

We recommend to create your own extension for adding content elements.
The following example uses the extension key `your_extension_key`.

If you have plans to publish your extension, follow :ref:`extension-key-registration`.

.. _AddingCE-PageTSconfig:
.. _RegisterCE:
.. _AddingCE-TCA-Overrides-tt_content:

1. Register the Content Element
===============================

First add the new content element to :guilabel:`New Content Element Wizard` and define its `CType` in PageTSconfig.

The example content element is called `yourextensionkey_newcontentelement`:

.. tip::
   This is handled in more detail in :ref:`content-element-wizard`.

.. code-block:: typoscript

   mod.wizards.newContentElement.wizardItems.common {
       elements {
           yourextensionkey_newcontentelement {
               iconIdentifier = your-icon-identifier
               title = LLL:EXT:your_extension_key/Resources/Private/Language/Tca.xlf:yourextensionkey_newcontentelement.wizard.title
               description = LLL:EXT:your_extension_key/Resources/Private/Language/Tca.xlf:yourextensionkey_newcontentelement.wizard.description
               tt_content_defValues {
                   CType = yourextensionkey_newcontentelement
               }
           }
       }
       show := addToList(yourextensionkey_newcontentelement)
   }

You need to :ref:`register the icon identifier <icon-registration>` with the icon API in your :file:`ext_localconf.php`.

In order to allow to select the type of content element,
it has to be added to the :guilabel:`Type` dropdown.
This is done in the file :file:`Configuration/TCA/Overrides/tt_content.php`.

.. code-block:: php

   // Adds the content element to the "Type" dropdown
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
      'tt_content',
      'CType',
       [
           'LLL:EXT:your_extension_key/Resources/Private/Language/Tca.xlf:yourextensionkey_newcontentelement',
           'yourextensionkey_newcontentelement',
           'your-icon-identifier',
       ],
       'textmedia',
       'after'
   );

.. _ConfigureCE-Fields:

2. Configure Fields
===================

Then you need to configure the backend fields for your new content element in the file :file:`Configuration/TCA/Overrides/tt_content.php`:

.. code-block:: php

   // Configure the default backend fields for the content element
   $GLOBALS['TCA']['tt_content']['types']['yourextensionkey_newcontentelement'] = [
       'showitem' => '
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
               --palette--;;general,
               --palette--;;headers,
               bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
           --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
               --palette--;;frames,
               --palette--;;appearanceLinks,
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
               --palette--;;language,
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
               --palette--;;hidden,
               --palette--;;access,
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
               categories,
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
               rowDescription,
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
       ',
       'columnsOverrides' => [
           'bodytext' => [
               'config' => [
                   'enableRichtext' => true,
                   'richtextConfiguration' => 'default',
               ],
           ],
       ],
   ];

.. _ConfigureCE-Frontend:

3. Configure the Frontend Template
==================================

TypoScript configuration is needed as well.
Therefore add an entry in the static template list found in `sys_templates`.
This should be done within :file:`Configuration/TCA/Overrides/sys_template.php`:

.. code-block:: php

   // Add an entry in the static template list found in sys_templates for static TS
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
       'your_extension_key',
       'Configuration/TypoScript',
       'Your description'
   );

This API call will register the file :file:`Configuration/TypoScript/setup.typoscript` to be loaded as static TypoScript.
The definitions inside this file will be effective when the file is loaded.

As Fluid templates, partials and layouts will be shipped in the custom extension,
paths for them need to be added to the file.
Therefore adjust the properties:

* :ref:`t3tsref:cobj-fluidtemplate-properties-templaterootpaths`,
* :ref:`t3tsref:cobj-fluidtemplate-properties-partialrootpaths`
* :ref:`t3tsref:cobj-fluidtemplate-properties-layoutrootpaths`

.. code-block:: typoscript

   lib.contentElement {
       templateRootPaths.200 = EXT:your_extension_key/Resources/Private/Templates/
       partialRootPaths.200 = EXT:your_extension_key/Resources/Private/Partials/
       layoutRootPaths.200 = EXT:your_extension_key/Resources/Private/Layout/

   }

.. note::

   The :``lib.contentElement`` path is defined in
   :file:`EXT:fluid_styled_content/Configuration/TypoScript/Helper/ContentElement.typoscript`.

You can use any index (`200` in this example), just make sure it is unique.
The paths only need to be added if they exist and are used.

Now you can register the rendering of your custom content element using a :ref:`t3tsref:cobj-fluidtemplate`:

.. code-block:: typoscript

   tt_content {
       yourextensionkey_newcontentelement =< lib.contentElement
       yourextensionkey_newcontentelement {
           templateName = NewContentElement
       }
   }

In this example a :ref:`cobj-fluidtemplate` content object is created using a reference from :typoscript:`lib.contentElement`.
The template is identified by the :ref:`t3tsref:cobj-fluidtemplate-properties-templatename` property as `NewContentElement`.

This will load a :file:`NewContentElement.html` template file from the :typoscript:`templateRootPaths`.

For the final rendering you need a Fluid template.

This template will be located at the directory and file name entered in :file:`setup.typoscript` using
the parameter :typoscript:`templateName`.

`tt_content` fields can now be used in the Fluid template by accessing them via the `data` variable.
The following example shows the text entered in the richtext enabled field `bodytext`, using the html
saved by the richtext editor:

.. code-block:: html

   <div>{data.bodytext -> f:format.html()}</div>


.. image:: Images/NewContentElementOutput.png
   :class: with-border with-shadow
   :alt: The example output


.. _AddingCE-Extended-Example:

Extended example: Extend tt_content and use data processing
===========================================================

You can find the complete example in the  TYPO3 Documentation Team extension
`examples <https://extensions.typo3.org/extension/examples/>`__. The steps for
creating a simple new content element as above need to be repeated. We use the
key *examples_newcontentcsv* in this example.

We want to output comma separated values (CSV) stored in the field bodytext.
As different programs use different separators to store CSV we want to make
the separator configurable.


.. index::
   pair: Content element; Extending tt_content
   Extension development; Extending tt_content
.. _ConfigureCE-Extend-tt_content:

4. Optional: Extend tt_content
==============================

.. todo::

The new field *tx_examples_separator* is added to the TCA definition of the table *tt_content* in the file
:file:`Configuration/TCA/Overrides/tt_content.php`::

   $temporaryColumn = [
      'tx_examples_separator' => [
         'exclude' => 0,
         'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tt_content.tx_examples_separator',
         'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
               ['Standard CSV data formats', '--div--'],
               ['Comma separated', ','],
               ['Semicolon separated', ';'],
               ['Special formats', '--div--'],
               ['Pipe separated (TYPO3 tables)', '|'],
               ['Tab separated', "\t"],
            ],
            'default' => ','
         ],
      ],
   ];
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $temporaryColumn);

You can read more about defining fields via TCA in the :ref:`t3tca:start`.

Now the new field can be used in your Fluid template just like any other
tt_content field.

Another example shows the connection to a foreign table. This allows you to be more flexible with the possible values in the select box. The new field *tx_examples_main_category* is a connection to the TYPO3 system category table *sys_category*.

   'tx_examples_main_category' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tt_content.tx_examples_main_category',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['None', '0'],
            ],
            'foreign_table' => 'sys_category',
            'foreign_table_where' => 'AND {#sys_category}.{#pid} = ###PAGE_TSCONFIG_ID### AND {#sys_category}.{#hidden} = 0 ' .
                'AND {#sys_category}.{#deleted} = 0 AND {#sys_category}.{#sys_language_uid} IN (0,-1) ORDER BY sys_category.uid',
            'default' => '0'
        ],
   ],


Defining the field in the TCE
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

An individual modification of the newly added field *tx_examples_main_category* to the TCA definition of the table *tt_content* can be done in the TCE (TYPO3 Core Engine) TSConfig. In most cases it is necessary to set the page id of the general storage folder (available as a plugin select box to select a starting point page until TYPO3 6.2). Tnen the examples extension will only use the content records from the given page id. ::

   TCEFORM.tt_content.tx_examples_main_category.PAGE_TSCONFIG_ID = 18

If more than one page id is allowed, this configuration must be used instead (and the above TCA must be modified to use the marker ###PAGE_TSCONFIG_IDLIST### instead of ###PAGE_TSCONFIG_ID###)::

   TCEFORM.tt_content.tx_examples_main_category.PAGE_TSCONFIG_IDLIST = 18, 19, 20

.. code-block:: html

   <h2>Content separated by sign {data.tx_examples_separator}</h2>

.. note::

   As we are working with pure Fluid without Extbase here the new fields can
   be used right away. They need not be added to a model.


.. index:: pair: Content element; Data processing
.. _ConfigureCE-DataProcessors:

5. Optional: Use Data Processors
================================

Data processors can be used for some data manipulation or other actions you
would like to perform before passing everything to the view.

This is done in the :ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>`
section where you can add an arbitrary number of data processors.

Each one has to be added with a fully qualified class name (FQCN) and optional
parameters to be used in the data processor:

.. code-block:: typoscript

   tt_content {
       yourextensionkey_newcontentelement =< lib.contentElement
       yourextensionkey_newcontentelement {
           templateName = NewContentElement
           dataProcessing {
               1 = Vendor\YourExtensionKey\DataProcessing\NewContentElementProcessor
               1 {
                   exampleOptionName = exampleOptionValue
               }
           }
       }
   }

In the example :file:`setup.typoscript` above, the data processor is located in the directory :file:`Classes/DataProcessing/`.
The file :file:`NewContentElementProcessor.php` could look like this:

.. code-block:: php

   <?php
   declare(strict_types = 1);
   namespace Vendor\YourExtensionKey\DataProcessing;

   /*
    * This file is part of the TYPO3 CMS project.
    *
    * It is free software; you can redistribute it and/or modify it under
    * the terms of the GNU General Public License, either version 2
    * of the License, or any later version.
    *
    * For the full copyright and license information, please read the
    * LICENSE.txt file that was distributed with this source code.
    *
    * The TYPO3 project - inspiring people to share!
    */

   use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
   use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

   /**
    * Class for data processing for the content element "My new content element"
    */
   class NewContentElementProcessor implements DataProcessorInterface
   {

       /**
        * Process data for the content element "My new content element"
        *
        * @param ContentObjectRenderer $cObj The data of the content element or page
        * @param array $contentObjectConfiguration The configuration of Content Object
        * @param array $processorConfiguration The configuration of this processor
        * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
        * @return array the processed data as key/value store
        */
       public function process(
           ContentObjectRenderer $cObj,
           array $contentObjectConfiguration,
           array $processorConfiguration,
           array $processedData
       ) {
           $processedData['variableName'] = 'This variable will be passed to Fluid';

           return $processedData;
       }
   }


To use the variable `variableName` defined in :ref:`ConfigureCE-DataProcessors`
as h1 headline, you can use the following markup:

.. code-block:: html

   <h1>{variableName}</h1>

