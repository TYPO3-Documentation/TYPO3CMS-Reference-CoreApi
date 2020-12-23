.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _system-overview:
.. _overview:

System Overview
===============

For most people TYPO3 is equivalent to a CMS providing a backend for
management of the content and a frontend engine for website display.
However the `TYPO3 Core`:pn: is natively designed to be a general purpose
framework for management of database content. The `TYPO3 Core`:pn:
delivers a set of principles for storage of this content, user access
management, editing of the content, uploading and managing files, etc.
These principles are expressed as an API (Application
Programming Interface) for use in *extensions* which ultimately
add most of the real functionality.

.. figure:: ../Images/Typo3CmsStructure.png
   :alt: Main `TYPO3 Core`:pn: architecture


So the *core* is the skeleton and  *extensions* are the muscles,
fibers and skin making a full bodied CMS. In this document I cut to
the bone and provide a detailed look at the `TYPO3 Core`:pn: including
the API available to the outside. This is supposed to be the final
technical reference apart from source code itself which
is - of course - the ultimate documentation.


.. _installation:

A basic installation
====================

To follow this document, it might help to have a totally trimmed down installation
of `TYPO3 CMS`:pn: with *only* the `Core`:pn: and the required system extensions at hand.

The installation process is covered in the :ref:`Installation and Upgrade Guide <t3install:start>`.
You should perform the basic installation steps and not install any distribution.
This will give you the "lightest" possible version of `TYPO3 CMS`:pn:.

Log into your basic installation and move to the **ADMIN TOOLS > Extensions**
module. You will see all extensions which are loaded by default.
Required extensions are not only loaded by default, they have no
"Activate/Deactivate" button, too.

.. figure:: ../Images/ExtensionsMinimalList.png
   :alt: The `Extension Manager`:pn: with a bare bones installation


The most important thing to note for now is that **everything** is an
extension in `TYPO3 CMS`:pn:. Even the most basic functions are packaged in a
system extension called "core".
