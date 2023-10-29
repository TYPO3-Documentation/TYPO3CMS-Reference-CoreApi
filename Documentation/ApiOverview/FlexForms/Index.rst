.. include:: /Includes.rst.txt
.. index:: FlexForms
.. _flexforms:

=========
FlexForms
=========

FlexForms can be used to store data within an XML structure inside a single DB
column.

FlexForms can be used to configure :ref:`content elements (CE) or plugins
<content-elements>`, but they are optional so you can create plugins or
content elements without using FlexForms.

Most of the configuration below is the same, whether you are adding configuration
for a plugin or content element. The main difference is how :php:`addPiFlexFormValue()`
is used.

You may want to configure
individual plugins or content elements differently, depending on where they are added. The
configuration set via the FlexForm mechanism applies to only the content
record it has been configured for. The FlexForms configuration for a plugin or CE
can be changed by editors in the backend. This gives editors more control
over plugin features and what is to be rendered.

Using FlexForms you have all the features of TCA, so it is possible
to use input fields, select lists, show options conditionally and more.


Example use cases
=================

The `bootstrap_package <https://github.com/benjaminkott/bootstrap_package>`__
uses FlexForms to configure rendering options,
e.g. a transition interval and transition type (slide, fade)
for the carousel content element.

.. include:: /Images/AutomaticScreenshots/FlexForms/FlexFormCarousel.rst.txt

Some more extensions that utilize FlexForms are:

* `georgringer/news <https://github.com/georgringer/news>`__
* `blog <https://github.com/TYPO3GmbH/blog>`__: This has a very small and
  basic FlexForm, so it might be a good starting point to look at.



How it works
============

#. In the extension, a configuration schema is defined and attached to
   one or more content elements or plugins.
#. When the CE or plugin is added to a page, it can be configured as defined
   by the configuration
   schema.
#. The configuration for this content element is automatically saved to `tt_content.pi_flexform`.
#. The extension can read current configuration and act according to
   the configuration.


..  tip::
    The data structure of a FlexForm may change over time. Also, when switching
    from one plugin with a FlexForm to another plugin with a FlexForm in an
    element, the old values are not removed in the FlexForm field. This
    may cause problems and errors. You can avoid this by calling the
    :ref:`CLI <symfony-console-commands>` command `cleanup:flexforms` which is
    provided by the :doc:`lowlevel system extension <ext_lowlevel:Index>`. It
    updates all database records which have a FlexForm field and the XML data
    does not match the chosen data structure.

Steps to perform (extension developer)
======================================

.. rst-class:: bignums-xxl

#. Create configuration schema in :ref:`T3DataStructure <t3ds>` format (XML)

   Example: :file:`Configuration/FlexForms/Registration.xml`.

   .. code-block:: xml

        <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
        <T3DataStructure>
            <sheets>
                <sDEF>
                    <ROOT>
                        <TCEforms>
                            <sheetTitle>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.title</sheetTitle>
                        </TCEforms>
                        <type>array</type>
                        <el>
                            <!-- Add settings here ... -->

                            <!-- Example setting: input field with name settings.includeCategories -->
                            <settings.includeCategories>
                                <TCEforms>
                                    <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.includeCategories</label>
                                    <config>
                                        <type>check</type>
                                        <default>0</default>
                                        <items type="array">
                                            <numIndex index="0" type="array">
                                                <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:setting.registration.includeCategories.title</numIndex>
                                            </numIndex>
                                        </items>
                                    </config>
                                </TCEforms>
                            </settings.includeCategories>

                            <!-- end of settings -->

                        </el>
                    </ROOT>
                </sDEF>
            </sheets>
        </T3DataStructure>


