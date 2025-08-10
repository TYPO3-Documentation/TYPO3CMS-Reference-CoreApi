:navigation-title: Definitions

..  include:: /Includes.rst.txt
..  _flexforms-definition:

====================
FlexForm definitions
====================

FlexForms are defined as XML with a syntax similar to TCA.

..  contents::

..  _flexforms-definition-field:

Defining fields in a FlexForm
=============================

The definition of the data types and parameters used complies to the
:ref:`column types defined by TCA <t3tca:columns-types>`.

The settings must be added within the :html:`<el>` element in the FlexForm
configuration schema file.

..  _flexforms-definition-select:

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

..  seealso::

    *   :ref:`t3tca:columns-select` in TCA reference.

..  _flexforms-itemsProcFunc:

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

..  figure:: /Images/ManualScreenshots/FlexForms/FlexFormsItemsProcFunc.png
   :class: with-shadow

..  seealso::

   * :ref:`t3tca:columns-select-properties-itemsprocfunc` in TCA reference.


..  index:: FlexForms; Display conditions
..  _flexformDisplayCond:

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

..  seealso::

   * :ref:`t3tca:columns-properties-displaycond` in TCA Reference

..  _flexformReload:

Reload on change
----------------

Especially in combination with conditionally displaying settings with
:ref:`displayCond <flexformDisplayCond>`, you may want to trigger
a reloading of the form when specific settings are changed. You
can do that with:

..  code-block:: xml

    <onChange>reload</onChange>
    <config>
        <!-- ...  -->
    </config>


The :xml:`onChange` element is optional and must be placed on the same level as the :xml:`<config>` element.



..  index:: pair: FlexForms; Default value
..  _default-flexforms-attribute:

Providing default values for FlexForms attributes
=================================================

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
