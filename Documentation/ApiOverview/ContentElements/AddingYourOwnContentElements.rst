.. include:: ../../Includes.txt

.. _adding-your-own-content-elements:

=======================
Custom Content Elements
=======================

This page explains how to create your own custom content element types, in
addition to the content elements already supplied by TYPO3. You can find
more code examples in the system extension `fluid_styled_content`.

A content element can be based on fields already available in the `tt_content` table.

It is also possible to add extra fields that can be added to the `tt_content` table.
Adding fields is done by :ref:`extending the TCA <t3coreapi:extending>`.

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

Use an extension
================

We recommend to create your own extension for adding content elements.
The following example uses the extension key `your_extension_key`.

If you have plans to publish your extension, follow :ref:`t3coreapi:extension-key-registration`.

.. _AddingCE-PageTSconfig:
.. _RegisterCE:
.. _AddingCE-TCA-Overrides-tt_content:

1. Register the content element
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

You need to :ref:`register the icon identifier <t3coreapi:icon-registration>` with the icon API in your :file:`ext_localconf.php`.

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

2. Configure fields
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

3. Configure the frontend template
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


.. _ConfigureCE-Preview:

4. Optional: configure custom backend preview
=============================================

If you want to generate a special preview in the backend :guilabel:`Web > Page` module, you can use a hook for this:

.. code-block:: php

   // Register for hook to show preview of tt_content element of CType="yourextensionkey_newcontentelement" in page module
   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['yourextensionkey_newcontentelement'] =
      \Vendor\YourExtensionKey\Hooks\PageLayoutView\NewContentElementPreviewRenderer::class;

According to the used namespace, a new file :file:`Classes/Hooks/PageLayoutView/NewContentElementPreviewRenderer.php`
has to be created with the following content:

.. code-block:: php

   <?php
   namespace Vendor\YourExtensionKey\Hooks\PageLayoutView;

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

   use TYPO3\CMS\Backend\View\PageLayoutView;
   use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;

   /**
    * Contains a preview rendering for the page module of CType="yourextensionkey_newcontentelement"
    */
   class NewContentElementPreviewRenderer implements PageLayoutViewDrawItemHookInterface
   {

       /**
        * Preprocesses the preview rendering of a content element of type "My new content element"
        *
        * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
        * @param bool $drawItem Whether to draw the item using the default functionality
        * @param string $headerContent Header content
        * @param string $itemContent Item content
        * @param array $row Record row of tt_content
        *
        * @return void
        */
       public function preProcess(
           PageLayoutView &$parentObject,
           &$drawItem,
           &$headerContent,
           &$itemContent,
           array &$row
       ) {
           if ($row['CType'] === 'yourextensionkey_newcontentelement') {
               $itemContent .= '<p>We can change our preview here!</p>';

               $drawItem = false;
           }
       }
   }

.. _ConfigureCE-Extend-tt_content:

5. Optional: extend tt_content
==============================

.. todo::

   This will be filled in another patch.

.. _ConfigureCE-DataProcessors:

6. Optional: use data processors
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


To use the variable `variableName` defined in :ref:`ConfigureCE-Data-Processor`
as h1 headline, you can use the following markup:

.. code-block:: html

   <h1>{variableName}</h1>

