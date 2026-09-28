:navigation-title: How modules work

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-backend-module-basics:

===================================
How an Extbase backend module works
===================================

An Extbase backend module runs the same controllers, repositories and
validators as a frontend plugin. The framework around them is different: the
request comes from the backend router instead of a content element, the
configuration comes from a different TypoScript scope, and there is no plugin
record to supply storage pages. This page describes those differences.

Registering the module, access control and rendering through
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` are covered in
:ref:`Registering an Extbase backend module
<extbase-registration-backend-module>`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-backend-module-basics-dispatch:

How a backend module request flows through Extbase
==================================================

The frontend path is described in :ref:`How a request flows through Extbase
<extbase-concepts-mvc-request-flow>`. A backend module takes the same six
steps. Steps 3 and 4 run the very same code; the others differ:

..  rst-class:: bignums

1.  **The backend routes the request to the module**

    There is no page and no content element. TYPO3 registers a backend route
    for every action listed in the module's
    :confval:`controllerActions <backend-module-controllerActions>`. The first
    action of the first controller answers the module's own route; every
    other action gets a route named after the module identifier, the
    controller name without its `Controller` suffix and the action, for
    example `my_extension_conferences.Conference_show`.

    Before Extbase is involved, the backend checks that the current user may
    access the module and loads the module's stored state for this user.

2.  **An Extbase request object is built — without an argument namespace**

    Extbase takes the extension name and the module identifier from the
    module, and uses the module identifier where a frontend request has the
    plugin name. The controller and action come from the route.

    Arguments are **not namespaced**. A frontend plugin reads
    :samp:`tx_myextension_conferencelist[conference]=42` so that several
    plugins can share one page. A module owns the whole request, so it reads
    plain query and POST parameters: :samp:`conference=42`.

3.  **The dispatcher resolves the controller**

    Identical to the frontend.

4.  **The controller action runs**

    Identical to the frontend: property mapping, validation and
    :php:`errorAction()` work exactly as they do in a plugin.

5.  **The action builds the response through the module template**

    Instead of :php:`$this->htmlResponse()`, the action renders through a
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate`, which wraps the
    output in the backend page frame. See :ref:`Rendering in the module
    controller <extbase-registration-backend-module-template>`.

6.  **The response goes straight back to the backend**

    There is no page to insert the output into. The response is the complete
    module page. As in the frontend, pending changes to domain objects are
    persisted after the action returns.

Some things a frontend plugin can rely on do not exist in a module at all:
there is no content element and therefore no
:php-short:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`, no
FlexForm, and no page cache. Plugin caching, including
:ref:`non-cacheable actions <extbase-caching-noncacheable>`, has no meaning in
a module; every request runs the action.


..  _extbase-backend-module-basics-configuration:

Where an Extbase backend module reads its configuration
=======================================================

A module reads the same kind of configuration a plugin does — settings,
persistence and view options — but from the :typoscript:`module` scope instead
of the :typoscript:`plugin` scope:

*   :typoscript:`config.tx_extbase` — framework defaults, shared with the
    frontend.
*   :typoscript:`module.tx_myextension` — defaults for every module of the
    extension.
*   :typoscript:`module.tx_myextension_<module identifier>` — values for one
    module. The module identifier is used as it is registered, lowercased. For
    a module registered as `my_extension_conferences` this is
    :typoscript:`module.tx_myextension_my_extension_conferences`.

How the two :typoscript:`module` layers are merged is described in
:ref:`How the module configuration is assembled
<extbase-registration-backend-module-configuration-assembly>`.

This is **frontend** TypoScript. A developer coming from Symfony or Laravel
would expect backend configuration to live in its own files; in TYPO3,
Extbase modules evaluate the frontend TypoScript of the installation, for
historical reasons. That has a cost: the time a module needs to load its
configuration grows with the amount of frontend TypoScript in the
installation, however little of it the module uses. The
:ref:`TypoScript reference <t3tsref:tlo-module>` therefore advises custom
modules against :typoscript:`module` TypoScript altogether.

For an Extbase module, TypoScript remains the place for storage pages and
persistence, because that is where Extbase reads them. Settings of your own
do not have to live there:

*   Settings your module reads itself can live in
    :ref:`page TSconfig <t3tsref:page-tsconfig-extension-namespace>`, which
    the backend evaluates anyway.
*   Template overrides always go through page TSconfig. The
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` a module renders
    with resolves its templates from the extension and from the
    :ref:`templates <t3tsref:pagetemplates>` option, and ignores
    :typoscript:`module.tx_*.view`.


