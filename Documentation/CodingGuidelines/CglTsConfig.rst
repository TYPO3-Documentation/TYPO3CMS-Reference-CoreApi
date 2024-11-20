:navigation-title: TSconfig
.. include:: /Includes.rst.txt
.. index::
   pair: Coding guidelines; TSconfig
   pair: Coding guidelines; Page TSconfig
   pair: Coding guidelines; User TSconfig

.. _cgl-tsconfig:

==========================
TSconfig coding guidelines
==========================

TSconfig files use TypoScript syntax.

Directory and file names
========================

* Files have the ending :file:`.tsconfig`

The following directory names are not mandatory, but recommended:

* **TSconfig** files are located in the directory :file:`<extension>/Configuration/TsConfig`
* **Page TSconfig** files are located in the directory :file:`<extension>/Configuration/TsConfig/Page`
* **User TSconfig** files are located in the directory :file:`<extension>/Configuration/TsConfig/User`
* Configuration for :ref:`adding content elements to new content element wizard <content-element-wizard>`
  are located in the file :file:`<extension>/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig`

Format
======

* Use spaces, not tabs
* Indent with 2 spaces per indent level

See `.editorconfig <https://github.com/typo3/typo3/blob/main/.editorconfig>`__ in core.


More information
================

*   See :ref:`cgl-ide` in this manual for information about setting up your Editor / IDE to adhere to
    the coding guidelines.
*   :ref:`Using and setting TSconfig <t3tsref:typoscript-syntax-using-setting>`
