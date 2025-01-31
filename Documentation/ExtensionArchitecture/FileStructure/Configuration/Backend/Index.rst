.. include:: /Includes.rst.txt
.. index::
   Extension development; Configuration/Backend
   Path; EXT:{extkey}/Configuration/Backend

.. _extension-configuration-backend:

===============
:file:`Backend`
===============

The folder :file:`EXT:my_extension/Configuration/Backend/` may contain
configuration that is important within the TYPO3 Backend.

All files in this directory are automatically included during the TYPO3
bootstrap.

.. _extension-configuration-backend-ajaxroutes:

..  typo3:file:: AjaxRoutes.php
    :scope: extension
    :path: /Configuration/Backend/
    :regex: /^.*\/Configuration\/Backend\/AjaxRoutes\.php/
    :shortDescription: Defines routes for backend Ajax requests

    In this file routes for Ajax requests that should be used in the backend can
    be defined.

    Read more about :ref:`Using Ajax in the backend <ajax-backend>`.

.. include:: /CodeSnippets/Manual/Extension/Configuration/BackendAjaxRoutes.rst.txt


.. _extension-configuration-backend-routes:

..  typo3:file:: Routes.php
    :scope: extension
    :path: /Configuration/Backend/
    :regex: /^.*\/Configuration\/Backend\/AjaxRoutes\.php/
    :shortDescription: Defines routes for backend controllers

    This file maps from paths used in the backend to the controller that should
    be used.

    Most backend routes defined in the TYPO3 core can be found in the following
    file, which you can use as example:

    :t3src:`backend/Configuration/Backend/Routes.php`

    Read more about :ref:`Backend routing <backend-routing>`.


.. _extension-configuration-backend-modules:

..  typo3:file:: Modules.php
    :scope: extension
    :path: /Configuration/Backend/
    :regex: /^.*\/Configuration\/Backend\/AjaxRoutes\.php/
    :shortDescription: Defines the backend module configuration

    This file is used for the
    :ref:`Backend module configuration <backend-modules-configuration>`. See that
    chapter for details.
