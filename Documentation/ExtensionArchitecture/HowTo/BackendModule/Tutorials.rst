.. include:: /Includes.rst.txt
.. index:: Backend modules; Tutorials

.. _backend-modules-tutorials:

=========
Tutorials
=========

Tutorial - Backend Module Registration - Part 1
===============================================

Susanne Moog demonstrates how to register a TYPO3 backend module. The backend
module is based on plain TYPO3. Extbase is not used.

..  youtube:: v3vnn3RnQwA

..  attention::
    In the video dependency injection is achieved via
    `Constructor Promotion <https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion>`__.

    Additionally `Named arguments <https://www.php.net/manual/en/functions.arguments.php#functions.named-arguments>`
    are used in the example.

    These features are available starting with PHP 8.0. In TYPO3 v11.5 it
    is still possible to use PHP 7.4. So either require php 8.0 and
    above in your :file:`composer.json` or use the a normal constructor
    for the dependency injection and refrain from using named arguments.

Tutorial - Backend Module Registration - Part 2
===============================================

Susanne Moog shows you how to make a TYPO3 Backend Module look like the
rest of TYPO3 and how to use Fluid for its content.

..  youtube:: hnksXYtFgbY
