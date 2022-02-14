.. include:: /Includes.rst.txt
.. index:: Backend modules; Toplevel

.. _backend-modules-toplevel-module:

==========================
Register a toplevel module
==========================

This page describes how to register a toplevel menu.

Toplevel modules like "Web" or "File" are registered in the
:file:`Configuration/Backend/Modules.php`. All toplevel modules provided by
the Core are registered in EXT:core so you can look at
:file:`typo3/sysext/core/Configuration/Backend/Modules.php` for reference.

Example:
========

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   return [
       'myextension' => [
           'labels' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_mod_web.xlf',
           'iconIdentifier' => 'modulegroup-myextension',
           'navigationComponent' => 'TYPO3/CMS/Backend/PageTree/PageTreeElement',
       ]
   ];
