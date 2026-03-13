..  include:: /Includes.rst.txt
..  _site-package:

============
Site package
============

A site package is a TYPO3 extension that you create to provide a theme for
your site. This is where you store files for the theme.

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

The :ref:`site package tutorial <t3sitepackage:start>` is a step by step
guide to creating a site package extension from scratch. Download the
site package that is created in the tutorial from GitHub and try it out:
https://github.com/TYPO3-Documentation/site_package/tree/main

..  _extension-sitepackage-builder:

Site package builder
====================

Use the `Site package builder <https://get.typo3.org/sitepackage>`_ to generate
a site package. It generates two types of site package.

..  _extension-sitepackage-builder-bootstrap:

Bootstrap package
-----------------

The Bootstrap Package creates a site package that depends on the :composer:`bk2k/bootstrap-package`
extension.

It comes with a frontend template that can be configured to use
your logo, colors, etc, and comes with a large number of content elements.

It is a good option if you want to create a TYPO3 website quickly with a standard design.

To see the bootstrap package in action, install the
:composer:`typo3/cms-introduction` package (which contains the
bootstrap-package). The resulting site contains a page tree with example data.

Or just go to https://www.bootstrap-package.com/.

..  _extension-sitepackage-builder-minimal:

Minimal site package (Fluid Styled Content)
-------------------------------------------

The Fluid Styled Content package is a minimal site package that provides boiler
plate code to use with your own HTML. No styles are included.

You can use the :composer:`t3docs/site-package-data` extension to create a page tree
and load some example data.