..  _extbase-backend-module-basics-typoscript:

Which TypoScript an Extbase backend module sees
===============================================

TypoScript belongs to pages, and a backend module does not always have one.
Which TypoScript a module is given depends on whether it has page context:

With page context
    The module shows the page tree and the editor has selected a page. The
    module sees the TypoScript of that page, exactly as the frontend would:
    from the TypoScript records along its rootline, or from the site sets of
    its site.

Without page context
    The module has no page tree, no page is selected, or the selected page
    has no TypoScript. The module sees **global TypoScript only**.

..  versionchanged:: 14.0

    A module without page context used to search for the first page with a
    TypoScript record and use its TypoScript. It now uses global TypoScript
    only. See `Breaking: #105728 — Extbase backend modules not in page
    context rely on global TypoScript only
    <https://docs.typo3.org/permalink/changelog:breaking-105728-1732882067>`_
    and :ref:`the upgrade entry <extbase-upgrading-module-global-typoscript>`.

Configuration a module needs in every situation — above all its storage
pages — therefore has to be global. Register it with
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup()`
in the extension's :file:`ext_localconf.php`:

..  literalinclude:: _snippets/_ext_localconf_module_typoscript.php
    :caption: EXT:my_extension/ext_localconf.php

TypoScript added this way reaches all three cases: the module without page
context, pages whose TypoScript comes from records, and pages whose site uses
site sets.

..  warning::

    Do not rely on :ref:`ext_typoscript_setup.typoscript
    <ext_typoscript_setup_typoscript>` for module configuration. It is loaded
    for a module without page context and on sites built from TypoScript
    records, but not on sites that use site sets. A module with a page tree
    then loses its configuration as soon as the editor selects a page of such
    a site.

The same split between modules with and without page context decides which
language a module works in, see :ref:`Localization in backend modules
<extbase-localisation-no-frontend-backend>`.


..  _extbase-backend-module-basics-storage-pid:

The storagePid in an Extbase backend module
===========================================

The defaults are the opposite of the frontend. A frontend plugin without a
configured storagePid searches page `0`; other page uids have to come from
configuration, usually the editor's **Starting point**. A backend module
without a configured storagePid searches the page selected in the page tree,
and only falls back to `0` when there is none.

A module without a page tree therefore searches page `0` until a
storagePid is configured. The full resolution chain is described in
:ref:`The storagePid resolution chain in a backend module
<extbase-persistence-storagepid-backend>`.


..  _extbase-backend-module-basics-language:

The language in an Extbase backend module
=========================================

A module with page context can take the language rules from the site of the
selected page. A module without one works in the default language unless it
chooses another explicitly. Both cases are described in
:ref:`Localization in backend modules
<extbase-localisation-no-frontend-backend>`.


..  _extbase-backend-module-basics-id:

The `id` parameter in an Extbase backend module
===============================================

The selected page reaches a module as the `id` request parameter. This is a
backend convention rather than a guarantee: some Core modules use `id` for
something else, the file list for example passes a storage and folder path.
Extbase only treats `id` as a page when it is a positive integer and
otherwise behaves as if no page were selected. A module that passes its own
values in `id` therefore silently loses its page context.

With the runtime differences in place, the Extbase-specific keys of the
module registration are described in :ref:`Registering an Extbase backend
module <extbase-registration-backend-module>`, and the storage and language
rules in the pages linked above.
