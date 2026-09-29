:navigation-title: Without a page tree

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-backend-module-no-page-tree:

======================================================
Building an Extbase backend module without a page tree
======================================================

A conference team maintains its conferences in a backend module of their own.
The records live in one storage folder, and nobody working in the module cares
which page that is. The module therefore shows no page tree: it opens straight
to a list of all conferences, with a search field and a filter.

Without a page tree the module has no page context, and everything a page
would otherwise supply has to be provided by extension configuration:

*   The module sees **global TypoScript only**, see
    :ref:`Which TypoScript an Extbase backend module sees
    <extbase-backend-module-basics-typoscript>`.
*   There is no selected page to fall back on, so the **storagePid** has to be
    configured, or every query has the restriction to only touch page `0`.
*   There is no site, so the module works in the **default language** unless
    another one is explicitly chosen, see :ref:`The language in an Extbase
    backend module <extbase-backend-module-basics-language>`.

This page builds that module: registration, configuration, a list with search,
filter and pagination, and filters that are still set when the editor comes
back. Creating, editing and removing the conferences is covered on the next
page.

..  contents:: Table of contents
    :local:


..  _extbase-backend-module-no-page-tree-registration:

Registering an Extbase backend module without a page tree
=========================================================

A module shows the page tree when its main module does. The
:ref:`toplevel module <backend-modules-toplevel-module>` `content` does, so a
module registered below it inherits the page tree unless it opts out with
:confval:`inheritNavigationComponentFromMainModule
<backend-module-inheritNavigationComponentFromMainModule>`:

..  literalinclude:: _snippets/_ModulesWithoutPageTree.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php
    :emphasize-lines: 13-14

Core's form module is registered the same way: it sits in
:guilabel:`Content`, where editors look for it, but shows no tree. The other
way is to choose a toplevel module that has no navigation component in the
first place, for example `site` or `admin`. Which one fits depends on who
uses the module, also custom ones are possible. The options for main modules
and submodules are described in :ref:`Modules.php - backend module
configuration <backend-modules-configuration-options>`.

The module has a single action, `list`. Creating and editing conferences needs
no action of its own, see :ref:`Editing records from an Extbase backend module
<extbase-backend-module-editing>`. The keys `extensionName` and
`controllerActions` are described in :ref:`Registering an Extbase backend
module <extbase-registration-backend-module>`.


..  _extbase-backend-module-no-page-tree-configuration:

Configuring the storagePid of a module without a page tree
==========================================================

