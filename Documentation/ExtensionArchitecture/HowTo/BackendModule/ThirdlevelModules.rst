.. include:: /Includes.rst.txt
.. index::
   Backend modules; Thirdlevel
   Backend modules; Module functions

.. _backend-modules-third-level-module:

======================================
Third-level modules / module functions
======================================

.. versionchanged:: 12.0
   Previously, module functions could be added to modules such as
   :guilabel:`Web > Info` or :guilabel:`Web > Template` via the
   now removed global :php:`TBE_MODULES_EXT` array.

   These are now registered as third-level modules with the
   backend module configuration API.

Third-level modules are registered in the
extension's :file:`Configuration/Backend/Modules.php` file, the
same way as :ref:`top-level <backend-modules-toplevel-module>`
and common :ref:`modules <backend-modules-configuration>`.

This allows administrators to define access permissions via the module
access logic for those modules individually. It also allows to influence the
position of the third-level module.

Example
=======

Registration of an additional third-level module for the
:guilabel:`Web > Template` module in the :file:`Configuration/Backend/Modules.php`
file of an extension:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   'web_ts_customts' => [
       'parent' => 'web_ts',
       'access' => 'user',
       'path' => '/module/web/typoscript/custom-ts',
       'iconIdentifier' => 'module-custom-ts',
       'labels' => [
           'title' => 'LLL:EXT:extkey/Resources/Private/Language/locallang.xlf:mod_title',
       ],
       'routes' => [
           '_default' => [
               'target' => CustomTsController::class . '::handleRequest',
           ],
       ],
       'moduleData' => [
           'someOption' => false,
       ],
   ],
