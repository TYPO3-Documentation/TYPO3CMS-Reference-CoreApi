.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in PHP code, for
example inside of a controller or a ViewHelper.

.. todo: Add information on ViewHelper and non-Extbase context

Localization in Extbase context
===============================

In Extbase context you can use the method
`\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extensionName)`.

This method requires the localization key as the first and the extension's
name as the second parameter. Then the corresponding text in the current
language will be loaded from this extension's :file:`locallang.xlf` file.

The function :php:`translate()` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.

.. todo: add an example from examples here
