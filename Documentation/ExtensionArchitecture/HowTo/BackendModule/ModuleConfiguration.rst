.. include:: /Includes.rst.txt
.. index::
   Backend modules; configuration
   File; Configuration/Backend/Modules.php
.. _backend-modules-configuration:

============================
Backend module configuration
============================

.. versionchanged:: 12.0
   Registration of backend modules was changed with version 12. If you are
   using an older version of TYPO3 please use the version switcher on the top
   left of this document to go to the respective version.

The configuration of backend modules is placed in the
dedicated :file:`Configuration/Backend/Modules.php` configuration file.

.. note::
   The :file:`Configuration/Backend/Modules.php` configuration  files are
   read and processed when building the container. This
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
   has to be set here. Have a look into the
   :ref:`list of available toplevel modules. <backend-modules-toplevel-module>`

   Extensions can add additional parent modules, see
   :ref:`backend-modules-toplevel-module`.

.. confval:: path

   :Scope: Backend module configuration
   :type: string
   :Default: `/module/<mainModule>/<subModule>`

   Define the path to the default endpoint. The path can be anything, but
   will fallback to the known  `/module/<mainModule>/<subModule>` pattern,
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

   `@typo3/backend/page-tree/page-tree-element`
      The page tree as used in the :guilabel:`Web` module.

   `@typo3/backend/tree/file-storage-tree-container`
      The file tree as used in the :guilabel:`Filelist` module.


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
   stop the inheritance for submodules.


.. confval:: moduleData

   :Scope: Backend module configuration
   :type: array

   All properties of the :ref:`module data object <backend-Module-data-object>`
   that may be overridden by :php:`GET` / :php:`POST` parameters of the request
   get their default value defined here.

   **Example**

   .. code-block:: php
      :caption: EXT:my_extension/Configuration/Backend/Modules.php

      'moduleData' => [
          'allowedProperty' => '',
          'anotherAllowedProperty' => true,
      ],


.. confval:: aliases

   :Scope: Backend module configuration
   :type: array

   List of identifiers that are aliases to this module. Those are added as route
   aliases, which allows to use them for building links, for example with the
   :php:`UriBuilder`. Additionally, the aliases can also be used for references
   in other modules, for example to specify a modules' :php:`parent`.

   **Examples**

   Example for a new module identifier:

   .. code-block:: php
      :caption: EXT:my_extension/Configuration/Backend/Modules.php

      return [
          'workspaces_admin' => [
              'parent' => 'web',
              // ...
              // choose the previous name or an alternative name
              'aliases' => ['web_WorkspacesWorkspaces'],
          ],
      ];

   Example for a route alias identifier:

   .. code-block:: php
      :caption: EXT:my_extension/Configuration/Backend/Modules.php

      return [
          'file_editcontent' => [
              'path' => '/file/editcontent',
              'aliases' => ['file_edit'],
          ],
      ];


..  _backend-modules-api-default:

Default module configuration options (without Extbase)
------------------------------------------------------

..  versionchanged:: 12.2
    Specific routes different from `_default` can now be defined.

..  confval:: routes

    :Scope: Backend module configuration
    :type: array

    Define the routes to this module. Each route requires at least the `target`.
    The `_default` route is mandatory, except for modules which can fall back
    to a submodule. The `path` of the `_default` route is taken from the
    top-level configuration. For all other routes, the route identifier is taken
    as `path`, if not explicitly defined. Each route can define any
    controller/action pair and can restrict the allowed HTTP methods:

    ..  code-block:: php
        :caption: EXT:my_extension/Configuration/Backend/Modules.php

        'routes' => [
            '_default' => [
                'target' => MyModuleController::class . '::overview',
            ],
            'edit' => [
                'path' => '/edit-me',
                'target' => MyModuleController::class . '::edit',
            ],
            'manage' => [
                'target' => AnotherController::class . '::manage',
                'methods' => ['POST'],
            ],
        ],

    All subroutes are automatically registered in a
    :php:`\TYPO3\CMS\Core\Routing\RouteCollection`. The full syntax for route
    identifiers is `<module_identifier>.<sub_route>`, for example,
    `my_module.edit`. Therefore, using the
    :php:`\TYPO3\CMS\Backend\Routing\UriBuilder` to create a link to such a
    subroute might look like this:

    ..  code-block:: php

        \TYPO3\CMS\Backend\Routing\UriBuilder->buildUriFromRoute('my_module.edit')


..  _backend-modules-api-extbase:

Extbase module configuration options
------------------------------------

..  confval:: extensionName

    :Scope: Backend module configuration
    :type: string

    The extension name in UpperCamelCase for which the module is registered. If the
    extension key is `my_example_extension` the extension name would be
    `MyExampleExtension`.


..  confval:: controllerActions

    :Scope: Backend module configuration
    :type: array

    Define the controller action pair. The array keys are the
    controller class names and the values are the actions, which
    can either be defined as array or comma-separated list:

    ..  code-block:: php
        :caption: EXT:my_extension/Configuration/Backend/Modules.php
        :emphasize-lines: 5-10

        return [
            'web_ExtkeyExample' => [
                //...
                'path' => '/module/web/ExtkeyExample',
                'controllerActions' => [
                    ModuleController::class => [
                        'list',
                        'detail',
                    ],
                ],
            ],
        ];

    ..  versionchanged:: 12.2

    The modules define explicit routes for each controller/action combination,
    as long as the :typoscript:`enableNamespacedArgumentsForBackend` feature
    toggle is turned off (which is the default). This effectively means
    human-readable URLs, since the controller/action combinations are no longer
    defined via query parameters, but are now part of the path.

    This leads to the following URLs:

    *   :samp:`https://example.com/typo3/module/web/ExtkeyExample`
    *   :samp:`https://example.com/typo3/module/web/ExtkeyExample/MyModuleController/list`
    *   :samp:`https://example.com/typo3/module/web/ExtkeyExample/MyModuleController/detail`

    The route identifier of corresponding routes is registered with similar
    syntax as :ref:`standard backend modules <backend-modules-api-default>`:
    :php:`<module_identifier>.<controller>_<action>`. Above configuration will
    therefore register the following routes:

    *   `web_ExtkeyExample`
    *   `web_ExtkeyExample.MyModuleController_list`
    *   `web_ExtkeyExample.MyModuleController_detail`


.. _backend-modules-configuration-debug:

View registered modules
=======================

All registered modules are stored as objects in a registry. They can be viewed
in the backend in the :guilabel:`System > Configuration > Backend Modules`
module.

.. include:: /Images/ManualScreenshots/Backend/BackendModulesConfiguration.rst.txt

The :ref:`ModuleProvider <backend-module-provider-api>` API allows extension
authors to work with the registered modules.
