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
    :hidden:

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

You can use the `site package builder <https://get.typo3.org/sitepackage>`_ to
generate a site package for you.

..  _extension-sitepackage-builder-bootstrap:

Bootstrap package
-----------------

Creates a site package depending extension :composer:`bk2k/bootstrap-package`.

The site package comes with a frontend template that can be configured in
multiple ways to use your own logo, colors etc. It also comes with a large
number of predefined content elements.

Use this options if you want to create a web site with TYPO3 quickly and with
a standardized design.

You can use the extension :composer:`typo3/cms-introduction` to create a page
tree with some example data demonstrating the capabilities of this package.

At https://www.bootstrap-package.com/ the features of
:composer:`bk2k/bootstrap-package` are demonstrated.

..  _extension-sitepackage-builder-minimal:

Minimal site package (Fluid Styled Content)
-------------------------------------------

A minimal site package without styles that you can use as boiler plate to create
a site package based on a custom HTML structure.

You can use extension :composer:`t3docs/site-package-data` to create a page tree
and load some example data into your installation.
