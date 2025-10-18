:navigation-title: 3rd level

.. include:: /Includes.rst.txt
.. index::
   Backend modules; Thirdlevel
   Backend modules; Module functions

.. _backend-modules-third-level-module:

======================================
Third-level modules / module functions
======================================

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
:guilabel:`Content > Info` module in the :file:`Configuration/Backend/Modules.php`
file of an extension:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   'web_ts_customts' => [
       'parent' => 'web_info',
       'access' => 'user',
       'path' => '/module/web/typoscript/custom-info',
       'iconIdentifier' => 'module-custom-info',
       'labels' => [
           'title' => 'LLL:EXT:extkey/Resources/Private/Language/locallang.xlf:mod_title',
       ],
       'routes' => [
           '_default' => [
               'target' => CustomInfoController::class . '::handleRequest',
           ],
       ],
       'moduleData' => [
           'someOption' => false,
       ],
   ],
