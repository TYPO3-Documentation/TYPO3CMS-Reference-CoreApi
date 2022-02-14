:orphan:

.. versionchanged:: 12.0
   In TYPO3 version 12 and above the registration of Extbase and non-Extbase
   backend modules was unified. See :ref:`backend-modules-api`.

Here the module ``tx_Beuser`` is declared as a submodule of the already existing
main module ``system``.

Parameters:

#. The first argument contains the extension name (in UpperCamelCase)
   or the extension key (in lower_underscore). Since TYPO3 10.0,
   you should no longer prepend the vendor name here, see
   :doc:`t3core:Changelog/10.0/Deprecation-87550-UseControllerClassesWhenRegisteringPluginsmodules`.
#. **Main module** name, in which the new module will be placed,
   for example 'web' or 'system'.
#. **Submodule key**: This is an identifier for your new module.
#. **Position** of the module: Here, the module should be placed at the ``top`` of the main
   module, if possible. If several modules are declared at the same position, the last one wins.
   The following positions are possible:

   * ``top``: the module is prepended to the top of the submodule list
   * ``bottom`` or empty string: the module is appended to the end of the submodule list
   * ``before:<submodulekey>``: the module is inserted before the submodule identified by ``<submodulekey>``
   * ``after:<submodulekey>``: the module is inserted after the submodule identified by ``<submodulekey>``

#. Allowed **controller => action** combinations. Since TYPO3 10.0 you should
   use fully qualified class names here, see
   :doc:`t3core:Changelog/10.0/Deprecation-87550-UseControllerClassesWhenRegisteringPluginsmodules`.
#. **Module configuration**: The following options are available:

   *  ``access``: can contain several, separated by comma

      *  ``systemMaintainer``: the module is accessible to system maintainers only.
      *  ``admin``: the module is accessible to admins only
      *  ``user``: the module can be made accessible per user
      *  ``group``: the module can be made accessible per usergroup

   *  Module ``iconIdentifier``

   *  A language file containing ``labels`` like the module title and description,
      for building the module menu and for the display of information in the
      **About Modules** module (found in the main help menu in the top bar).
      The `LLL:` prefix is mandatory here and is there for historical reasons.

   *  Navigation component ``navigationComponentId`` - you can specify which
      navigation component you want to use, for example
      :php:`TYPO3/CMS/Backend/PageTree/PageTreeElement` for a page tree or
      :php:`TYPO3/CMS/Backend/Tree/FileStorageTreeContainer` for a folder tree.
      If you don't want to show a navigation component at all you can either
      set this to an empty string or not declare it at all. In case the main
      module (e.g. "web") has a navigationComponent defined by default you'll
      have to also set :php:`'inheritNavigationComponentFromMainModule' => false`.


.. note::
   When registering frontend plugins, you must define which actions are not to be stored
   in the cache. This is not necessary for backend modules, because the actions are
   generally not being cached in the backend.

.. index:: Backend modules; TypoScript

Configuration with TypoScript
=============================

Backend modules can, like frontend plugins, be configured via TypoScript. While the frontend plugins
are configured with :ts:`plugin.tx_[pluginkey]`, for the configuration of the backend
:ts:`module.tx_[pluginkey]` is used.

Example for configuring the paths of Fluid files:

.. code-block:: typoscript

   module.tx_example {
       view {
           templateRootPaths {
               10 = EXT:example/Resources/Private/Backend/Templates/
           }
           layoutRootPaths {
              10 = EXT:example/Resources/Private/Backend/Layouts/
           }
       }
   }
