:navigation-title: storagePid

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; storagePid
..  _extbase-persistence-storagepid:

===============================================
The storagePid: where Extbase looks for records
===============================================

Every Extbase repository query — except :php:`findByUid()` and
:php:`findByIdentifier()` — is restricted to records stored on specific TYPO3
pages, the *storage pages*, configured through the **storagePid**. This is not an
optional filter you opt into: it is a constraint Extbase adds to the query
automatically, alongside the language and visibility constraints.

Because it is applied silently, the storagePid is the setting that most often
makes a query behave differently from what you expect — too few records, too
many, or the wrong ones. This page collects the whole story: how the value is
resolved, how to widen it to subpages, and how to override or drop it for a
single query.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-persistence-storagepid-constraint:

storagePid as a query constraint
================================

When a repository builds a query, Extbase adds a :sql:`WHERE` condition limiting
the result to records whose :sql:`pid` is one of the configured storage pages.
The only built-in methods that skip it are :php:`findByUid()` and
:php:`findByIdentifier()`, which look a record up by its unique identifier
regardless of page.

This matters for two reasons. First, a repository with no configured storagePid
queries page :sql:`0` and finds nothing — see
:ref:`extbase-persistence-storagepid-zero`. Second, the constraint is resolved
from several configuration sources that override one another, so the page a query
actually searches is not always the one you set.


..  _extbase-persistence-storagepid-resolution:

The storagePid resolution chain in the frontend
===============================================

Several options feed the storagePid, and later ones override earlier ones. In a
frontend request Extbase resolves them in this order, depending on the controller that
handles the request:

#.  **Framework TypoScript** —
    :typoscript:`config.tx_extbase.persistence.storagePid`. This is the
    framework-level default that applies to every Extbase plugin, and the same
    key a backend module reads (see below). When nothing sets it, the frontend
    default is :sql:`0`.
#.  **Extension plugin TypoScript** —
    :typoscript:`plugin.tx_myextension.persistence.storagePid` overrides the
    framework value for all plugins of one extension.
#.  **Plugin-specific TypoScript** —
    :typoscript:`plugin.tx_myextension_conferencelist.persistence.storagePid`
    overrides the extension-wide value for that one plugin.
#.  **The Startingpoint field** on a plugin's content element. When an editor
    fills in the :guilabel:`Behaviour > Starting point` field, the chosen pages
    override the TypoScript value. The label hides the real database column,
    which is :sql:`pages` — useful to know when inspecting records or writing
    overrides, as the label is not guaranteed to read the same on every instance
    or in every language.
#.  **FlexForm** — only if a plugin's FlexForm defines a field bound to
    :typoscript:`persistence.storagePid`. A FlexForm overrides the storage page
    only if it deliberately exposes the :typoscript:`persistence` sheet. This is
    mentioned for completeness — it would be unusual to expose a
    :typoscript:`persistence.storagePid` FlexForm field on a plugin that already
    has a :sql:`pages` (Startingpoint) field.
#.  **PHP, per query** — query settings override everything above. Where in your
    code you set them decides how wide the effect is: inside a single repository
    method only that one query changes; inside an overridden :php:`createQuery()`
    every query the repository builds is affected. See
    :ref:`extbase-persistence-storagepid-override`.

The most specific option that supplies a value is applied; a specific query's
settings always have the final say.


..  _extbase-persistence-storagepid-backend:

The storagePid resolution chain in a backend module
===================================================

An Extbase repository behaves the same way inside a backend module as it does in
the frontend: every query is restricted to the configured storage pages. What
differs is *how* the storagePid is resolved. A backend module is not a content
element on a page, so there is no plugin record, no FlexForm and no
:guilabel:`Starting point` field to draw from. The chain is therefore much
shorter:

#.  **Framework TypoScript** —
    :typoscript:`config.tx_extbase.persistence.storagePid`. Note the
    :typoscript:`config` scope: a backend module reads the same framework-level
    key the frontend uses for its Extbase configuration, not a
    :typoscript:`plugin` scope.
#.  **The current page** — if nothing above sets a storagePid, Extbase falls back
    to the **page the module is currently showing**, taken from the ``id``
    request parameter (the page selected in the page tree). When no page is
    selected — or the module has no page tree at all, as many backend modules do
    not — this falls back to :sql:`0`.
#.  **Module TypoScript** —
    :typoscript:`module.tx_myextension.persistence.storagePid`, overridden by the
    module-specific
    :typoscript:`module.tx_myextension_mymodule.persistence.storagePid`. This is
    the backend counterpart of the :typoscript:`plugin.tx_*` scope used in the
    frontend, and the usual place to set a storagePid for a module.
