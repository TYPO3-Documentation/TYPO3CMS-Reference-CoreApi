..  include:: /Includes.rst.txt
..  index:: ! Backend GUI
..  _backend-gui:
..  _backend-modules-structure:

===========
Backend GUI
===========

The backend user interface is primarily provided by the :composer:`typo3/cms-backend`
system extension and extended by additional system and third-party extensions.

The backend interface is divided into the following main areas:

..  figure:: /Images/ManualScreenshots/BackendModules/BackendModulesAreas.png
    :zoom: lightbox
    :alt: An overview of the visual structure of the backend, the sections are marked with numbers

    An overview of the backend interface: (1) top bar, (2) module menu,
    (3) page tree / navigation frame, (4) DocHeader, (5) content area,
    (6) contextual menu, (7) module menu toggle, (8) page tree toggle

..  figure:: /Images/ManualScreenshots/BackendModules/BackendModuleCollapsed.png
    :zoom: lightbox
    :alt: Backend with collapsed module menu and page tree, showing toggles

    Collapsed navigation areas: (1) module menu toggle, (2) page tree toggle

1.  Top bar

    The top bar is always visible and consists of two areas: the logo and the toolbar.

    The logo can be configured using
    :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendLogo']`.

    Additional toolbar items can be registered via
    :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems']`.

2.  Module menu

    This is the main navigation area. Modules are organized into main modules
    (collapsible), and submodules where the actual functionality is implemented.

    The module menu can be toggled using the icon in the top-left corner (7).

    The chapter :ref:`backend-modules-configuration` describes how new
    main or submodules are registered.

    ..  note::

        In TYPO3 terminology, "module" refers to backend functionality.
        Frontend features are provided by extensions called "plugins".

3.  Page tree / navigation frame

    A backend module may include a navigation frame. This typically displays
    the page tree or folder tree, but custom navigation components are also
    possible.

    The current selection (for example, a page or folder) is preserved when
    switching between modules.

4.  DocHeader

    The DocHeader is located above the content area. It typically includes a
    "Function menu" for navigating around module-specific features.

    It also provides action buttons such as save, close, and revert for use
    when editing content. Additional buttons (for example, shortcuts or module-specific
    actions) may be available.

5.  Content area

    This is the main workspace where content is displayed and edited.
    Editable content and information for the backend user will be displayed here.

6.  Contextual menus

    Right-clicking on record icons typically opens a contextual menu.

    Additional actions can be added to these menus; however, implementation
    differs depending on the component (for example, the page tree behaves
    differently to other backend areas).

..  figure:: /Images/ManualScreenshots/BackendModules/BackendModulesContextualMenu.png
    :zoom: lightbox

    A typical contextual menu that appears when clicking on a record icon
