.. include:: ../../Includes.txt

.. _flexforms:

==============
FlexForms
==============

FlexForms can be used to configure extension plugins in the backend.

You may want to configure
individual plugins differently, depending on where they are added. The
configuration set via the FlexForm mechanism applies to only the content
record it has been configured for. The FlexForms configuration for a plugin
can be changed by editors in the backend. This gives editors more control
over plugin features and what is to be rendered.

Using FlexForms you have all the features of TCA, so it is possible to
to use input fields, select lists, show options conditionally and more.

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
#. The extension can read current configuration and act according to
   the configuration.

Steps to Perform (Extension Developer)
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
                            <sheetTitle>LLL:EXT:extkey/Resources/Private/Language/Backend.xlf:settings.registration.title</sheetTitle>
                        </TCEforms>
                        <type>array</type>
                        <el>
                            <!-- Add settings here ... -->

                            <!-- Example setting: input field with name settings.timeRestriction -->
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

       $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['example_registration'] = 'pi_flexform';
       \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
           // plugin signature: <extension key> '_' <plugin name in lowercase>
           'example_registration',
           // Flexform configuration schema file
           'FILE:EXT:example/Configuration/FlexForms/Registration.xml'
       );

   .. tip::

      The plugin signature is used in the database field `tt_content.list_type`
      as well, when the tt_content record is saved. If you are confused about
      how to handle underscores and upper / lowercase, check there to see
      what your plugin signature is.

      Also look on the page :ref:`extension-naming`.

#. The settings can be read using :php:`$this->settings` in an
   Extbase controller.

   .. code-block:: php

      $includeCategories = (bool) ($this->settings['includeCategories'] ?? false);


.. todo: Add information about how to read settings apart from Extbase Controllers.


More Schema Examples
====================

The definition of the data types and parameters used complies in large
parts to the :ref:`column types defined by TCA <t3tca:columns-types>`.

The settings must be added within the <el> element in the FlexForm configuration
schema file.

.. important::

    If you wish to access a setting from your controller via
    :php:`$this->settings`, the name of the setting must begin with
    **settings** directly followed by a dot (`.`).


Select Field
------------

* vendor name is **Myvendor**
* the extension key is **example**

.. code-block:: xml

    <settings.orderBy>
        <TCEforms>
            <label>LLL:EXT:example/Resources/Private/Language/Backend.xlf:settings.registration.orderBy</label>
            <config>
                <type>select</type>
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

Credits
=======

Some of the examples were taken from the extensions
`news <https://extensions.typo3.org/extension/example/>`__ (by Georg Ringer)
and `bootstrap_package <https://extensions.typo3.org/extension/example/>`__
(by Benjamin Kott). This chapter was originally written by Sybille Peters.

Further enhancements by the TYPO3 community are welcome!

