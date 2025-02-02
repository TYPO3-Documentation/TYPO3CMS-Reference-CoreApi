:navigation-title: Tutorials

.. include:: /Includes.rst.txt
.. index:: Backend modules; Tutorials

.. _backend-modules-tutorials:

======================================
Tutorial - Backend Module Registration
======================================

Susanne Moog demonstrates how to register a TYPO3 backend module. The backend
module is based on a regular TYPO3 installation. Extbase is not used.

..  youtube:: v3vnn3RnQwA

In this video dependency injection is achieved via `Constructor Promotion <https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion>`__.

Additionally `Named arguments <https://www.php.net/manual/en/functions.arguments.php#functions.named-arguments>`
are used in the example.

These features are available starting with PHP 8.0. With TYPO3 v11.5 it
is still possible to use PHP 7.4. So either require PHP 8.0 and
above in your :file:`composer.json <extension-composer-json>` or use a normal constructor
for the dependency injection and refrain from using named arguments.

In part two she shows you how to create a TYPO3 backend module that looks
and behaves like other backend modules and uses the Fluid templating engine for its content.

..  youtube:: hnksXYtFgbY
