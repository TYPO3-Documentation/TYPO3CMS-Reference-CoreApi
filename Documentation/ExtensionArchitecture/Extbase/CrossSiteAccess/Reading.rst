:navigation-title: Reading

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Cross-site access
..  _extbase-cross-site-reading:

======================================
Reading records stored in another site
======================================

Two things have to be settled before a query can return records from another
site: **which pages** to read, and **which language** to ask for. This page
covers the pages. The language has
:ref:`its own page <extbase-cross-site-locales>`.

..  _extbase-cross-site-reading-naming:

Naming the storage pages
========================

The storage pages of another site are ordinary page UIDs, and the
:ref:`storagePid <extbase-persistence-storagepid>` configuration accepts them.
Nothing checks that they belong to the current site.

For a setup with matching language configuration this is all it takes:
configure the shared folder as the storagePid in TypoScript, or let an editor
choose it in the :guilabel:`Behavior > Starting point` field of the plugin, and
every query the repository builds reads from there.

..  hint::

    Hard-coding a page UID in TypoScript ties the extension to one
    installation, so prefer a :ref:`site setting <sitehandling-settings>` or a
    plugin FlexForm field that names the page, and read the value from
    :php:`$this->settings` in the controller.


..  _extbase-cross-site-reading-per-query:

Overriding the storage pages for one query
==========================================

Where the storage pages are decided at runtime — different for each visitor,
each plugin instance or each site — the query settings carry the decision
instead:

..  literalinclude:: _snippets/_CrossSiteConferenceRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

:php:`setStoragePageIds()` replaces the configured storagePid for this one
query. The repository takes both the pages and the language aspect as
arguments, so it makes no assumption about which site either came from. That
keeps it usable from a plugin, a backend module and a command alike.

..  note::

    :php:`setRespectStoragePage(false)` also makes records from other sites
    reachable, by dropping the page restriction altogether. It is a blunt
    instrument for this purpose: the query then searches the whole table,
    including records from sites you never intended to expose, and including
    records an editor has filed somewhere unrelated. Name the pages you want
    rather than removing the restriction.

..  _extbase-cross-site-reading-finding-the-site:

Finding the storage site
========================

Reading the language configuration of the storage site — which the
:ref:`next page <extbase-cross-site-locales>` needs — means resolving the
:php-short:`\TYPO3\CMS\Core\Site\Entity\Site` object it belongs to.
:php:`\TYPO3\CMS\Core\Site\SiteFinder` offers three ways in, and the choice
matters:

..  list-table::
    :header-rows: 1

    *   -   Method
        -   Use it when
    *   -   :php:`getSiteByIdentifier()`
        -   The storage site is known by name from configuration. This is the
            most robust option: the identifier is stable, readable in a site
            setting, and survives page UIDs changing.
    *   -   :php:`getSiteByPageId()`
        -   Only the storage page UID is known. Resolves the site from the page
            it sits in.
    *   -   :php:`getSiteByRootPageId()`
        -   The root page UID of the storage site is known.

..  seealso::

    `Finding a site object with the SiteFinder class <https://docs.typo3.org/permalink/t3coreapi:sitehandling-sitefinder-object>`_
    — full documentation of :php-short:`\TYPO3\CMS\Core\Site\SiteFinder`.

..  _extbase-cross-site-reading-relations:

What this means for relations
-----------------------------

Relation queries ignore the storagePid entirely: Extbase sets
:php:`setRespectStoragePage(false)` on them. Relations therefore reach records
the parent query could never have returned, wherever in the page tree they are
stored.

For cross-site reading this works in your favor — a conference in the shared
folder keeps its categories regardless of which site reads it, and you need do
nothing to make that happen. The same mechanism also means a relation can pull
in a record from a storage folder you did not intend to expose, which is worth
knowing when the related table holds site-specific data.

The language of relations is a separate question, covered on the
:ref:`next page <extbase-cross-site-locales-relations>`.
