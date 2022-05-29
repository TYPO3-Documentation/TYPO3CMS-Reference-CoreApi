.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/Backend
   Path; EXT:{extkey}/Configuration/Backend

.. _extension-configuration-backend:

================================
:file:`Backend`
================================

The folder :file:`EXT:my_extension/Configuration/Backend/` may contain
configuration that is important within the TYPO3 Backend.

All files in this directory are automatically included during the TYPO3
bootstrap.

:file:`AjaxRoutes.php`
================================

Complete path: :file:`EXT:my_extension/Configuration/Backend/AjaxRoutes.php`

In this file routes for AJAX requests that should be used in the backend can
be defined.

Read more about :ref:`Using AJAX in the backend <ajax-backend>`.

.. include:: /CodeSnippets/Manual/Extension/Configuration/BackendAjaxRoutes.rst.txt

:file:`Routes.php`
================================

Complete path: :file:`EXT:my_extension/Configuration/Backend/Routes.php`

This file maps from paths used in the backend to the controller that should
be used.

Most backend routes defined in the TYPO3 core can be found in the following
file, which you can use as example:

`typo3/sysext/backend/Configuration/Backend/Routes.php <https://github.com/typo3/typo3/blob/main/typo3/sysext/backend/Configuration/Backend/Routes.php>`__

Read more about :ref:`Backend routing <backend-routing>`.
