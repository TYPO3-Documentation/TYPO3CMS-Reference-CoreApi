.. include:: /Includes.rst.txt
.. index::
   Backend modules; configuration
   File; Configuration/Backend/Modules.php
.. _backend-modules-configuration:

============================
Backend module configuration
============================

.. versionchanged:: 12.0
   Registration of backend modules was changed with Version 12. If you are
   using another version of TYPO3 please use the version switcher on the top
   left of this document to go to the respective version.

The configuration of backend modules is placed in the
dedicated :file:`Configuration/Backend/Modules.php` configuration file.

Those files are then read and processed when building the container. This
means the state is fixed and cannot be changed at runtime.

Example: register two backend modules
=====================================

You can find the following example in
`EXT:examples <https://github.com/TYPO3-Documentation/t3docs-examples>`__.

Two backend modules are being registered. The first module is based on
Extbase while the second uses a plain controller.

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   use T3docs\Examples\Controller\ModuleController;
   use T3docs\Examples\Controller\AdminModuleController;

   /**
    * Definitions for modules provided by EXT:examples
    */
   return [
       'web_examples' => [
           'parent' => 'web',
           'position' => ['after' => 'web_info'],
           'access' => 'user',
           'workspaces' => 'live',
           'path' => '/module/page/example',
           'labels' => 'LLL:EXT:examples/Resources/Private/Language/Module/locallang_mod.xlf',
           'extensionName' => 'Examples',
           'controllerActions' => [
               ModuleController::class => [
                   'flash','tree','clipboard','links','fileReference','fileReferenceCreate',
               ],
           ],
       ],
       'admin_examples' => [
           'parent' => 'system',
           'position' => ['top'],
           'access' => 'user',
           'workspaces' => 'live',
           'path' => '/module/system/example',
           'labels' => 'LLL:EXT:examples/Resources/Private/Language/AdminModule/locallang_mod.xlf',
           'extensionName' => 'Examples',
           'controllerActions' => [
               AdminModuleController::class => [
                   'index',
               ],
           ],
       ],
   ];


Module configuration options
============================

.. confval:: parent

   :Scope: Backend module configuration
   :type: string

   If the module should be a submodule, the parent identifier, for example `web`
   has to be set here. You can find a
   :ref:`list of available toplevel modules. <backend-modules-toplevel-module>`

   Extensions can add additional parent modules by defining
   :confval:`standalone` modules.

.. confval:: path

   :Scope: Backend module configuration
   :type: string
   :Default: `/module/<mainModue>/<subModule>`

   Define the path to the default endpoint. The path can be anything, but
   will fallback to the known  `/module/<mainModue>/<subModule>` pattern,
   if not set.

.. confval:: access

   :Scope: Backend module configuration
   :type: string

   Can be `user` (editor permissions), `admin`, or  `systemMaintainer`.

.. confval:: workspaces

   :Scope: Backend module configuration
   :type: string

   Can be `*` (= always), `live` or `offline`


.. confval:: position

   :Scope: Backend module configuration
   :type: array

   The module position. Allowed values are `top` and `bottom` as
   well as the key value pairs `before => <identifier>` and
   `after => <identifier>`.

.. confval:: appearance

   :Scope: Backend module configuration
   :type: array

   Allows to define additional appearance options. Currently only
   :confval:`appearance.renderInModuleMenu` is available.

.. confval:: appearance.renderInModuleMenu

   :Scope: Backend module configuration
   :type: bool

   If set to false the module is not displayed in the module menu.

.. confval:: iconIdentifier

   :Scope: Backend module configuration
   :type: string

   The module icon identifier

.. confval:: icon

   :Scope: Backend module configuration
   :type: string

   Path to a module icon (Deprecated: Use :confval:`iconIdentifier` instead)


.. confval:: labels

   :Scope: Backend module configuration
   :type: array or string

   An :php:`array` with the following keys:

   -  `title`
   -  `description`
   -  `shortDescription`

   The value can either be a static string or a locallang label reference.                                                       |

   It is also possible to define the path to a locallang file.
   The referenced file should contain the following label keys:

   -  `mlang_tabs_tab` (Used as module title)
   -  `mlang_labels_tabdescr` (Used as module description)
   -  `mlang_labels_tablabel` (Used as module short description)


.. confval:: component

   :Scope: Backend module configuration
   :type: string
   :Default: TYPO3/CMS/Backend/Module/Iframe

   The view component, responsible for rendering the module.


.. confval:: navigationComponent

   :Scope: Backend module configuration
   :type: string

   The module navigation component. The following are provided by the Core:

   `TYPO3/CMS/Backend/PageTree/PageTreeElement`
      The page tree as used in the Web module.

   `TYPO3/CMS/Backend/Tree/FileStorageTreeContainer`
      The file tree as used in the Filelist module.


.. confval:: navigationComponentId

   :Scope: Backend module configuration
   :type: string

   The module navigation component (Deprecated: Use
   :confval:`navigationComponent`)


.. confval:: inheritNavigationComponentFromMainModule

   :Scope: Backend module configuration
   :type: bool
   :Default: true

   Whether the module should use the parents navigation component.
   This option defaults to :php:`true` and can therefore be used to
   stop the inheritance for sub modules.

Default module configuration options (without Extbase)
------------------------------------------------------

.. confval:: routes

   :Scope: Backend module configuration
   :type: array

   Define the routes to this module. Each route requires a `path` and
   the `target`, except the mandatory `_default` route, which uses
   the `path` from the top-level configuration::

       routes' => [
           '_default' => [
               'target' => MyController::class . '::handleRequest',
           ],
       ],

   .. note::
      Using additional routes - next to `_default` is not yet implemented.


.. _backend-modules-api-extbase:

Extbase module configuration options
------------------------------------

.. confval:: extensionName

   :Scope: Backend module configuration
   :type: string

   The extension name in UpperCamelCase, the module is registered for. If the
   extension key is `my_example_extension` the extension name would be
   `MyExampleExtension`.


.. confval:: controllerActions

   :Scope: Backend module configuration
   :type: array

   Define the controller action pair. The array keys are the
   controller class names and the values are the actions, which
   can either be defined as array or comma-separated list:


.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   return [
       'web_examples' => [
           //...
           'controllerActions' => [
               ModuleController::class => [
                   'flash','tree','clipboard','links','fileReference','fileReferenceCreate',
               ],
           ],
       ],
   ];

.. _backend-modules-configuration-debug:

View registered modules
=======================

All registered modules are stored as objects in a registry. They can be viewed
in the backend in the :guilabel:`System > Configuration > Backend Modules`
module.

.. include:: /Images/ManualScreenshots/Backend/BackendModulesConfiguration.rst.txt

The :ref:`ModuleProvider <backend-module-provider-api>` API, allows extension
authors to work with the registered modules.