#. The configuration schema is attached to one or more plugins

   The vendor name is **Myvendor**, the extension key is **example**
   and the plugin name is **Registration**.

   In :file:`Configuration/TCA/Overrides/tt_content.php` add the following:

   .. code-block:: php

       // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
       $pluginSignature = 'example_registration';
       $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
       \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
           $pluginSignature,
           // FlexForm configuration schema file
           'FILE:EXT:example/Configuration/FlexForms/Registration.xml'
       );

   .. tip::

      The plugin signature is used in the database field `tt_content.list_type`
      as well, when the tt_content record is saved. If you are confused about
      how to handle underscores and upper / lowercase, check there to see
      what your plugin signature is.

   Also look on the page :ref:`extension-naming`.

   If you are using a content element instead of a plugin, the example
   will look like this::

      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
         // 'list_type' does not apply here
         '*',
         // FlexForm configuration schema file
         'FILE:EXT:example/Configuration/FlexForms/Registration.xml',
         // ctype
         'accordion'
      );

#. Access the settings in your extension:

   The settings can be read using one of the methods described below, e.g.
   :ref:`from an Extbase controller action <read-flexforms-extbase>`,
   :ref:`from a PHP function <read-flexforms-php>` (without using the
   Extbase framework), from :ref:`TypoScript <read-flexforms-ts>` or
   from within a :ref:`Fluid template <read-flexforms-fluid>`.


More examples
=============

The definition of the data types and parameters used complies to the
:ref:`column types defined by TCA <t3tca:columns-types>`.

The settings must be added within the :html:`<el>` element in the FlexForm
configuration schema file.


.. index:: FlexForms; Select field

Select field
------------

.. code-block:: xml

    <settings.orderBy>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy</label>
            <config>
                <type>select</type>
                <renderType>selectSingle</renderType>
                <items>
                    <numIndex index="0">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.crdate</numIndex>
                        <numIndex index="1">crdate</numIndex>
                    </numIndex>
                    <numIndex index="1">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.title</numIndex>
                        <numIndex index="1">title</numIndex>
                    </numIndex>
                </items>
            </config>
        </TCEforms>
    </settings.orderBy>

.. seealso::

   * :ref:`t3tca:columns-select` in TCA reference.


.. _flexforms-itemsProcFunc:

Populate a `select` field with a PHP Function (itemsProcFunc)
-------------------------------------------------------------

.. code-block:: xml

    <settings.orderBy>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy</label>
            <config>
                <type>select</type>
                <itemsProcFunc>MyVendor\Example\Backend\ItemsProcFunc->user_orderBy</itemsProcFunc>
                <renderType>selectSingle</renderType>
                <items>
                    <!-- empty by default -->
                </items>
            </config>
        </TCEforms>
    </settings.orderBy>

The function :php:`user_orderBy` populates the select field in
:file:`Backend\ItemsProcFunc.php`:

.. code-block:: php

    class ItemsProcFunc
    {
         /**
         * Modifies the select box of orderBy-options.
         *
         * @param array &$config configuration array
         */
        public function user_orderBy(array &$config)
        {
            // simple and stupid example
            // change this to dynamically populate the list!
            $config['items'] = [
                // label, value
                ['Timestamp', 'timestamp'],
                ['Title', 'title']
            ];
        }

        // ...
     }

How this looks when configuring the plugin:

.. figure:: /Images/ManualScreenshots/FlexForms/FlexFormsItemsProcFunc.png
   :class: with-shadow

.. seealso::

   * :ref:`t3tca:columns-select-properties-itemsprocfunc` in TCA reference.


.. index:: FlexForms; Display conditions
.. _flexformDisplayCond:

Display fields conditionally (displayCond)
------------------------------------------

Some settings may only make sense, depending on other settings.
For example in one setting you define a sorting order (by date, title etc.)
and all sort orders except "title" have additional settings. These
should only be visible, if sort order "title" was not selected.

You can define conditions using displayCond. This dynamically defines
whether a setting should be displayed when the plugin is configured.
The conditions may for example depend on one or more other settings in the FlexForm,
on database fields of current record or be defined by a user function.


.. code-block:: xml

    <config>
        <type>select</type>
    </config>
    <!-- Hide field if value of neighbour field "settings.orderBy" on same sheet is not "title" -->
    <displayCond>FIELD:settings.orderBy:!=:title</displayCond>

