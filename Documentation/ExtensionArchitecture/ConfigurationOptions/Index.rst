.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-options:

Configuration options
^^^^^^^^^^^^^^^^^^^^^

In the :code:`ext_conf_template.txt` file configuration options
for an extension can be defined. They will be accessible in the TYPO3 BE
from the Extension Manager.

There's a specific syntax to declare these options properly, which is
similar to the one used for TypoScript constants (see "Declaring
constants for the Constant editor" in :ref:`"TypoScript Syntax and In-depth
Study" <t3tssyntax:constant-editor>`). This syntax applies to the comment 
line that should be placed just before the constant. Consider the following
example (taken from system extension "rsaauth")::

   # cat=basic/enable; type=string; label=Path to the temporary directory:This directory will contain...
   temporaryDirectory =

First a category (cat) is defined ("basic") with the subcategory
"enable". Then a type is given ("string") and finally a label, which
is itself split (on the colon ":") into a title and a description
(this should actually be a localized string). The
above example will be rendered like this in the EM:

.. figure:: ../../Images/ExtensionConfigurationOptions.png
   :alt: Configuration screen for the rsaauth extension

The configuration tab displays all options from a single category. A
selector is available to switch between categories. Inside an option
screen, options are grouped by subcategory. At the bottom of the
screenshot, the label – split between header and description – is
visible. Then comes the field itself, in this case an input, because
the option's type is "string".

Once you saved the configuration in the ExtensionManager, it will be stored in
:code:`$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']`
as a serialized array.

To fetch the value of :code:`temporaryDirectory` from the example above,
you could simply use::

   $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']);
   $temporaryDirectory = $extensionConfiguration['temporaryDirectory'];

You can also define nested options using the TypoScript notation::

   directories {
      # cat=basic/enable; type=string; label=Path to the temporary directory
      tmp = 
      # cat=basic/enable; type=string; label=Path to the cache directory
      cache = 
   }

This will result in  a multidimensional array::

   $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['your_extension_key']);
   $extensionConfiguration['directories']['tmp']
   $extensionConfiguration['directories']['cache']
