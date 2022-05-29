.. include:: /Includes.rst.txt
.. index:: Backend modules; API
.. _backend-modules-api:

=========================
Backend module API (core)
=========================

This page covers registering backend modules without Extbase, using core
functionality only.

:file:`ext_tables.php`:

.. code-block:: php

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
       'random',
       'filerelatedmodule',
       'top',
       null,
       [
           'navigationComponentId' => 'TYPO3/CMS/Backend/Tree/FileStorageTreeContainer',
           'routeTarget' => \MyVendor\MyExtension\Controller\FileRelatedController::class . '::handleRequest',
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
      **About Modules** module (found in the main help menu in the top bar).
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
==================================

`'iconIdentifier'` is the better and more modern way to go. It should always be used
for Core icons. Other icons however need to be registered first at the IconRegistry to
create identifiers. Note that `'icon'` still works. Within custom packages it is easier
to use. Example::

   'icon' => 'EXT:extkey/Resources/Public/Icons/smile.svg',

