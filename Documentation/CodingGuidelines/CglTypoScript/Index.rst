.. include:: ../../Includes.txt

.. _cgl-typoscript:

============================
TypoScript Coding Guidelines
============================

Directory and filenames
=======================

* As of TYPO3 8.7, the file ending can and should be :file:`.typoscript`
* TypoScript files are located in the directory :file:`<extension>/Configuration/TypoScript`.
* filename for constants in static templates: :file:`constants.typoscript`
* filename for TypoScript in static templates: :file:`setup.typoscript`

More information about the file ending:

* TypoScript files used to have the ending :file:`.txt`.
* Since TYPO3 7, it is also possible to use the ending :file:`.ts`. This is
  not recommended because it is also used by TypeScript.
* Therefore, you should use :file:`.typoscript` if you are using TYPO3 8.7
  and later.


.. seealso::

   `Feature #78161 Introduce .typoscript file extension
   <https://docs.typo3.org/typo3cms/extensions/core/Changelog/8.7.x/Feature-78161-IntroduceTypoScriptFileExtension.html>`__

Format
======

* use spaces, not TABs
* use 2 spaces per indenting level