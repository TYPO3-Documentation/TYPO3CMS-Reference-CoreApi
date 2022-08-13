.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in the PHP code, for
example inside of a controller or a ViewHelper. In that case you
can use the static method
`\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extensionName)`.
This method requires the localization key as the first and the extension's name as the second
parameter. Then the corresponding text in the current language will be loaded from this extension's
:file:`locallang.xlf` file.
