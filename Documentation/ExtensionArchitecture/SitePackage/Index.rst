..  include:: /Includes.rst.txt
..  _site-package:

============
Site package
============

A site package is a custom TYPO3 extension that contains files regarding the
theme of a site.

..  toctree::
    :caption: Subpages
    :glob:
    :titlesonly:

    *

..  contents::
    :caption: Table of content

..  _site-package-tutorial:

Site package tutorial
=====================

The :ref:`site package tutorial <t3sitepackage:start>` teaches you step by step
how to create a custom site package from scratch. You can download the
example site package created in this tutorial from GitHub and try it out:
https://github.com/TYPO3-Documentation/site_package/tree/main

..  _extension-sitepackage-builder:

Site package builder
====================

You can use the https://www.sitepackagebuilder.com/ to generate a site package
for you. This is a quick way to generate a custom site package based on
:composer:`typo3/cms-fluid-styled-content` or :composer:`bk2k/bootstrap-package`.

There are however some down sides:

*   At the time of writing it is impossible to create a site package for TYPO3 v13.
*   A large number of unnecessary, mostly empty files are being generated.
*   Depending on your prior knowledge you use code that you might not fully understand.
