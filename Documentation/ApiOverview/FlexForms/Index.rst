.. include:: ../../Includes.txt

.. _flexforms:

==============
FlexForms
==============

FlexForms can be used to configure extension plugins in the backend.

Credits
=======

Some of the examples were taken from the extensions
`news <https://extensions.typo3.org/extension/example/>`__ (by Georg Ringer)
and `bootstrap_package <https://extensions.typo3.org/extension/example/>`__
(by Benjamin Kott). This chapter was originally written by Sybille Peters.

Further enhancements by the TYPO3 community are welcome!

When to Use FlexForms
=====================

Extensions can be configured using :ref:`Extension Configuration <extension-options>`.
This configuration applies to the extension in general. You may want to configure
individual plugins differently, depending on where they are added. The
configuration set via the FlexForm mechanism applies to only the content
record it has been configured for. The FlexForms configuration
can be changed by editors. This gives editors more control over plugin features
and what is to be rendered.

FlexForms configuration has more possibilities than Extension Configuration.
Extension Configuration uses TypoScript constant syntax. This limits you to one
single line per configuration option with very little flexibility.

With FlexForm, it is possible to populate select lists via functions
(:ref:`itemsProcFunc <flexforms-itemsProcFunc>`),
show options conditionally and more.

Example Use Cases
=================

* Use the plugin to configure a different view, e.g. list, single
* The `bootstrap_package <https://extensions.typo3.org/extension/example/>`__
  uses FlexForms to configure rendering options,
  e.g. a transition interval and transition type (slide, fade)
  for the carousel.

.. image:: Images/FlexFormCarousel.png
   :class: with-shadow


How it Works
============

#. In the extension, a configuration schema is defined and attached to one or more plugins.
#. When the plugin is added to a page, it can be configured as defined by the configuration
   schema.
#. The configuration for this content element is automatically saved to `tt_content.pi_flexform`.
#. The extension can read current configuration in the controller and act according to
   the configuration for the current plugin.

Steps to Perform (Extension Developer)
======================================

.. rst-class:: bignums-xxl

#. Create configuration schema

   A configuration schema in XML is added to the extension.

   Example: :file:`Configuration/FlexForms/Registration.xml`.

   .. code-block:: xml

        <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
        <T3DataStructure>
            <sheets>
                <sDEF>
                    <ROOT>
                        <TCEforms>
                            <sheetTitle>LLL:EXT:extkey/Resources/Private/Language/Backend.xlf:settings.registration.title</sheetTitle>
                        </TCEforms>
                        <type>array</type>
                        <el>
                            <!-- Add settings here ... -->

                            <!-- Example setting: checkbox with name settings.includeCategories -->
                            <settings.includeCategories>
                                <TCEforms>
                                    <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.includeCategories</label>
                                    <config>
                                        <type>check</type>
                                    </config>
                                </TCEforms>
                            </settings.includeCategories>

                            <!-- end of settings -->

                        </el>
                    </ROOT>
                </sDEF>
            </sheets>
        </T3DataStructure>

#. Add texts and translations

   Add text for the language keys used in schema (LLL) to your language
   files in :file:`Resources/Private/Languages`.

   .. code-block:: xml

       <trans-unit id="settings.registration.title">
           <source>Settings for Registration plugin</source>
       </trans-unit>
       <trans-unit id="settings.registration.includeCategories">
           <source>Include categories</source>
       </trans-unit>


#. The configuration schema is attached to one or more plugins

   Here, the vendor name is **Myvendor, the extension key is **example**
   and the plugin name is **Registration**.

   in :file:`Configuration/TCA/Overrides/tt_content.php`:

   .. code-block:: php

      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
          // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
          'Myvendor.example',
          // Plugin name: unique id in UpperCamelCase
          'Registration',
          // title
          'LLL:EXT:example/Resources/Private/Language/Backend.xlf:registration_title'
      );

   * `API reference: registerPlugin <https://github.com/TYPO3/TYPO3.CMS/blob/ddedb065030de860de87e39636ed2664c7c531cd/typo3/sysext/extbase/Classes/Utility/ExtensionUtility.php#L104>`__

   .. code-block:: php

       $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['example_registration'] = 'pi_flexform';
       \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
           // plugin signature: <extension key> '_' <plugin name in lowercase>
           'example_registration',
           // Flexform configuration schema file
           'FILE:EXT:example/Configuration/FlexForms/Registration.xml'
       );

   * `API reference: addPiFlexFormValue <https://github.com/TYPO3/TYPO3.CMS/blob/ddedb065030de860de87e39636ed2664c7c531cd/typo3/sysext/core/Classes/Utility/ExtensionManagementUtility.php#L1263>`__

   .. tip::

      The plugin signature is used in the database field `tt_content.ctype`
      as well, when the tt_content record is saved. If you are confused about
      how to handle underscores and upper / lowercase, check there to see
      what your plugin signature is.

      Also look on the page :ref:`extension-naming`.

