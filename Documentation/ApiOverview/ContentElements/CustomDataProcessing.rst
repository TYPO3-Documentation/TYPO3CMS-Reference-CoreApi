..  include:: /Includes.rst.txt
..  index::
    Data processors; Custom data processor
    Custom data processor
..  _content-elements-custom-data-processor:

======================
Custom data processors
======================

When there is no suitable :ref:`data processor <t3tsref:dataProcessing>` that
prepares the variables needed for your content element or template, you can
define a custom data processor by implementing
:php:`\TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface`.

You can find the example below in the TYPO3 Documentation Team extension
`examples <https://extensions.typo3.org/extension/examples/>`__.


..  index::
    Custom data processor; TypoScript
    Custom data processor; Usage
..  _content-elements-custom-data-processor_typoscript:

Using a custom data processor in TypoScript
===========================================

The data processor can be configured through a TypoScript setup configuration. A
custom data processor can be used in the definition of a "new custom content
element" as follows:

..  code-block:: typoscript

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

In the extension *examples* you can find the code in
:file:`EXT:examples/Configuration/TypoScript/setup.typoscript`.

In the field :typoscript:`tx_examples_main_category` the comma-separated
categories are stored.

..  note::
    The custom data processor described here should serve as a simple example.
    It can therefore only work with comma-separated values, not with an m:n
    relationship as used in the field :php:`categories` of tables like
    :sql:`tt_content`. For that, further logic would need to be implemented.


..  index::
    Custom data processor; Impementation
    Interface; DataProcessorInterface
..  _content-elements-custom-data-processor_implementation:

Implementing the custom data processor
======================================

The custom data processor must implement :php:`\TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface`.
The main method :php:`process()` gets called with the following parameters:

:php:`ContentObjectRenderer $cObj`
    Receives the data of the current TypoScript context, in this case the
    data of the calling content element.

:php:`array $contentObjectConfiguration`
    Contains the configuration of the calling content element. In this example
    all configuration of :typoscript:`tt_content.examples_dataproccustom`

:php:`array $processorConfiguration`
    Contains the configuration of the currently called data processor. In this
    case the value of :typoscript:`as` and the :typoscript:`stdWrap`
    configuration of the :typoscript:`categoryList`


:php:`array $processedData`
    On calling, contains the processed data of all previously called data
    processors on this content element. Your custom data processor also stores
    the variables to be send to Fluid here.

This is an example implementation of a custom data processor:

..  code-block:: php
    :caption: EXT:examples/Classes/DataProcessing/CustomCategoryProcessor.php

    namespace T3docs\Examples\DataProcessing;

    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
    use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
    use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;

    class CustomCategoryProcessor implements DataProcessorInterface
    {
        public function process(
            ContentObjectRenderer $cObj,
            array $contentObjectConfiguration,
            array $processorConfiguration,
            array $processedData
        ) : array {
            if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
                // leave $processedData unchanged in case there were previous other processors
                return $processedData;
            }
            // categories by comma-separated list
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

In the extension *examples* you can find the code in
:file:`typo3conf/ext/examples/Classes/DataProcessing/CustomCategoryProcessor.php`.

On being called, the :php:`CustomCategoryProcessor` runs :typoscript:`stdWrap`
on the calling ContentObjectRenderer, which has the data of the table
:sql:`tt_content` in the calling content element.

Since the field :php:`categoryList` got configured in TypoScript as follows:

..  code-block:: typoscript

    categoryList.field = tx_examples_main_category

:ref:`stdWrap <t3tsref:stdwrap>` fetches the value of :php:`categoryList` from
:sql:`tt_content.tx_examples_main_category` of the currently calling content
element.

Now the custom data processor processes the comma-separated values into an array
of integers that represent uids of the table :sql:`sys_category`. It then
fetches the category data from the :php:`CategoryRepository` by calling
:php:`findByUid`.

The data of the category records then gets stored in the desired key in the
:php:`$processedData` array.

To make the data processor more configurable, we test for a TypoScript
:ref:`if <t3tsref:if>` condition at the beginning, and make the name of the key
we use to store the data configurable by the configuration :typoscript:`as`.