Again, the syntax and available fields and comparison operators is documented
in the TCA reference:

.. seealso::

   * :ref:`t3tca:columns-properties-displaycond` in TCA Reference


.. index:: Flexforms; switchableControllerActions
.. _flexformSwitchableControllerActions:

switchableControllerActions
---------------------------

.. deprecated:: 10.3

   It is no longer considered best practice to use
   `switchableControllerActions` in a Flexform. The reasons
   for the deprecation and possible alternatives are outlined
   in the changelog :doc:`ext_core:Changelog/10.3/Deprecation-89463-SwitchableControllerActions`.


.. _flexformReload:

Reload on change
----------------

Especially in combination with conditionally displaying settings with
:ref:`displayCond <flexformDisplayCond>`, you may want to trigger
a reloading of the form when specific settings are changed. You
can do that with:

.. code-block:: xml

   <onChange>reload</onChange>
   <config>
       <!-- ... -->
   </config>


The :xml:`onChange` element is optional and must be placed on the same level as the :xml:`<config>` element.


.. index:: pair: FlexForms; Extbase
.. _read-flexforms:
.. _read-flexforms-extbase:

How to read FlexForms from an Extbase controller action
-------------------------------------------------------

The settings can be read using :php:`$this->settings` in an
Extbase controller.

.. code-block:: php

   $includeCategories = (bool) ($this->settings['includeCategories'] ?? false);

.. important::

   If you wish to access a setting from your controller via
   :php:`$this->settings`, the name of the setting must be prefixed with `settings.`,
   so literally `settings` directly followed by a dot (`.`).

..  index::
    FlexForms; Read in PHP
    FlexForms; FlexFormService
.. _read-flexforms-php:

Read FlexForms values in PHP
----------------------------

You can use the :php:`FlexFormService` to read the content of a FlexForm field:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/NonExtbaseController.php

    use TYPO3\CMS\Core\Service\FlexFormService;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    final class NonExtbaseController
    {

        // Inject FlexFormService
        public function __construct(
            private readonly FlexFormService $flexFormService,
        ) {
        }

        // ...

        private function loadFlexForm($flexFormString): array
        {
            return $this->flexFormService
                ->convertFlexFormContentToArray($flexFormString);
        }
    }

Using :php:`FlexFormService->convertFlexFormContentToArray` the resulting
array can be used conveniently in most use cases:

..  code-block:: php

     var_export(
         $this->flexFormService->convertFlexFormContentToArray($flexFormString)
     );

    /* Output:
    [
        'settings' => [
            'singlePid' => 25,
            'listPid' => 380,
        ],
    ]
    */

The result of :php:`GeneralUtility::xml2array()` preserves the internal
structure of the XML FlexForm, and is usually used to modify a FlexForm
string. See section :ref:`modify-flexforms-php` for an example.

..  code-block:: php

    var_export(GeneralUtility::xml2array($flexFormString)));

    /* Output:
    [
        'data' =>
            [
                'sDEF' =>
                    [
                        'lDEF' =>
                            [
                                'settings.singlePid' =>['vDEF' => '4',],
                                'settings.listPid' =>['vDEF' => '',],
                            ],
                    ],
            ],
    ];
    */


..  index::
    FlexForms; Modify in PHP
    FlexForms; FlexFormTools
.. _modify-flexforms-php:

How to modify FlexForms from PHP
--------------------------------

Some situation make it necessary to modify FlexForms via PHP.

In order to convert a FlexForm to a PHP array, preserving the structure,
the :php:`xml2array` method in :php:`GeneralUtility`  can be used to read
the FlexForm data, then the :php:`FlexFormTools` can be used to write back the
changes.

..  code-block:: php

    use \TYPO3\CMS\Core\Utility\GeneralUtility;
    use \TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;

    $flexFormArray = GeneralUtility::xml2array($flexFormString);
    $changedFlexFormArray = $this->doSomething($flexFormArray);

    $flexFormTools = new FlexFormTools();
    $flexFormString = $flexFormTools->flexArray2Xml($changedFlexFormArray, addPrologue: true);


