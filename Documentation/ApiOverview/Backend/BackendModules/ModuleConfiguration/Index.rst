:navigation-title: Modules.php

..  include:: /Includes.rst.txt
..  _backend-module-configuration:
..  _backend-modules-configuration:

==========================================
Modules.php - Backend module configuration
==========================================

The configuration of backend modules is placed in the
dedicated :file:`Configuration/Backend/Modules.php` configuration file.

See also the :ref:`Backend module configuration
examples <backend-modules-configuration-examples>`.

..  note::
    The :file:`Configuration/Backend/Modules.php` configuration files are
    read and processed when building the container. This
    means the state is fixed and cannot be changed at runtime.

..  toctree::
    :glob:

    *

..  contents:: Table of contents
    :depth: 2

..  _backend-modules-configuration-options:

Module configuration options
============================

..  confval-menu::
    :name: backend-module
    :display: table
    :type:

    ..  confval:: parent
        :name: backend-module-parent
        :type: string

        If the module should be a submodule, the parent identifier, for example `web`
        has to be set here. Have a look into the
        :ref:`list of available toplevel modules. <backend-modules-toplevel-module>`

        Extensions can add additional parent modules, see
        :ref:`backend-modules-toplevel-module`.

    ..  confval:: path
        :name: backend-module-path
        :type: string
        :Default: `/module/<mainModule>/<subModule>`

        Define the path to the default endpoint. The path can be anything, but
        will fallback to the known  `/module/<mainModule>/<subModule>` pattern,
        if not set.

    ..  confval:: access
        :name: backend-module-access
        :type: string

        Can be `user` (editor permissions), `admin`, or  `systemMaintainer`.

    ..  confval:: workspaces
        :name: backend-module-workspaces
        :type: string

        Can be `*` (= always), `live` or `offline`. If not set, the value of the
        parent module - if any - is used.

    ..  confval:: position
        :name: backend-module-position
        :type: array

        The module position. Allowed values are `top` and `bottom` as
        well as the key value pairs `before => <identifier>` and
        `after => <identifier>`.

    ..  confval:: appearance
        :name: backend-module-appearance
        :type: array

        Allows to define additional appearance options. Currently only
        :confval:`backend-module-appearance-renderInModuleMenu` is available.

    ..  confval:: appearance.renderInModuleMenu
        :name: backend-module-appearance-renderInModuleMenu
        :type: bool

        If set to false the module is not displayed in the module menu.

    ..  confval:: iconIdentifier
        :name: backend-module-iconIdentifier
        :type: string

        The module :ref:`icon identifier <t3coreapi:icon>`

    ..  confval:: icon
        :name: backend-module-icon
        :type: string

        Path to a module icon (Deprecated: Use
        :confval:`iconIdentifier <backend-module-iconIdentifier>`
        instead)

    ..  confval:: labels
        :name: backend-module-labels
        :type: array of strings or string

        An :php:`array` with the following keys:

        *   `title`
        *   `description`
        *   `shortDescription`

        The value of each array entry can either be a `string` containing the static text, or a locallang label reference.

        Alternatively define the path of a :ref:`locallang file reference <t3coreapi:xliff-files>`.
        A referenced file should contain the following label keys:

        *   `mlang_tabs_tab` (used as module title)
        *   `mlang_labels_tabdescr` (used as module description)
        *   `mlang_labels_tablabel` (used as module short description)

    ..  confval:: component
        :name: backend-module-component
        :type: string
        :Default: TYPO3/CMS/Backend/Module/Iframe

        The view component, responsible for rendering the module.

    ..  confval:: navigationComponent
        :name: backend-module-navigationComponent
        :type: string

        ..  versionchanged:: 14.0
            The :js:`@typo3/backend/page-tree/page-tree-element`, which was deprecated in TYPO3 v13.1,
            has been removed in favor of :js:`@typo3/backend/tree/page-tree-element`.

        The module navigation component. The following are provided by the Core:

        :js:`@typo3/backend/tree/page-tree-element`
            The page tree as used in the :guilabel:`Content` module.

        :js:`@typo3/backend/tree/file-storage-tree-container`
            The file tree as used in the :guilabel:`Filelist` module.

        ..  rubric:: Migration

        ..  code-block:: diff

            'mymodule' => [
                'parent' => 'content',
                ...
            -   'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
            +   'navigationComponent' => '@typo3/backend/tree/page-tree-element',
            ],

    ..  confval:: navigationComponentId
        :name: backend-module-navigationComponentId
        :type: string

        The module navigation component (Deprecated: Use
        :confval:`navigationComponent <backend-module-navigationComponent>`)

    ..  confval:: inheritNavigationComponentFromMainModule
        :name: backend-module-inheritNavigationComponentFromMainModule
        :type: bool
        :Default: true

        Whether the module should use the parents navigation component.
        This option defaults to :php:`true` and can therefore be used to
        stop the inheritance for submodules.

    ..  confval:: moduleData
        :name: backend-module-moduleData
        :type: array

        All properties of the :ref:`module data object <backend-Module-data-object>`
        that may be overridden by :php:`GET` / :php:`POST` parameters of the request
        get their default value defined here.

        **Example**

        ..  literalinclude:: _ModuleConfiguration/_ModuleData.php
            :language: php
            :caption: Excerpt of EXT:my_extension/Configuration/Backend/Modules.php

    ..  confval:: aliases
        :name: backend-module-aliases
        :type: array

        List of identifiers that are aliases to this module. Those are added as route
        aliases, which allows to use them for building links, for example with the
        :php:`\TYPO3\CMS\Backend\Routing\UriBuilder`. Additionally, the aliases can
        also be used for references in other modules, for example to specify a
        module's :confval:`parent <backend-module-parent>`.

        **Examples**

        Example for a new module identifier:

        ..  literalinclude:: _ModuleConfiguration/_AliasModule.php
            :language: php
            :caption: Excerpt of EXT:my_extension/Configuration/Backend/Modules.php

        Example for a route alias identifier:

        ..  literalinclude:: _ModuleConfiguration/_AliasIdentifier.php
            :language: php
            :caption: Excerpt of EXT:my_extension/Configuration/Backend/Modules.php

    ..  confval:: routeOptions
        :name: backend-module-routeOptions
        :type: array

        Generic side information that will be merged with each generated
        :php:`\TYPO3\CMS\Backend\Routing\Route::$options` array. This can be
        used for information, that is not relevant for a module aspect,
        but more relevant for the routing aspect, for example
        :ref:`sudo mode <backend-routing-sudo>`.