#.  **PHP, per query** — query settings override everything above, exactly as in
    the frontend. See :ref:`extbase-persistence-storagepid-override`.

..  literalinclude:: _snippets/_module_storagepid.typoscript
    :caption: EXT:my_extension/ext_typoscript_setup.typoscript

Module TypoScript is conventionally registered in the extension's
:file:`ext_typoscript_setup.typoscript`, as shown above, so the configuration is
global and does not depend on which page the module happens to be viewing. This
is the recommended placement, see :ref:`module <t3tsref:tlo-module>` TypoScript reference.

..  note::

    Because the current-page fallback depends on the ``id`` request parameter, a
    module without a page tree (or with no page selected) resolves its storagePid
    to :sql:`0`. If your module is not meant to be scoped to the current page or the root,
    set an explicit storagePid in :typoscript:`module.tx_*` TypoScript, or drop
    the restriction per query with :php:`setRespectStoragePage(false)` — see
    :ref:`extbase-persistence-storagepid-override`.

The :typoscript:`recursive` setting works the same in a backend module as in the
frontend, as described next.


..  _extbase-persistence-storagepid-recursive:

Searching subpages with the recursive setting
=============================================

By default, Extbase searches only the storage pages you configured — not their
subpages. To include records stored in subfolders below the storage page, set a
recursion depth.

In TypoScript, :typoscript:`persistence.recursive` applies to the
TypoScript-configured storagePids:

..  literalinclude:: _snippets/_recursive.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The :guilabel:`Starting point` field has its own :guilabel:`Recursive` selector
next to it that does the same for the editor-chosen pages.

..  warning::

    Recursion is a frequent source of *too many* results, not too few. A
    recursive depth set too high pulls in records from unrelated subpages that
    happen to sit below the storage page. Set the depth to the smallest value
    that covers your folder structure.


..  _extbase-persistence-storagepid-override:

Overriding the storagePid for a single query
============================================

The configured storagePid is the default for every query a repository builds. To
change it for one query, use the query settings object inside a custom repository
method:

..  literalinclude:: _snippets/_QuerySettings.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

Two settings control the page restriction:

..  confval-menu::
    :name: extbase-storagepid-querysettings
    :display: table
    :type:
    :default:

    ..  confval:: setRespectStoragePage(bool)
        :name: storagepid-respectStoragePage
        :type: `bool`
        :default: `true`

        When :php:`false`, the storagePid restriction is dropped entirely and the
        query searches the whole table regardless of page. This is how you
        disable the page restriction.

    ..  confval:: setStoragePageIds(array)
        :name: storagepid-storagePageIds
        :type: `int[]`

        Sets the storage pages explicitly for this query, overriding the
        configured storagePid. Expects an array of integer page UIDs. Has no
        effect once :php:`setRespectStoragePage(false)` is set.

The query settings object also controls language, enable fields and deleted
records, which are independent of the storagePid:

..  seealso::

    `Overriding query behaviour with query settings <https://docs.typo3.org/permalink/extbase-persistence-queries-querysettings>`_ — the language, enable-field and deleted-record settings on the same query settings object.


..  _extbase-persistence-storagepid-zero:

Why :php:`storagePid = 0` does not disable the restriction
==========================================================

A common misconception is that setting the storagePid to :typoscript:`0` switches
off the page restriction. It does not. For an ordinary table, :sql:`0` is the UID of
the page tree root, a level no editor ever stores records on — so the query looks
for records on page 0 and finds none. The effect is an empty result, not an
unrestricted query.

To search the whole table irrespective of page, drop the restriction in PHP
instead:

..  literalinclude:: _snippets/_DisableStoragePid.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php


..  _extbase-persistence-storagepid-build:

Building the storagePid array from editor input
===============================================

When for any reason the storagePid array can't be built by Extbase but you want
to do it manually, use Core API rather than constructing the recursive page list
yourself. The core
:php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository` resolves the recursive
list of page UIDs for you, honouring access rights and the enable-field rules:

..  literalinclude:: _snippets/_RecursivePids.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The resulting integer array is exactly what :php:`setStoragePageIds()` expects.
Letting the core API build it keeps the recursion logic identical to what Extbase
applies internally.

..  seealso::

    *   `The Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — where the storagePid constraint applies to the built-in find methods.

    *   `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — building queries, constraints, ordering and the other query settings.
