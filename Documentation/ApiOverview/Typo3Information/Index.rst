:navigation-title: TYPO3 information
.. include:: /Includes.rst.txt

.. _typo3Information:

===================================
Global meta information about TYPO3
===================================


General information
===================

The PHP class :php:`TYPO3\CMS\Core\Information\Typo3Information` provides an API for general
information, links and copyright information about TYPO3.

The following methods are available:

- :php:`getCopyrightYear()` will return a string with the current copyright years (for example "1998-2020")
- :php:`getHtmlGeneratorTagContent()` will return the backend meta generator tag with copyright information
- :php:`getInlineHeaderComment()` will return the TYPO3 header comment rendered in all frontend requests ("This website is powered by TYPO3...")
- :php:`getCopyrightNotice()` will return the TYPO3 copyright notice

.. warning::

   DO NOT prevent the copyright notice from being shown in ANY WAY.
   According to the GPL license an interactive application must show such a notice on start-up
   ('If the program is interactive, make it output a short notice... ' )
   Therefore preventing this notice from being properly shown is a violation of the license, regardless of whether
   you remove it or use a stylesheet to obstruct the display.

Version Information
===================

PHP class :php:`TYPO3\CMS\Core\Information\Typo3Version` provides an API for
accessing information about the currently used TYPO3 version.

- :php:`getVersion()` will return the full TYPO3 version (for example `10.4.3`)
- :php:`getBranch()` will return the current branch (for example `10.4`)
- :php:`getMajorVersion()` will return the major version number (for example `10`)
- :php:`__toString()` will return the result of :php:`getVersion()`
