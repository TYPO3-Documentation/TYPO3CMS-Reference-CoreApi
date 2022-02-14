.. include:: /Includes.rst.txt
.. index:: Backend modules; API
.. _backend-modules-api:

===================
Backend module API
===================

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

    <?php

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
           'access' => 'admin',
           'workspaces' => 'live',
           'path' => '/module/system/example',
           'labels' => 'LLL:EXT:examples/Resources/Private/Language/AdminModule/locallang_mod.xlf',
           'extensionName' => 'Examples',
           'routes' => [
               '_default' => [
                   'target' => AdminModuleController::class . '::handleRequest',
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
   has to be set here.

   The following parent modules are provided by the Core:

   *  `web`: Web
   *  `site`: Site Management
   *  `file`: File
   *  `tools`: Admin Tools (only available for system maintainers)
   *  `system`: System (only available for admins)

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
               'target' => Controller::class . '::handleRequest',
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
   can either be defined as array or comma-separated list::

      'controllerActions' => [
          Controller::class => [
              'aAction', 'anotherAction',
          ],
      ],

The BeforeModuleCreationEvent
=============================

The PSR-14 :ref:`BeforeModuleCreationEvent` allows extension authors
to manipulate the module configuration, before it is used to create and
register the module.

ModuleProvider API
==================

the :php:`ModuleProvider` API, allows extension authors to work with the
registered modules.

This API is the central point to retrieve modules, since it
automatically performs necessary access checks and prepares specific structures,
for example for the use in menus.

ModuleProvider API methods
--------------------------

+---------------------------+--------------------------------------+----------------------------------------------------------+
| Method                    | Parameters                           | Description                                              |
+===========================+======================================+==========================================================+
| isModuleRegistered()      | :php:`$identifier`                   | Checks whether a module is registered for the given      |
|                           |                                      | identifier. Does NOT perform any access check!           |
+---------------------------+--------------------------------------+----------------------------------------------------------+
| getModule()               | :php:`$identifier`                   | Returns a module for the given identifier. In case a     |
|                           | :php:`$user`                         | user is given,also access checks are performed.          |
|                           | :php:`$respectWorkspaceRestrictions` | Additionally, one can define whether workspace           |
|                           |                                      | restrictions should be respected.                        |
+---------------------------+--------------------------------------+----------------------------------------------------------+
| getModules()              | :php:`$user`                         | Returns all modules either grouped by main modules       |
|                           | :php:`$respectWorkspaceRestrictions` | or flat. In case a user is given, also access checks     |
|                           | :php:`$grouped`                      | are performed. Additionally, one can define whether      |
|                           |                                      | workspace restrictions should be respected.              |
+---------------------------+--------------------------------------+----------------------------------------------------------+
| getModuleForMenu()        | :php:`$identifier`                   | Returns the requested main module prepared for           |
|                           | :php:`$user`                         | menu generation or similar structured output (nested),   |
|                           | :php:`$respectWorkspaceRestrictions` | if it exists and the user has necessary permissions.     |
|                           |                                      | Additionally, one can define whether workspace           |
|                           |                                      | restrictions should be respected.                        |
+---------------------------+--------------------------------------+----------------------------------------------------------+
| getModulesForModuleMenu() | :php:`$user`                         | Returns all allowed modules for the current user,        |
|                           | :php:`$respectWorkspaceRestrictions` | prepared for module menu generation or similar           |
|                           |                                      | structured output (nested). Additionally, one can define |
|                           |                                      | whether workspace restrictions should be respected.      |
+---------------------------+--------------------------------------+----------------------------------------------------------+
| accessGranted()           | :php:`$identifier`                   | Check access of a module for a given user. Additionally, |
|                           |                                      | one can define whether workspace restrictions should     |
|                           |                                      | be respected.                                            |
+---------------------------+--------------------------------------+----------------------------------------------------------+

ModuleInterface
===============

Instead of a global array structure, the registered modules are stored as
objects in a registry. The module objects do all implement the :php:`ModuleInterface`.
This allows a well-defined OOP-based approach to work with registered models.

The :php:`ModuleInterface` basically provides getters for the options,
defined in the module registration and additionally provides methods for
relation handling (main modules and sub modules).

+---------------------------+--------------------------+-----------------------------------------------+
| Method                    | Return type              | Description                                   |
+===========================+==========================+===============================================+
| getIdentifier()           | :php:`string`            | Returns the internal name of the module,      |
|                           |                          | used for referencing in permissions etc.      |
+---------------------------+--------------------------+-----------------------------------------------+
| getPath()                 | :php:`string`            | Returns the module main path                  |
+---------------------------+--------------------------+-----------------------------------------------+
| getIconIdentifier()       | :php:`$string`           | Returns the module icon identifier            |
+---------------------------+--------------------------+-----------------------------------------------+
| getTitle()                | :php:`string`            | Returns the module title (see:                |
|                           |                          | `mlang_tabs_tab`).                            |
+---------------------------+--------------------------+-----------------------------------------------+
| getDescription()          | :php:`string`            | Returns the module description (see:          |
|                           |                          | `mlang_labels_tabdescr`).                     |
+---------------------------+--------------------------+-----------------------------------------------+
| getShortDescription()     | :php:`string`            | Returns the module short description (see:    |
|                           |                          | `mlang_labels_tablabel`).                     |
+---------------------------+--------------------------+-----------------------------------------------+
| isStandalone()            | :php:`bool`              | Returns, whether the module is standalone     |
|                           |                          | (main module without sub modules).            |
+---------------------------+--------------------------+-----------------------------------------------+
| getComponent()            | :php:`string`            | Returns the view component responsible for    |
|                           |                          | rendering the module (iFrame or name of the   |
|                           |                          | web component).                               |
+---------------------------+--------------------------+-----------------------------------------------+
| getNavigationComponent()  | :php:`string`            | Returns the web component to be rendering the |
|                           |                          | navigation area.                              |
+---------------------------+--------------------------+-----------------------------------------------+
| getPosition()             | :php:`array`             | Returns the position of the module, such as   |
|                           |                          | `top` or `bottom` or `after => anotherModule` |
|                           |                          | or `before => anotherModule`.                 |
+---------------------------+--------------------------+-----------------------------------------------+
| getAppearance()           | :php:`array`             | Returns a modules' appearance options, e.g.   |
|                           |                          | used for module menu.                         |
+---------------------------+--------------------------+-----------------------------------------------+
| getAccess()               | :php:`string`            | Returns defined access level, can be `user`,  |
|                           |                          | `admin` or `systemMaintainer`.                |
+---------------------------+--------------------------+-----------------------------------------------+
| getWorkspaceAccess()      | :php:`string`            | Returns defined workspace access, can be `*`  |
|                           |                          | (all), `live` or `offline`.                   |
+---------------------------+--------------------------+-----------------------------------------------+
| getParentIdentifier()     | :php:`string`            | In case this is a sub module, returns the     |
|                           |                          | parent module identifier.                     |
+---------------------------+--------------------------+-----------------------------------------------+
| getParentModule()         | :php:`?ModuleInterface`  | In case this is a sub module, returns the     |
|                           |                          | parent module.                                |
+---------------------------+--------------------------+-----------------------------------------------+
| hasParentModule()         | :php:`bool`              | Returns whether the module has a parent       |
|                           |                          | module defined (is a sub module).             |
+---------------------------+--------------------------+-----------------------------------------------+
| hasSubModule($identifier) | :php:`bool`              | Returns whether the module has a specific     |
|                           |                          | sub module assigned.                          |
+---------------------------+--------------------------+-----------------------------------------------+
| hasSubModules()           | :php:`bool`              | Returns whether the module has a sub modules  |
|                           |                          | assigned.                                     |
+---------------------------+--------------------------+-----------------------------------------------+
| getSubModule($identifier) | :php:`?ModuleInterface`  | If set, returns the requested sub module.     |
+---------------------------+--------------------------+-----------------------------------------------+
| getSubModules()           | :php:`ModuleInterface[]` | Returns all assigned sub modules.             |
+---------------------------+--------------------------+-----------------------------------------------+
| getDefaultRouteOptions()  | :php:`array`             | Returns options, to be added to the main      |
|                           |                          | module route. Usually `module`, `moduleName`  |
|                           |                          | and `access`.                                 |
+---------------------------+--------------------------+-----------------------------------------------+
