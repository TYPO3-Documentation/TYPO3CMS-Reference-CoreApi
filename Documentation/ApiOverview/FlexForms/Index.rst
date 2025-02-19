.. include:: /Includes.rst.txt
.. index:: FlexForms
.. _flexforms:

=========
FlexForms
=========

FlexForms can be used to store data within an XML structure inside a single DB
column.

More information on this data structure is available in the section
:ref:`t3ds`.

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

..  versionchanged:: 13.0
    The superfluous tag :xml:`TCEforms` was removed and is not evaluated
    anymore. Its sole purpose was to wrap real TCA definitions. The
    :xml:`TCEforms` tags **must** be removed upon dropping TYPO3 v11 support.


Example use cases
=================

The `bootstrap_package <https://github.com/benjaminkott/bootstrap_package>`__
uses FlexForms to configure rendering options,
e.g. a transition interval and transition type (slide, fade)
for the carousel content element.

.. include:: /Images/AutomaticScreenshots/FlexForms/FlexFormCarousel.rst.txt

Another extensions that utilize FlexForms and can be used as example is:

* `georgringer/news <https://github.com/georgringer/news>`__

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

#.  Create configuration schema in :ref:`T3DataStructure <t3ds>` format (XML)

    **Example:**

    ..  include:: /CodeSnippets/FlexForms/Examples/PluginHaikuList.rst.txt


#.  The configuration schema is attached to one or more plugins in the folder
    :file:`Configuration/TCA/Overrides` of an extension.

    Example for the FlexForm registration of a basic plugin:

    ..  include:: /CodeSnippets/FlexForms/Examples/PluginHaikuListRegistration.rst.txt

    When registering Extbase plugins you can use the return value of
    :php:`ExtensionUtility::registerPlugin()` to figure out the plugin
    signature to use:

    ..  code-block:: php
        :caption: EXT:blog_example/Configuration/TCA/Overrides/tt_content.php (Excerpt)

        $pluginSignature = ExtensionUtility::registerPlugin(
            'blog_example',
            'Pi1',
            'A Blog Example',
        );
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature]
            = 'pi_flexform';
        ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml'
        );


    If you are using a content element with a custom CType (recommend, both with and without
    Extbase), the example
    looks like this:

    ..  code-block:: php
        :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            // FlexForm configuration schema file
            'FILE:EXT:example/Configuration/FlexForms/Registration.xml',
            // ctype
            'accordion'
        );

    Finally, according to "Configuration of the displayed order of fields in FormEngine
    and their tab alignment." the field containing the FlexForm still needs to be
    added to the `showitem` directive.
    The following example shows line from the accordion element of the Bootstrap Package.

    .. code-block:: php
        :caption: EXT:your_extension/Configuration/TCA/Overrides/tt_content.php
        :emphasize-lines: 11

        // Configure element type
        $GLOBALS['TCA']['tt_content']['types']['accordion'] = array_replace_recursive(
            $GLOBALS['TCA']['tt_content']['types']['accordion'],
            [
                'showitem' => '
                    --div--;General,
                    --palette--;General;general,
                    --palette--;Headers;headers,
                    tx_bootstrappackage_accordion_item,
                    --div--;Options,
                    pi_flexform'
            ]
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

..  code-block:: xml

    <settings.orderBy>
        <label>
            LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy
        </label>
        <config>
            <type>select</type>
            <renderType>selectSingle</renderType>
            <items>
                <numIndex index="0">
                    <label>
                        LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.crdate
                    </label>
                    <value>crdate</value>
                </numIndex>
                <numIndex index="1">
                    <label>
                        LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.title
                    </label>
                    <value>title</value>
                </numIndex>
            </items>
        </config>
    </settings.orderBy>

.. seealso::

   * :ref:`t3tca:columns-select` in TCA reference.


.. _flexforms-itemsProcFunc:

Populate a `select` field with a PHP Function (itemsProcFunc)
-------------------------------------------------------------

..  code-block:: xml

    <settings.orderBy>
        <label>
            LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy
        </label>
        <config>
            <type>select</type>
            <itemsProcFunc>MyVendor\Example\Backend\ItemsProcFunc->user_orderBy
            </itemsProcFunc>
            <renderType>selectSingle</renderType>
            <items>
                <!-- empty by default -->
            </items>
        </config>
    </settings.orderBy>

The function :php:`user_orderBy` populates the select field in
:file:`Backend/ItemsProcFunc.php`:

..  code-block:: php

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

..  code-block:: xml

    <config>
        <type>select</type>
    </config>
    <!-- Hide field if value of neighbour field "settings.orderBy" on same sheet is not "title" -->
    <displayCond>FIELD:settings.orderBy:!=:title</displayCond>

Again, the syntax and available fields and comparison operators is documented
in the TCA reference:

.. seealso::

   * :ref:`t3tca:columns-properties-displaycond` in TCA Reference


.. _flexformReload:

Reload on change
----------------

Especially in combination with conditionally displaying settings with
:ref:`displayCond <flexformDisplayCond>`, you may want to trigger
a reloading of the form when specific settings are changed. You
can do that with:

..  code-block:: xml

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

.. attention::

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

..  versionchanged:: 13.0
    :php:`\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools` is now a stateless
    service and can be injected via :ref:`DependencyInjection`.
    :php:`FlexFormTools::flexArray2Xml()` is now marked as internal.

..  literalinclude:: _FlexformModificationService.php
    :caption: EXT:my_extension/Classes/Service/FlexformModificationService.php

..  note::
    The method FlexFormTools::flexArray2Xml() is marked as internal and subject
    to unannounced changes. Use at your own risk.


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

While you can use page TSconfig's :ref:`t3tsref:pageTsTcaDefaults` to
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

In order to have all FlexForm fields available, you can use the FlexFormProcessor. See also
:ref:`FlexFormProcessor in the TypoScript Reference<t3tsref:FlexFormProcessor>`.
This example would make your FlexForm data available as Fluid variable :html:`{myOutputVariable}`:

.. code-block:: typoscript

   my_content = FLUIDTEMPLATE
   my_content {
     dataProcessing {
       10 = TYPO3\CMS\Frontend\DataProcessing\FlexFormProcessor
       10.fieldName = my_flexform_field
       10.as = myOutputVariable
     }
   }

.. seealso::
   :ref:`FlexFormProcessor <t3tsref:FlexFormProcessor>`.


Steps to Perform (Editor)
=========================

After inserting a plugin, the editor can configure this plugin by switching
to the tab "Plugin" or whatever string you defined to replace this.

.. figure:: /Images/ManualScreenshots/FlexForms/FlexformBackend.png
   :class: with-shadow


Credits
=======

Some of the examples were taken from the extensions
:composer:`georgringer/news` (by Georg Ringer)
and :composer:`bk2k/bootstrap-package`
(by Benjamin Kott).

Further enhancements by the TYPO3 community are welcome!

T3DataStructure
===============

More information on the used data structures within FlexForms can be found
in these following chapters:

.. toctree::
   :titlesonly:

   T3datastructure/Index