.. index:: pair: FlexForms; TypoScript
.. _read-flexforms-ts:

How to access FlexForms From TypoScript
---------------------------------------

It is possible to read FlexForm properties from TypoScript:

..  code-block:: typoscript

    lib.flexformContent = CONTENT
    lib.flexformContent {
        table = tt_content
        select {
            pidInList = this
        }

        renderObj = COA
        renderObj {
            10 = TEXT
            10 {
                data = flexform: pi_flexform:settings.categories
            }
        }
    }

The key `flexform` is followed by the field which holds the FlexForm data
(`pi_flexform`) and the name of the property whose content should be retrieved
(`settings.categories`).

.. seealso::

   * :ref:`TypoScript: flexform <t3tsref:data-type-gettext-flexform>`


.. index:: pair: FlexForms; Default value
.. _default-flexforms-attribute:

Providing default values for FlexForms attributes
-------------------------------------------------

When a new content element with an attached FlexForm is created, the
default values for each FlexForm attribute is fetched from the
:xml:`<default>` XML attribute within the specification of each
FlexForm attribute. If that is missing, an empty value will be
shown in the backend (:ref:`FormEngine <FormEngine>`)
fields.

While you can use page TSconfig's :ref:`t3tsconfig:pageTsTcaDefaults` to
modify defaults of usual TCA-based attributes, this is not
possible on FlexForms. This is because the values are calculated
at an earlier step in the Core workflow, where FlexForm values
have not yet been extracted.

.. index:: pair: FlexForms; Fluid
.. _read-flexforms-fluid:

How to access FlexForms from Fluid
----------------------------------

If you are using an Extbase controller, FlexForm settings can be read from within a Fluid template using
:html:`{settings}`. See the note on naming restrictions in :ref:`How to Read FlexForms From an Extbase Controller Action <read-flexforms-extbase>`.

If you defined your :typoscript:`FLUIDTEMPLATE` in TypoScript, you can assign single variables like that:

.. code-block:: typoscript

   my_content = FLUIDTEMPLATE
   my_content {
     variables {
       categories = TEXT
       categories.data = flexform: pi_flexform:categories
     }
   }

In order to have all FlexForm fields available, you can add a custom DataProcessor.
This example would make your FlexForm data available as Fluid variable :html:`{flexform}`:

.. code-block:: typoscript

   my_content = FLUIDTEMPLATE
   my_content {
     dataProcessing {
       10 = Your\Ext\DataProcessing\FlexFormProcessor
     }
   }

.. code-block:: php

   namespace Your\Ext\DataProcessing;

   use TYPO3\CMS\Core\Service\FlexFormService;
   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

   class FlexFormProcessor implements DataProcessorInterface
   {
       /**
        * @var FlexFormService
        */
       protected $flexFormService;

       public function __construct(FlexFormService $flexFormService) {
           $this->flexFormService = $flexFormService;
       }

       public function process(
           ContentObjectRenderer $cObj,
           array $contentObjectConfiguration,
           array $processorConfiguration,
           array $processedData
       ): array {
           $originalValue = $processedData['data']['pi_flexform'];
           if (!is_string($originalValue)) {
               return $processedData;
           }

           $flexformData = $this->flexFormService->convertFlexFormContentToArray($originalValue);
           $processedData['flexform'] = $flexformData;
           return $processedData;
       }
   }

.. seealso::
   :ref:`configure-dependency-injection-in-extensions`.


Steps to Perform (Editor)
=========================

After inserting a plugin, the editor can configure this plugin by switching
to the tab "Plugin" or whatever string you defined to replace this.

.. figure:: /Images/ManualScreenshots/FlexForms/FlexformBackend.png
   :class: with-shadow


Credits
=======

Some of the examples were taken from the extensions
:t3ext:`news` (by Georg Ringer)
and :t3ext:`bootstrap_package`
(by Benjamin Kott).

Further enhancements by the TYPO3 community are welcome!
