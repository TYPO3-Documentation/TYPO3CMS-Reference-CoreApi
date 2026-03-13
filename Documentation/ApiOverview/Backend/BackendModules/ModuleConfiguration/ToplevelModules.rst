:navigation-title: Toplevel

.. include:: /Includes.rst.txt
.. index:: Backend modules; Toplevel

.. _backend-modules-toplevel-module:

================
Toplevel modules
================

..  versionchanged:: 14.0
    The top-level modules have been renamed and the identifiers adapted
	<https://docs.typo3.org/permalink/changelog:feature-107628-1729026000>`_.

The following toplevel modules are provided by the Core:

`content`: Content
   All modules requiring a page tree by default. These modules are mostly used
   to manage content that should be displayed in the frontend.

`site`: Sites
   Settings for the complete site such as redirects and site settings.

`media`: Media
   All modules requiring a file system tree such as modules dealing with file
   metadata, uploading etc.

`admin`: Administration
   By convention, modules in this toplevel section should only be
   accessible by admins. Therefore the configuration array of a module
   displayed here should always have the following key-value pair:
   :php:`'access' => 'admin'`.

`system`: System
   By convention modules in this toplevel section should only be
   available for admins with system maintainer rights. Therefore the
   configuration array of a module displayed here should always have the
   following key-value pair: :php:`'access' => 'systemMaintainer'`.

   In this toplevel section modules that deal with installing and updating the Core
   and extensions are available. System-wide settings are also found here.

   In this toplevel section modules are situated that deal with backend user
   rights or might reveal security relevant data.

Register a custom toplevel module
==================================

Toplevel modules like :guilabel:`Content` or :guilabel:`Media` are registered in the
:file:`Configuration/Backend/Modules.php`. All toplevel modules provided by
the Core are registered in EXT:core so you can look at
:file:`typo3/sysext/core/Configuration/Backend/Modules.php` for reference.

Example:
--------

Register a new toplevel module in your extension:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   return [
       'myextension' => [
           'labels' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_mod_web.xlf',
           'iconIdentifier' => 'modulegroup-myextension',
           'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
       ]
   ];