..  _backend-modules-api-default:

Default module configuration options (without Extbase)
------------------------------------------------------

..  confval-menu::
    :name: backend-module-default
    :display: table
    :type:

    ..  confval:: routes
        :name: backend-module-routes
        :type: array

        Define the routes to this module. Each route requires at least the `target`.
        The `_default` route is mandatory, except for modules which can fall back
        to a submodule. The `path` of the `_default` route is taken from the
        top-level configuration. For all other routes, the route identifier is taken
        as `path`, if not explicitly defined. Each route can define any
        controller/action pair and can restrict the allowed HTTP methods:

        ..  literalinclude:: _ModuleConfiguration/_Routes.php
            :language: php
            :caption: Excerpt of EXT:my_extension/Configuration/Backend/Modules.php

        All subroutes are automatically registered in a
        :php:`\TYPO3\CMS\Core\Routing\RouteCollection`. The full syntax for route
        identifiers is `<module_identifier>.<sub_route>`, for example,
        `my_module.edit`. Therefore, using the
        :php:`\TYPO3\CMS\Backend\Routing\UriBuilder` to create a link to such a
        sub-route might look like this:

        ..  code-block:: php

            \TYPO3\CMS\Backend\Routing\UriBuilder->buildUriFromRoute('my_module.edit');


Extbase module configuration options
------------------------------------

..  _backend-modules-configuration-extensionName:

..  note::
    Using these Extbase configurations tells the Core to bootstrap Extbase and expecting
    controllers based on :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.
    Do not use it for non-Extbase controller. Use :confval:`routes <backend-module-routes>`
    instead.

..  confval-menu::
    :name: backend-module-extbase
    :display: table
    :type:

    ..  confval:: extensionName
        :name: backend-module-extensionName
        :type: string

        The extension name in UpperCamelCase for which the module is registered. If
        the extension key is `my_example_extension` the extension name would be
        `MyExampleExtension`.

    ..  confval:: controllerActions
        :name: backend-module-controllerActions
        :type: array

        Define the controller action pair. The array keys are the
        controller class names and the values are the actions, which
        can either be defined as array or comma-separated list:

        ..  literalinclude:: _ModuleConfiguration/_ControllerActions.php
            :language: php
            :caption: Excerpt of EXT:my_extension/Configuration/Backend/Modules.php

        The modules define explicit routes for each controller/action combination,
        as long as the :typoscript:`enableNamespacedArgumentsForBackend` feature
        toggle is turned off (which is the default). This effectively means
        human-readable URLs, since the controller/action combinations are no longer
        defined via query parameters, but are now part of the path.

        This leads to the following URLs:

        *   :samp:`https://example.com/typo3/module/web/ExtkeyExample`
        *   :samp:`https://example.com/typo3/module/web/ExtkeyExample/MyModule/list`
        *   :samp:`https://example.com/typo3/module/web/ExtkeyExample/MyModule/detail`

        The route identifier of corresponding routes is registered with similar
        syntax as :ref:`standard backend modules <backend-modules-api-default>`:
        :php:`<module_identifier>.<controller>_<action>`. Above configuration will
        therefore register the following routes:

        *   `web_ExtkeyExample`
        *   `web_ExtkeyExample.MyModule_list`
        *   `web_ExtkeyExample.MyModule_detail`

Debug the module configuration
===============================

All registered modules are stored as objects in a registry. They can be viewed
in the backend in the :guilabel:`System > Configuration > Backend Modules`
module.

..  include:: /Images/ManualScreenshots/Backend/BackendModulesConfiguration.rst.txt

The :ref:`ModuleProvider <backend-module-provider-api>` API allows extension
authors to work with the registered modules.

..  _backend-module-configuration-sudo:

Backend modules with sudo mode
==============================

You can configure the sudo mode in your backend module like this:

..  literalinclude:: _ModuleConfiguration/_sudo_modules.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

See also :ref:`backend-module-sudo-modules`.
