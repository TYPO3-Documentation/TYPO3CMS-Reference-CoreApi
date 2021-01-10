.. include:: /Includes.rst.txt
.. index::
   ! File; EXT:{extkey}/ext_conf_template.txt
   Extension development; Extension configuration
.. _extension-options:
.. _extension-configuration:

===============================================
Extension configuration (ext_conf_template.txt)
===============================================

*-- optional*

In the :file:`ext_conf_template.txt` file configuration options
for an extension can be defined. They will be accessible in the TYPO3 backend
from Settings module.

.. _extension-options-syntax:

Syntax
======

There's a specific syntax to declare these options properly, which is
similar to the one used for TypoScript constants (see "Declaring
constants for the Constant editor" in
:ref:`Constants section in TypoScript Reference <t3tsref:typoscript-syntax-constant-editor>`.
This syntax applies to the comment line that should be placed just before the constant.
Consider the following example (taken from system extension "backend"):

.. code-block:: typoscript

   # cat=Login; type=string; label=Logo: If set, this logo will be used instead of...
   loginLogo =

First a category (cat) is defined ("Login"). Then a type is given ("string") and finally a label, which
is itself split (on the colon ":") into a title and a description. The Label should actually be a localized string, like this:

.. code-block:: typoscript

   # cat=Login; type=string; label=LLL:EXT:my_extension_key/Resources/Private/Language/locallang_be.xlf:loginLogo
   loginLogo =

The above example will be rendered like this in the Settings module:

.. figure:: ../Images/ExtensionConfigurationOptions.png
   :alt: Configuration screen for the backend extension

The configuration tab displays all options from a single category. A
selector is available to switch between categories. Inside an option
screen, options are grouped by subcategory. At the bottom of the
screenshot, the label – split between header and description – is
visible. Then comes the field itself, in this case an input, because
the option's type is "string".

.. _extension-options-available-option-types:

Available option types
======================

============= ==========================
Option type   Description
============= ==========================
boolean       checkbox
color         colorpicker
int           integer value
int+          positive integer value
integer       integer value
offset        offset
options       option select
small         small text field
string        text field
user          user function
wrap          wrap field
============= ==========================

Option select can be used as follows:

.. code-block:: typoscript

   # cat=basic/enable/050; type=options[label1=value1,label2]; label=MyLabel
   myVariable = 1

Where user functions have to be written the following way:

.. code-block:: typoscript

   # cat=basic/enable/050; type=user[Vendor\MyExtensionKey\ViewHelpers\MyConfigurationClass->render]; label=MyLabel
   myVariable = 1


.. _extension-options-accessing-saved-options:
.. _extension-options-api:

Accessing saved options
=======================

When saved in the Settings module, the configuration will be kept in the :file:`LocalConfiguration.php`
file and is available as array :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['my_extension_key']`.

To retrieve the configuration use the API provided by the :php:`\TYPO3\CMS\Core\Configuration\ExtensionConfiguration` class::

   $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ExtensionConfiguration::class)
      ->get('my_extension_key');

This will return the whole configuration as an array.

To directly fetch specific values like :ts:`myVariable` from the example above::

   $temporaryDirectory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ExtensionConfiguration::class)
      ->get('my_extension_key', 'myVariable');


.. _extension-options-nested-structure:

Nested structure
================

You can also define nested options using the TypoScript notation:

.. code-block:: typoscript

   directories {
      # cat=basic/enable; type=string; label=Path to the temporary directory
      tmp =
      # cat=basic/enable; type=string; label=Path to the cache directory
      cache =
   }

This will result in a multidimensional array::

   $extensionConfiguration['directories']['tmp']
   $extensionConfiguration['directories']['cache']
