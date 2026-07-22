:navigation-title: Cache tags

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Cache tags
..  _extbase-caching-cachetags:

==========================================================
Cache tags for Extbase plugins and repository auto-tagging
==========================================================

A cached plugin is fast, but its output must be refreshed when the records it
shows change — otherwise visitors keep seeing stale data. The wrong fix is to
disable the cache (see :ref:`extbase-caching-noncacheable`); the right one is to
let the cache stay, and *invalidate* the caches of affected pages when a record changes.

Cache tags are how TYPO3 does that. Each page-cache entry can be tagged with the
records it depends on; clearing a tag flushes every page tagged with it. Extbase
can attach these tags for you automatically, so that saving a record through a
repository refreshes exactly the pages that display it.

..  contents:: On this page
    :local:
    :depth: 1

..  seealso::

    This page covers only how Extbase produces and uses cache tags. For the
    tagging mechanism itself — how the page cache stores tags and how flushing by
    tag works — see `Working with cache tags <https://docs.typo3.org/permalink/caching-developer-cache-tags>`_.


..  _extbase-caching-cachetags-autotagging:

Automatic cache tagging of Extbase repository results
=====================================================

When a repository query reads records, Extbase can tag the current page cache
entry with each record it returned. The tag identifies the table and the record
by :abbr:`UID (unique identifier, the primary key of a TYPO3 database record)`,
in the form:

..  code-block:: none

    <tablename>_<uid>

For a conference with UID 42 in the table :sql:`tx_myextension_domain_model_conference`,
the tag is :sql:`tx_myextension_domain_model_conference_42`. The page that
rendered the conference list is tagged with one such tag per conference it
displayed. Each tag also carries a lifetime: a default lifetime is attached, and
it is shortened when the record has a :sql:`starttime` or :sql:`endtime`, so the
page cache expires no later than the record's own visibility window.

Because the tagging is driven by what the query actually returned, you do not
maintain any tag list yourself: add a record to the list, and the page that shows
the list is tagged with it; change that record later, and clearing its tag
flushes the list page automatically.


..  _extbase-caching-cachetags-featureflag:

Enabling automatic cache tagging in Extbase
===========================================

Automatic tagging is controlled by the :php:`frontend.cache.autoTagging`
feature toggle. When it is enabled, repository reads tag the page cache as
described above; when it is disabled, no tags are added and you must invalidate
caches another way — for example with :ref:`automatic cache clearing
<extbase-caching-autoclearing>` or by tagging manually.

..  warning::

    The default of :php:`frontend.cache.autoTagging` depends on how the instance
    was created. A **fresh** TYPO3 v14 installation has it enabled; an instance
    **upgraded** from an earlier version keeps it disabled, because feature
    toggles retain their existing value across an upgrade. An upgraded site
    therefore does *not* get automatic cache tagging until you switch the toggle
    on explicitly.

    ..  versionchanged:: 14.0

        :php:`frontend.cache.autoTagging` defaults to enabled on fresh
        installations. Upgraded instances keep their previous value — verify the
        toggle after upgrading. See
        :ref:`extbase-upgrading-feature-toggle-defaults`.

You set the toggle in :file:`settings.php` under
:php:`SYS/features`, or through :guilabel:`Admin Tools > Settings > Feature
Toggles` in the backend.


..  _extbase-caching-cachetags-manual:

Adding cache tags manually in an Extbase controller
===================================================

Automatic tagging covers the records a repository query returns. When a plugin's
output depends on records that were *not* the query result — related records
reached through a relation, an aggregate, or data fetched outside Extbase — those
records produce no tag of their own. Add the tags yourself through the
:ref:`frontend cache collector <typo3-request-attribute-frontend-cache-collector>`
request attribute:

..  literalinclude:: _snippets/_ManualCacheTag.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The example above tags each location by its own UID. Tagging with a table name
alone (:sql:`tx_myextension_domain_model_location`, without a UID) instead tags
the page against *every* record of that table, so any change in the table flushes
the page. Use a record-specific tag where you can; use the table-wide tag only
when the output genuinely depends on the whole table.


..  _extbase-caching-cachetags-managetags:

Adjusting an Extbase plugin's page cache tags while it renders
==============================================================

Inside a plugin action you are building content for one page, and the
:ref:`frontend cache collector <typo3-request-attribute-frontend-cache-collector>`
request attribute controls the cache tags of *that* page — the one currently
being rendered. Adding or removing a tag changes what the page's cache entry
depends on and its lifetime; it does not touch any other page.

..  list-table::
    :header-rows: 1

    *   -   Operation
        -   Effect
    *   -   Add tags
        -   Tag the page being rendered with a record it depends on, so a change
            to that record flushes the page.
    *   -   Remove tags
        -   Drop a tag from the page being rendered that it should not carry.

Use it to tag the page being built — as in
:ref:`extbase-caching-cachetags-manual` above — or to remove a tag it should not
carry:

..  literalinclude:: _snippets/_RemoveCacheTag.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

..  _extbase-caching-cachetags-clearing:

Flushing cached pages from Extbase code after data changes
==========================================================

Most of the time you do not flush caches by hand — :ref:`automatic cache clearing
<extbase-caching-autoclearing>` resolves the affected pages from the records you
changed and flushes them at the end of the request. You need to act directly only
when records change outside a rendering request — for example through an import, a
command-line task, an event listener. The pages that display those records were
cached earlier and must now be flushed. Inject Extbase's cache-clearing helper,
which offers these operations:

..  list-table::
    :header-rows: 1

    *   -   Operation
        -   Effect
    *   -   Clear specific pages
        -   Flush the page cache for one or more page UIDs, by their
            :sql:`pageId_<uid>` tag.
    *   -   Clear all pages
        -   Flush the entire page cache group. Use sparingly — it discards the
            cache for the whole site.
    *   -   Register a record for clearing
        -   Record a table and UID whose pages should be flushed at the end of the
            request. This is what :ref:`automatic cache clearing
            <extbase-caching-autoclearing>` uses internally.

..  literalinclude:: _snippets/_ManualCacheFlush.php
    :caption: EXT:my_extension/Classes/Service/ConferenceImportService.php

..  note::

    This helper is marked :php:`@internal`. Prefer
    :ref:`automatic cache clearing <extbase-caching-autoclearing>` or the frontend
    cache collector where they fit; reach for the helper only when you genuinely
    need to flush already-cached pages from your own code.


How records trigger cache clearing when they change is the subject of the next
page.

..  seealso::

    *   `Automatic cache clearing on record changes <https://docs.typo3.org/permalink/extbase-caching-autoclearing>`_ — how repository writes flush the tagged pages.

    *   `Non-cacheable actions <https://docs.typo3.org/permalink/extbase-caching-noncacheable>`_ — the alternative you usually do not want; cache tags let you keep the cache instead.
