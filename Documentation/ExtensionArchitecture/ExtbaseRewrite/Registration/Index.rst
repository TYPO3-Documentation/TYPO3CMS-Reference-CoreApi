:navigation-title: Registration

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Registration
..  _extbase-registration:

=======================================
Registering plugins and backend modules
=======================================

An Extbase extension can register frontend plugins, backend modules, both, or
neither — depending on what it needs to deliver.

*   A **frontend plugin** renders content on a page. Editors add it as a
    content element and visitors see the output in the frontend.
*   A **backend module** adds a section to the TYPO3 backend for editors or
    administrators to manage data.

Each registration requires a small amount of PHP and configuration files loaded
during bootstrap — no database records, no install steps.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-registration-overview:

In this chapter
===============

:ref:`extbase-registration-frontend-plugin`
    How to register an Extbase plugin as a frontend content element:
    :php:`configurePlugin()`, :php:`registerPlugin()`, allowed actions,
    non-cacheable actions, and the TypoScript plugin object path.

:ref:`extbase-registration-backend-module`
    How to register an Extbase-based backend module via
    :file:`Configuration/Backend/Modules.php`: the
    :confval:`controllerActions <backend-module-controllerActions>` key,
    access control, icons, and the full module API at :ref:`backend-modules-api`.

..  toctree::
    :titlesonly:
    :hidden:

    FrontendPlugin
    BackendModule
