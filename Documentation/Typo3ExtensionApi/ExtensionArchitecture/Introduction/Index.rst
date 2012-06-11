

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Introduction
^^^^^^^^^^^^

TYPO3 can be extended in nearly any direction without loosing
backwards compatibility. The Extension API provides a powerful
framework for easily adding, removing, installing and developing such
extensions to TYPO3. This is in particular powered by the Extension
Manager (EM) inside TYPO3 and the online TYPO3 Extension Repository
(TER) found at typo3.org for easy sharing of extensions.

“ *Extensions* ” is a general term in TYPO3 which covers many kinds of
additions to TYPO3. The main types are:

- **Plugins** which play a role on the website itself, e.g. a discussion
  board, guestbook, shop, etc. It is normally enclosed in a PHP class
  and invoked through a USER or USER\_INT cObject from TypoScript. A
  plugin is an extension in the frontend.

- **Modules** are backend applications which have their own entry in the
  main menu. They require a backend login and work inside the framework
  of the backend. We might also call something a module if it exploits
  any connectivity of an existing module, that is if it simply adds
  itself to the function menu of existing modules. A module is an
  extension in the backend.

- **Services** are libraries that provide a given service through a
  clearly defined API. A service may exist both in the frontend and the
  backend. Please refer to the “TYPO3 Services” manual
  (doc\_core\_services) for more information about this type of
  extension.


Extensions and the Core
"""""""""""""""""""""""

Extensions are designed in a way so that extensions can supplement the
core seamlessly. This means that a TYPO3 system will appear as "a
whole" while actually being composed of the core application  *and* a
set of extensions providing various features. This philosophy allows
TYPO3 to be developed by many individuals without loosing fine control
since each developer will have a special area (typically a system
extension) of responsibility which is effectively encapsulated.

So, in one end of the spectrum system extensions makes up what is
known as "TYPO3" to the outside world. In the other end, extensions
can be 100% project specific and carry only files and functionality
related to a single implementation.

