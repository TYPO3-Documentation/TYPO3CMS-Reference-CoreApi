.. include:: /Includes.rst.txt
.. highlight:: xml
.. index:: ! Fluid
.. _fluid:

=====
Fluid
=====

.. sidebar:: Sitepackage

   In `TYPO3`:pn:, (almost) everything is an extension. If you want to create a theme, override
   some configuration or add custom content elements you will do this in a custom `TYPO3`:pn:
   extension. A sitepackage is an extension that contains the foundation (in particular,
   the visual appearance) of a website: The configuration, necessary assets for a theme
   (images, css etc.) and a combination of `TypoScript`:pn: and `Fluid`:pn:.

You can use `Fluid`:pn: in `TYPO3`:pn: to do one of the following:

* Create a template (theme) using a combination of `TypoScript`:pn:
  :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` and `Fluid`:pn:.
  Check out the :ref:`t3sitepackage:start` which walks you through the
  creation of a sitepackage extension.
* :ref:`adding-your-own-content-elements` in addition to the already existing content
  elements `TYPO3`:pn: supplies.
* The previous point describes the lightweight components which
  are created using a combination of `TypoScript`:pn: and `Fluid`:pn:. If you need more functionality
  or flexibility in your content element, you can create a content plugin using
  a combination of `Extbase`:pn: and `Fluid`:pn:. This is explained in :ref:`t3extbasebook:start`
* Use `Fluid`:pn: to create emails using the :ref:`TYPO3 Mail API <mail-fluid-email>`.
* Use `Fluid`:pn: in :ref:`backend modules <backend-modules-template>`.

.. note::

   This page was created recently to serve as a start page for `Fluid`:pn: in `TYPO3`:pn:.
   It contains an :ref:`fluid-introduction` as subpage and further pages will
   be added later.

**Table of contents**

.. toctree::
   :titlesonly:

   Introduction
