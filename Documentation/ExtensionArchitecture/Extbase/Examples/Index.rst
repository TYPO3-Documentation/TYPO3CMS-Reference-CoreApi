.. include:: /Includes.rst.txt

.. index:: Extbase; Examples
.. _extbase_examples:

================
Extbase Examples
================

..  contents::
    :local:

Example extensions
==================

Tea example
-----------

The extension :t3ext:`tea`, based on Extbase and Fluid, is an
example of best practices in automated code checks,
unit/functional/acceptance testing and continuous integration.

You can also use this extension to manage your collection of delicious teas.

Blog example
------------

The extension :t3ext:`blog_extensions` tries to demonstrate all features of
Extbase that are documented in the :ref:`Extbase Reference <extbase_reference>`.

The :t3ext:`blog_extensions` demonstrates different features but does not show
you a general best practise on how to write an extension. The blog example
should not be used as base to develop your own extensions and it may not be used
to create a blog in TYPO3. If you just need a blog, have a look at
:t3ext:`blog` or combine :t3ext:`news` with a comment extension of you choice.

Real-world examples
===================

Backend user module
-------------------

In the TYPO3 Core the system extension :t3ext:`beuser` has backend modules
based on Extbase. It can therefore be used as role model on how to develop
backend modules with Extbase.

news
----

:t3ext:`news` implements a versatile news system based on Extbase & Fluid
and uses the latest technologies provided by the Core.
