:navigation-title: Cross-site access

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Cross-site access
..  _extbase-cross-site:

================================================
Reading localized records across site boundaries
================================================

An Extbase plugin normally reads records that belong to the site displaying
them. The storage folder sits in the site's own page tree, the language comes
from the site being rendered, and the two agree because they describe the same
site.

As soon as the records are stored outside the current site, they might stop agreeing
on their language configuration. A company-wide list of conferences is
maintained once and shown on every brand site. A group of country sites shares
one product catalogue. A campaign site displays the news of the main site
without maintaining its own. In each case a plugin reads records that belong
to a *different* site than the one being rendered.

There is no separate concept to learn for this. A shared storage folder is not
a special kind of folder — **any site becomes a shared storage the moment
another site takes an interest in what it holds.** What changes is only that
the records and the reader no longer come from the same site configuration.

..  _extbase-cross-site-why-not-storagepid:

Why a wider `storagePid` might not be enough
============================================

The obvious move is to point the
:ref:`storagePid <extbase-persistence-storagepid>` at the other site's folder.
That part does work: the storagePid is a plain list of page UIDs and nothing
constrains it to the current site's page tree.

Where every site involved uses the same language UIDs and the same
`fallbackType`, cross-site reading needs no special attention at all — point
the storagePid at the folder and you are done. This chapter is about the case
where that assumption does not hold, and about not depending on it silently
when it happens to.

The storagePid is the only part of the query that
follows your instruction. Everything else Extbase adds to that query is taken
from the site being rendered:

*   **The language UID** comes from the rendered site. Language UIDs are
    assigned per site and mean nothing outside it. Language `2` may be Polish
    in one site and Italian in another, while the records in the storage folder
    carry one :sql:`sys_language_uid` for every reader.
*   **The `fallbackType`** comes from the rendered site too. The same record
    can be visible on one site and hidden on another, purely because their
    language configurations differ.

Extbase follows the site being rendered, which is exactly
what it should do when the records belong to that site. Once they do not, the
extension has to supply what the site configuration can no longer be trusted
to provide.

..  _extbase-cross-site-what-you-need:

What this chapter covers
========================

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`extbase-cross-site-reading`

        Finding the storage pages of another site and querying them, including the
        case where the folder lies outside the current site's page tree entirely.

    ..  card:: :ref:`extbase-cross-site-locales`

        Resolving *which language to ask for* when the UIDs differ between sites,
        and what to do when the two sites' fallback configurations disagree.

    ..  card:: :ref:`extbase-cross-site-writing`

        Where a new record lands when a repository reads from more than one site,
        and how to pin that target deliberately.

..  seealso::

    *   `The storagePid: where Extbase looks for records <https://docs.typo3.org/permalink/t3coreapi:extbase-persistence-storagepid>`_ — how the storage pages are resolved in the ordinary, single-site case.

    *   `Localization in Extbase <https://docs.typo3.org/permalink/t3coreapi:extbase-localisation>`_ — how language handling works before site boundaries complicate it.

..  toctree::
    :titlesonly:
    :hidden:

    Reading
    Locales
    Writing
