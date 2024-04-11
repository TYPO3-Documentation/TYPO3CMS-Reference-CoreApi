.. include:: /Includes.rst.txt
.. index:: pair: Coding guidelines; TypoScript
.. _cgl-typoscript:

============================
TypoScript coding guidelines
============================

Directory and file names
========================

* The file extension **must** be :file:`.typoscript`.

* TypoScript files are located in the directory :file:`<extension>/Configuration/TypoScript`.

* File name for constants in static templates: :file:`constants.typoscript`.

* File name for TypoScript in static templates: :file:`setup.typoscript`.

..  attention::
    Support for other TypoScript file extensions, such as :file:`.txt` or :file:`.ts`, has been removed in TYPO3 v12.

.. seealso::

   Changelog: :doc:`ext_core:Changelog/12.0/Breaking-97816-TypoScriptSyntaxChanges`

   Changelog: :doc:`ext_core:Changelog/8.7.x/Feature-78161-IntroduceTypoScriptFileExtension`

Format
======

* Use spaces, not TABs.

* Use 2 spaces per indenting level.

More information
================

* See :ref:`cgl-ide` in this manual for information about setting up your Editor / IDE to adhere to
  the coding guidelines.
