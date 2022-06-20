

Without Extbase:
----------------

.. code-block:: php

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
       'random',
       'filerelatedmodule',
       'top',
       null,
       [
           'navigationComponentId' => 'TYPO3/CMS/Backend/Tree/FileStorageTreeContainer',
           'routeTarget' => \MyVendor\MyExtension\Controller\FileRelatedController::class . '::indexAction',
           'access' => 'user,group',
           'name' => 'myext_file',
           'icon' => 'EXT:myextension/Resources/Public/Icons/module-file-related.svg',
           'labels' => 'LLL:EXT:myextension/Resources/Private/Language/Modules/file_related.xlf'
       ]
   );

Parameters:

#. **Main module** name, in which the new module will be placed,
   for example 'web' or 'system'.
#. **Submodule key**: This is an identifier for your new module.
#. **Position** of the module: Here, the module should be placed at the ``top`` of the main
   module, if possible. If several modules are declared at the same position, the last one wins.
   The following positions are possible:

   *  ``top``: the module is prepended to the top of the submodule list
   *  ``bottom`` or empty string: the module is appended to the end of the submodule list
   *  ``before:<submodulekey>``: the module is inserted before the submodule identified by ``<submodulekey>``
   *  ``after:<submodulekey>``: the module is inserted after the submodule identified by ``<submodulekey>``

#. **Path**: Was used prior to TYPO3 v8, use :php:`$moduleConfiguration[routeTarget]` now and set path to null.
#. **Module configuration**: The following options are available:

   *  ``access``: can contain several, separated by comma

      *  ``systemMaintainer``: the module is accessible to system maintainers only.
      *  ``admin``: the module is accessible to admins only
      *  ``user``: the module can be made accessible per user
      *  ``group``: the module can be made accessible per usergroup

   *  Module ``iconIdentifier`` or ``icon``
   *  A language file containing ``labels`` like the module title and description,
      for building the module menu and for the display of information in the
      :guilabel:`Help > About Modules` module (found in the main help menu in the top bar).
      The `LLL:` prefix is mandatory here and is there for historical reasons.
   *  Navigation component ``navigationComponentId`` - you can specify which
      navigation component you want to use, for example
      :php:`TYPO3/CMS/Backend/PageTree/PageTreeElement` for a page tree
      or :php:`TYPO3/CMS/Backend/Tree/FileStorageTreeContainer`
      for a folder tree. If you don't want to show a navigation component at
      all you can either set this to an empty string or not declare it at all.
      In case the main module (e.g. "web") has a navigationComponent defined
      by default you'll have to also set
      :php:`'inheritNavigationComponentFromMainModule' => false`.
   *  A `routeTarget` indicating the controller/action-combination to be
      called when accessing this module.

.. index:: icon, iconIdentifier

`'iconIdentifier'` versus `'icon'`
----------------------------------

`'iconIdentifier'` is the better and more modern way to go. It should always be used
for Core icons. Other icons however need to be registered first at the IconRegistry to
create identifiers. Note that `'icon'` still works. Within custom packages it is easier
to use. Example:

.. code-block:: php

   'icon' => 'EXT:extkey/Resources/Public/Icons/smile.svg',

.. index:: Backend modules; Toplevel

Registering a toplevel module
=============================

Toplevel modules like "Web" or "File" are registered with the same API. The following
example uses Extbase to register the module, however, the process for non-extbase
modules is the same.

.. code-block:: php
    :caption: EXT:my_extension/ext_tables.php

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'MyExtension',
        'mysection',
        '',
        '',
        [],
        [
            'access' => '...',
            'iconIdentifier' => '...',
            'labels' => '...',
        ]
    );

This adds a new toplevel module ``mysection``. This identifier can now
be used to add submodules to this new toplevel module:

.. code-block:: php
    :caption: EXT:my_extension/ext_tables.php

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'MyExtension',
        'mymodule1',
        'mysection',
        '',
        [],
        [
            'access' => '...',
            'labels' => '...'
        ]
    );

.. note::
   The main module name should contain only lowercase characters. Do not use an underscore or dash.

$TBE\_MODULES
=============

When modules are registered, they get added to a global array called
:php:`$GLOBALS['TBE_MODULES']`. It contains the list of all registered
modules, their configuration and the configuration of any existing
navigation component (the components which may be loaded into the
navigation frame).

:php:`$GLOBALS['TBE_MODULES']` can be explored using the
:guilabel:`System > Configuration` module.

.. include:: /Images/AutomaticScreenshots/BackendModules/BackendModulesConfiguration.rst.txt

The list of modules is parsed by the class :php:`\TYPO3\CMS\Backend\Module\ModuleLoader`.



