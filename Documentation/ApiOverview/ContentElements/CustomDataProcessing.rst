.. include:: /Includes.rst.txt
.. index::
   Data processors; Custom data processor
   Custom data processor
.. _content-elements-custom-data-processor:

======================
Custom data processors
======================

When there is no fitting :ref:`data processor <t3tsref:dataProcessing>` to prepare
variables needed for your content element or template, you can define a custom
data processor by implementing the :php:`DataProcessorInterface`.

You can find the example below in the TYPO3 Documentation Team extension
`examples <https://extensions.typo3.org/extension/examples/>`__.


.. index::
   Custom data processor; TypoScript
   Custom data processor; Usage
.. _content-elements-custom-data-processor_typoscript:

Using a custom data processor in TypoScript
===========================================

The data processor can be configured by a TypoScript setup configuration. A custom
data processor can be used like this in the definition of a `new custom content
element`:

.. code-block:: typoscript

   tt_content {
      examples_dataproccustom =< lib.contentElement
      examples_dataproccustom {
         templateName = DataProcCustom
         dataProcessing.10 = T3docs\Examples\DataProcessing\CustomCategoryProcessor
         dataProcessing.10 {
            as = categories
            categoryList.field = tx_examples_main_category
         }
      }
   }

In the extension *examples* you can finde the code in
:file:`typo3conf/ext/examples/Configuration/TypoScript/setup.typoscript`.

Where :typoscript:`tx_examples_main_category` is the field in which the comma
separated categories are being stored.

.. note::

   The custom data processor described here was intended to be kept as a
   simple example. It can therefore only work with comma separated values,
   not a m-n relationship as is used in the field :php:`categories` of
   tables like :php:`tt_content`. For that further logic would need to be
   implemented.


.. index::
   Custom data processor; Impementation
   Interface; DataProcessorInterface
.. _content-elements-custom-data-processor_implementation:

Implementing the custom data processor
======================================

The custom data processor needs to implement :php:`DataProcessorInterface`.
The main function :php:`process` gets called with the following parameters:

:php:`ContentObjectRenderer $cObj`
   Receives the data of the current TypoScript context, in this case the 
   data of the calling content element.

:php:`array $contentObjectConfiguration`
   Contains the configuration of the calling content element. In this example
   all configuration of :typoscript:`tt_content.examples_dataproccustom`

:php:`array $processorConfiguration`
   Contains the configuration of the currently called dataprocessor. In this
   case the value of :typoscript:`as` and the stdWrap configuration of the
   :typoscript:`categoryList`


:php:`array $processedData`
   On calling containt the processed data of all previously called data 
   processors on this content element. Your custom data processor also stores
   the variables to be send to Fluid here.

This is an example implementation of a custom data processor::

   namespace T3docs\Examples\DataProcessing;

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
   use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
   use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;

   class CustomCategoryProcessor implements DataProcessorInterface
   {
      public function process : array (
         ContentObjectRenderer $cObj,
         array $contentObjectConfiguration,
         array $processorConfiguration,
         array $processedData
      ) {
         if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            // leave $processedData unchanged in case there were previous other processors
            return $processedData;
         }
         // categories by comma separated list
         $categoryIdList = $cObj->stdWrapValue('categoryList', $processorConfiguration ?? []);
         if ($categoryIdList) {
            $categoryIdList = GeneralUtility::intExplode(',', (string)$categoryIdList, true);
         }

         /** @var CategoryRepository $categoryRepository */
         $categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class);
         $categories = [];
         foreach ($categoryIdList as $categoryId) {
            $categories[] = $categoryRepository->findByUid($categoryId);
         }
         // set the categories into a variable, default "categories"
         $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'categories');
         $processedData[$targetVariableName] = $categories;
         return $processedData;
      }
   }

In the extension *examples* you can finde the code in
:file:`typo3conf/ext/examples/Classes/DataProcessing/CustomCategoryProcessor.php`.

On being called the :php:`CustomCategoryProcessor` runs stdWrap on the calling
ContentObjectRenderer, which has the data of the table :php:`tt_content` the
calling content element.

Since the field :php:`categoryList` got configured in TypoScript as follows:

..code-block:: typoscript

   categoryList.field = tx_examples_main_category

:ref:`stdWrap <t3tsref:stdwrap>` fetches the value of :php:`categoryList` from
:php:`tt_content.tx_examples_main_category` of the currently calling content
element.

Now the custom data processor processes the comma separated values into an array
of integers that represent uids of the table :php:`sys_category`. It then
fetches the category data from the :php:`CategoryRepository` by calling
:php:`findByUid`.

The data of the category records gets then stored in the desired key in the
:php:`$processedData` array.

In order to make the data processor more configurable we test for a TypoScript
:ref:`if <t3tsref:if>` condition in the beginning and make the name of the key to store
the data configurable by the configuration :typoscript:`as`;
