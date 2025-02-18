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
:composer:`t3docs/examples`.


..  index::
    Custom data processor; TypoScript
    Custom data processor; Usage
..  _content-elements-custom-data-processor_typoscript:

Using a custom data processor in TypoScript
===========================================

The data processor can be configured through a TypoScript setup configuration. A
custom data processor can be used in the definition of a "new custom content
element" as follows:

..  include:: /CodeSnippets/DataProcessing/CustomCategoryProcessorTypoScript.rst.txt

In the extension *examples* you can find the code in
:file:`EXT:examples/Configuration/TypoScript/DataProcessors/Processors/CustomCategoryProcessor.typoscript`.

In the field :typoscript:`categories` the comma-separated categories are stored.

..  note::
    The custom data processor described here should serve as a simple example.
    It can therefore only work with comma-separated values, not with an m:n
    relationship as used in the field :php:`categories` of tables like
    :sql:`tt_content`. For that, further logic would need to be implemented.


..  index::
    Custom data processor; Alias
..  _content-elements-custom-data-processor_alias:

Register an alias for the data processor (optional)
===================================================

Instead of using the fully-qualified class name as data processor identifier
(in the example above :php:`T3docs\Examples\DataProcessing\CustomCategoryProcessor`)
you can also define a short alias in :file:`Configuration/Services.yaml`:

..  code-block:: yaml
    :caption: EXT:examples/Configuration/Services.yaml

    T3docs\Examples\DataProcessing\CustomCategoryProcessor:
        tags:
            - name: 'data.processor'
              identifier: 'custom-category'

The alias :yaml:`custom-category` can now be used as data processor identifier
like in the TypoScript example above.

..  note::
    When registering a data processor alias please be sure you don't override
    an existing alias (from TYPO3 Core or a third-party extension) as this may
    cause errors.

..  tip::
    It is recommended to tag custom data processors as this will
    automatically add them to the internal :php:`DataProcessorRegistry`,
    enabling :ref:`dependency injection <DependencyInjection>` by default.
    Otherwise, the service would need to be set :ref:`public <What-to-make-public>`.

..  note::

    If your data processor should not be shared then
    you need to set the :yaml:`shared: false` tag attribute for the service.

..  index::
    Custom data processor; Implementation
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
    Contains the configuration of the calling content element. In this example it is
    the configuration :typoscript:`tt_content.examples_dataproccustom`

:php:`array $processorConfiguration`
    Contains the configuration of the currently called data processor. In this
    example it is the value of :typoscript:`as` and the :typoscript:`stdWrap`
    configuration of the :typoscript:`categoryList`


:php:`array $processedData`
    On calling, contains the processed data of all previously called data
    processors on this same content element. Your custom data processor also stores
    the variables to be sent to the Fluid template here.

This is an example implementation of a custom data processor:

..  include:: /CodeSnippets/DataProcessing/CustomCategoryProcessor.rst.txt

In the extension *examples* you can find the code in
:file:`EXT:/examples/Classes/DataProcessing/CustomCategoryProcessor.php`.

On being called, the :php:`CustomCategoryProcessor` runs :typoscript:`stdWrap`
on the calling ContentObjectRenderer, which has the data of the table
:sql:`tt_content` in the calling content element.

The field :php:`categoryList` gets configured in TypoScript as follows:

..  code-block:: typoscript

    categoryList.field = categories

:ref:`stdWrap <t3tsref:stdwrap>` fetches the value of :php:`categoryList` from
:sql:`tt_content.tx_examples_main_category` of the currently calling content
element.

Now the custom data processor processes the comma-separated values into an array
of integers that represent uids of the table :sql:`sys_category`. It then
fetches the category data from the :php:`CategoryRepository` by calling
:php:`findByUid`.

The data of the category records then get stored in the desired key in the
:php:`$processedData` array.

To make the data processor more configurable, we test for a TypoScript
:ref:`if <t3tsref:if>` condition at the beginning, and name the key
we use to store the data configurable by the configuration :typoscript:`as`.