A module without a page tree gets no page TypoScript, so its configuration
has to be global. Register it in the extension's :file:`ext_localconf.php`
with :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup()`:

..  literalinclude:: _snippets/_ext_localconf_module_typoscript.php
    :caption: EXT:my_extension/ext_localconf.php

The :typoscript:`module.tx_myextension` scope applies to every module of the
extension. To configure this module alone, append the module identifier:
:typoscript:`module.tx_myextension_my_extension_conferences`. Without the
:typoscript:`storagePid` the list stays empty, unless the conferences are
stored on page `0`: there is no selected page for Extbase to fall back on.
The full resolution order is described in :ref:`The storagePid resolution
chain in a backend module <extbase-persistence-storagepid-backend>`.

A module with many users and many folders would make the storage folder
configurable per site instead. This is the case the
:ref:`module with a page tree <extbase-backend-module-page-tree>` solves.


..  _extbase-backend-module-no-page-tree-demand:

A demand object for search and filters in a backend module
==========================================================

The search field and the status filter are submitted together, as one object.
Such an object is called a demand: it describes which records the editor
wants to see, and the repository turns it into a query. Core's backend user
module works with the same pattern.

The demand is a plain PHP class, not a domain model. It has no table and is
never persisted by Extbase:

..  literalinclude:: _snippets/_ConferenceDemand.php
    :caption: EXT:my_extension/Classes/Domain/Model/ConferenceDemand.php

When the filter form is submitted, Extbase maps the form fields to the
constructor arguments of the same name, see :ref:`How Extbase property mapping
works <extbase-controller-propertymapping-how>`. :php:`fromArray()` and
:php:`toArray()` convert the demand from and to a plain array, which is the
form in which it is stored between requests, as described in the next
section.

..  note::

    Keep the class out of the dependency injection container. Extbase only
    passes the submitted values to the constructor when the class is not a
    service. The usual :file:`Services.yaml` of an extension excludes
    :path:`Classes/Domain/Model/`, which is why the demand lives there.

The repository method builds its constraints from the demand. Each filter the
editor left empty adds no constraint:

..  literalinclude:: _snippets/_ConferenceModuleRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php
    :visible-lines: 13-39

How to build constraints and combine them is described in :ref:`Building
Extbase queries <extbase-persistence-queries-constraints>`.


..  _extbase-backend-module-no-page-tree-module-data:

Keeping the filters of an Extbase backend module in `ModuleData`
================================================================

An editor who sets a filter, opens a conference and comes back expects the
filter to still be set. The backend keeps such settings per user and per
module, in the :ref:`module data object <backend-Module-data-object>`. It
arrives with every module request as the `moduleData` request attribute.

The list action reads the demand from the module data when the request
brings none, and stores it there when it does:

..  literalinclude:: _snippets/_ConferenceListModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :visible-lines: 37-58

..  warning::

    :php:`ModuleData::set()` changes the module data of the current request
    only. Without the call to :php:`pushModuleData()` the
    filters are gone with the next request.

The module data is saved serialized in the backend user's settings. The
demand therefore goes in as a plain array, which restores safely. An object
would have to be unserialized with an explicit list of allowed classes.


..  _extbase-backend-module-no-page-tree-reset:

Resetting the filters of an Extbase backend module
==================================================

Because the filters are kept, the editor needs a way to clear them. The
:php:`$operation` argument of the list action does that: a link with
`operation` set to `reset-filters` empties the stored demand before the list
is built. The link is part of the filter form, shown below.


..  _extbase-backend-module-no-page-tree-list:

Listing the filtered records with pagination
============================================

With the demand known, the list action asks the repository for the matching
conferences and paginates them. The template receives the paginator, the
pagination and the demand, which prefills the filter form:

..  literalinclude:: _snippets/_ConferenceListModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :visible-lines: 60-69

Paginators and pagination strategies are described in :ref:`Paginating a
query result <extbase-persistence-queries-pagination>`. The same classes work
in a module as in a frontend plugin.

The template uses the backend :html:`Module` layout, which
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` wraps in the backend
page frame. The filter form is an ordinary Extbase form bound to the demand:

..  literalinclude:: _snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 1-25,70-79

The page links pass only `currentPage`. The demand comes from the module data,
so the filters stay applied while the editor browses through the list.


..  _extbase-backend-module-no-page-tree-initialize:

Setting up an Extbase module controller in `initializeAction()`
===============================================================

The controller reads the module data and creates the module template in
:php:`initializeAction()`, not in its constructor:

..  literalinclude:: _snippets/_ConferenceListModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :visible-lines: 18-35

The constructor runs when the controller is created, before Extbase hands it
the request. Anything that depends on the request, and in a module that is
most of its state, therefore belongs in :php:`initializeAction()`, which runs
before every action. See :ref:`initializeAction and per-action initialization
<extbase-controller-action-initialize>`.


..  _extbase-backend-module-no-page-tree-next:

Next steps for the module without a page tree
=============================================

The module lists and filters conferences, but cannot change them yet. The
list template already contains the links that do, and none of them needs a
controller action: :ref:`Editing records from an Extbase backend module
<extbase-backend-module-editing>` explains them.

The opposite case, a module whose page tree supplies the storage folder, the
site and the language, is built in :ref:`Building an Extbase backend module
with a page tree <extbase-backend-module-page-tree>`.
