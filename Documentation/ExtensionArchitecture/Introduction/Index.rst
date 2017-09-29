.. include:: ../../Includes.txt

.. _extension-architecture-introduction:

Introduction
============

TYPO3 can be extended in nearly any direction without loosing
backwards compatibility. The Extension API provides a powerful
framework for easily adding, removing, installing and developing such
extensions to TYPO3. This is in particular powered by the Extension
Manager (EM) inside TYPO3 and the online TYPO3 Extension Repository
(TER) found at typo3.org for easy sharing of extensions.

"*Extensions*" is a general term in TYPO3 which covers many kinds of
additions to TYPO3. The main types are:

- **Plugins** which play a role on the website itself, e.g. a discussion
  board, guestbook, shop, etc. Therefore plugins are content elements, that can be placed on a page like a text element or an image.

- **Modules** are backend applications which have their own entry in the
  main menu. They require a backend login and work inside the framework
  of the backend. We might also call something a module if it exploits
  any connectivity of an existing module, that is if it simply adds
  itself to the function menu of existing modules. A module is an
  extension in the backend.

- **Services** are libraries that provide a given service through a
  clearly defined API. A service may exist both in the frontend and the
  backend. Please refer to the :ref:`TYPO3 Services Reference
  <t3services:start>` for more information about this type of extension.

- **Distributions** are fully packaged TYPO3 CMS web installations,
  complete with files, templates, extensions, etc. Distributions are
  covered :ref:`in their own chapter <distribution>`.

.. _extensions-and-core:

Extensions and the Core
-----------------------

Extensions are designed in a way so that extensions can supplement the
core seamlessly. This means that a TYPO3 system will appear as "a
whole" while actually being composed of the core application *and* a
set of extensions providing various features. This philosophy allows
TYPO3 to be developed by many individuals without loosing fine control
since each developer will have a special area (typically a system
extension) of responsibility which is effectively encapsulated.

So, at one end of the spectrum system extensions make up what is
known as "TYPO3" to the outside world. At the other end, extensions
can be entirely specific to a given project and contain only files and functionality
related to a single implementation.

