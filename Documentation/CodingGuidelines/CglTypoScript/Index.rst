.. include:: /Includes.rst.txt
.. index:: pair: Coding guidelines; TypoScript
.. _cgl-typoscript:

===================================
`TypoScript`:pn: coding guidelines
===================================

Directory and File Names
========================

* As of TYPO3 8.7, the file ending can and should be :file:`.typoscript`.

* `TypoScript`:pn: files are located in the directory :file:`<extension>/Configuration/TypoScript`.

* File name for constants in static templates: :file:`constants.typoscript`.

* File name for `TypoScript`:pn: in static templates: :file:`setup.typoscript`.

More information about the file ending:

* `TypoScript`:pn: files used to have the ending :file:`.txt`.

* Since TYPO3 7, it is also possible to use the ending :file:`.ts`. This is
  not recommended because it is also used by TypeScript.

* Therefore, you should use :file:`.typoscript` if you are using TYPO3 8.7
  and later.


.. seealso::

   Changelog: :doc:`t3core:Changelog/8.7.x/Feature-78161-IntroduceTypoScriptFileExtension`

Format
======

* Use spaces, not TABs.

* Use 2 spaces per indenting level.

More Information
================

* See :ref:`cgl-ide` in this manual for information about setting up your Editor / IDE to adhere to
  the coding guidelines.