#. The settings can be read using :php:`$this->settings` in an
   Extbase controller.

   .. code-block:: php

      $includeCategories = (bool) ($this->settings['includeCategories'] ?? false);


Schema Examples
===============

The definition of the data types and parameters used complies in large
parts to the :ref:`column types defined by TCA <t3tca:columns-types>`.

* :ref:`t3tca:columns-input`
* :ref:`t3tca:columns-check`
* :ref:`t3tca:columns-select`
* ...

The settings must be added within the <el> element in the FlexForm configuration
schema file.

.. important::

    If you wish to access a setting from your controller via
    :php:`$this->settings`, the name of the setting must begin with
    **settings** directly followed by a dot (`.`).

Input Field
-----------

This is a text field.

.. code-block:: xml

    <settings.timeRestriction>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.timeRestriction</label>
            <config>
                <default></default>
                <type>input</type>
                <size>15</size>
            </config>
        </TCEforms>
    </settings.timeRestriction>

.. seealso::

   :ref:`t3tca:columns-input` in TCA Reference.

Select Field
------------

Here, the

* vendor name is **Myvendor**
* the extension key is **example**

.. code-block:: xml

    <settings.orderBy>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy</label>
            <config>
                <type>select</type>
                <itemsProcFunc>Myvendor\Example\Backend\ItemsProcFunc->user_orderBy</itemsProcFunc>
                <renderType>selectSingle</renderType>
                <items>
                    <numIndex index="0" type="array">
                        <numIndex index="0"></numIndex>
                        <numIndex index="1"></numIndex>
                    </numIndex>
                    <numIndex index="1">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.tstamp</numIndex>
                        <numIndex index="1">tstamp</numIndex>
                    </numIndex>
                    <numIndex index="2">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.datetime</numIndex>
                        <numIndex index="1">datetime</numIndex>
                    </numIndex>
                    <numIndex index="3">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.crdate</numIndex>
                        <numIndex index="1">crdate</numIndex>
                    </numIndex>
                    <numIndex index="4">
                        <numIndex index="0">LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy.title</numIndex>
                        <numIndex index="1">title</numIndex>
                    </numIndex>
                </items>
            </config>
        </TCEforms>
    </settings.orderBy>

.. _flexforms-itemsProcFunc:

Populate a `select` Field with a PHP Function (itemsProcFunc)
-------------------------------------------------------------

Here, the

* vendor name is **Myvendor**
* the extension key is **example**

.. code-block:: xml

    <settings.orderBy>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy</label>
            <config>
                <type>select</type>
                <itemsProcFunc>Myvendor\Example\Backend\ItemsProcFunc->user_orderBy</itemsProcFunc>
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
            $config['items] = [
                // label, value
                ['Timestamp', 'timestamp'],
                ['Title', title]
            ];
        }

        // ...
     }

How this looks when configuring the plugin:

.. image:: Images/FlexFormsItemsProcFunc.png
   :class: with-shadow

Select a Controller Action
==========================

.. code-block:: xml

    <switchableControllerActions>
        <TCEforms>
            <label>LLL:EXT:EXTKEY/Resources/Private/Language/Backend.xlf:settings.registration.action.title</label>
            <config>
                <type>select</type>
                <items type="array">
                    <numIndex index="0">
                        <numIndex index="0">LLL:EXT:EXTKEY/Resources/Private/Language/Backend.xlf:settings.registration.action.list</numIndex>
                        <!-- Controller -> action -->
                        <numIndex index="1">Registration->list</numIndex>
                    </numIndex>
                    <numIndex index="1">
                        <numIndex index="0">LLL:EXT:EXTKEY/Resources/Private/Language/Backend.xlf:settings.registration.action.register</numIndex>
                        <numIndex index="1">Registration->register</numIndex>
                    </numIndex>
                </items>
                <size>1</size>
            </config>
        </TCEforms>
    </switchableControllerActions>




Display Fields Conditionally (displayCond)
==========================================

Some settings may only make sense, depending on other settings.
For example in one setting you define a sorting order (by date, title etc.)
and all sort orders except "title" have additional settings. These
should only be visible, if sort order "title" was not selected.

You can define conditions using displayCond. This dynamically defines
whether a setting should be displayed when the plugin is configured.
The conditions may for example depend on one or more other settings in the FlexForm,
on database fields of current record or be defined by a user function.


.. code-block::

    <config>
        <type>select</type>
        <!-- Hide field if value of neighbour field "settings.orderBy" on same sheet is not "title" -->
        <displayCond>FIELD:settings.orderBy:!=:title</displayCond>

Again, the syntax and available fields and comparison operators is documented
in the TCA reference:

.. seealso::

   * :ref:`t3tca:columns-properties-displaycond` in TCA Reference

Steps to Perform (Editor)
=========================

After inserting a plugin, the editor can configure this plugin by switching
to the tab "Plugin" or whatever string you defined to replace this.

.. image:: Images/FlexformBackend.png
   :class: with-shadow




