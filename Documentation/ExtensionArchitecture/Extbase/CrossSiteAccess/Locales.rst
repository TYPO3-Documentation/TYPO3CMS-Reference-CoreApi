:navigation-title: Language Matching

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Cross-site access
..  _extbase-cross-site-locales:

=============================================
Matching languages between sites with locales
=============================================

Pointing a query at another site's storage folder settles which pages are read.
It does not settle which language, and that is where cross-site reading most
often goes quietly wrong: the query succeeds, returns records, and shows them
in the wrong language.

..  _extbase-cross-site-locales-uids:

Why language UIDs cannot be reused
==================================

A language UID is a number assigned inside one site configuration. It carries
no meaning outside it. Two sites offering the same three languages may number
them differently, and nothing in TYPO3 keeps them aligned.

Consider a shared conference folder, located in the main site and read by the
country site as well:

..  list-table::
    :header-rows: 1

    *   -   Language UID
        -   Main site
        -   Country site
    *   -   `0`
        -   English
        -   Polish
    *   -   `1`
        -   Polish
        -   English
    *   -   `2`
        -   Italian
        -   Italian

The records in the folder carry one :sql:`sys_language_uid` each. A visitor
browsing the country site in Polish arrives with language UID `0`, and a query
made with that UID returns the records stored as UID `0` — the English ones.
No error is raised, because from the database's point of view nothing is wrong.

..  warning::

    This failure is silent and looks like a translation problem rather than a
    configuration one. The records are real, the query is valid, and the only
    symptom is that an unexpected set of languages came back.

..  _extbase-cross-site-locales-join-key:

The locale is the stable identifier
===================================

What *probably is* stable across sites is the locale. A site language for
Italian is `it-IT` in every site that offers Italian, whatever UID it was given
there. The locale is set in the site configuration, is meaningful outside the
site that declares it, and is exactly what two site configurations have in
common. If the locales are really the same across the sites is responsibility
of the integrator, so verify the match before relying on it.

So resolve the language by matching locales, and use the matched language's own
UID for the query:

#.  Take the :php-short:`\TYPO3\CMS\Core\Site\Entity\SiteLanguage` the visitor
    is browsing, from the site being rendered.
#.  Read its locale.
#.  Find the language of the *storage* site with the same locale.
#.  Query with that language.

..  literalinclude:: _snippets/_SharedStorageResolver.php
    :caption: EXT:my_extension/Classes/Service/SharedStorageResolver.php
    :emphasize-lines: 37, 40-42

:php:`getLanguages()` returns the languages of the storage site that are
enabled for frontend output, which is the right set to match against for a
plugin. :php:`getAllLanguages()` includes disabled ones and suits a backend
module that deliberately shows them.

..  important::

    It is not advisable to build a hand-maintained mapping array between the
    sites' language UIDs or to keep the mapping in a site setting. Both encode
    a relationship that the site configurations already state, and both go
    stale the moment somebody adds a language — silently, and in exactly the
    way described above. The locale is the join key; read it at runtime.

..  _extbase-cross-site-locales-aspect:

Building the query from the matched language
============================================

The matched language is turned into a language aspect with
:php:`\TYPO3\CMS\Core\Context\LanguageAspectFactory::createFromSiteLanguage()`,
the same call the frontend uses. The aspect then carries the storage site's
language UID *and* the storage site's translation behavior:

..  literalinclude:: _snippets/_ConferenceListController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceListController.php

..  _extbase-cross-site-locales-no-match:

When the storage site does not offer the language
=================================================

A locale match can fail. The visitor browses a language the storage site simply
does not have, and no amount of resolving will conjure those records.

There is no correct answer the framework can pick for you, so the extension has
to choose one deliberately:

*   **Fall back to the storage site's default language.** Shown above, and the
    usual choice for a shared catalogue: the visitor sees the records in the
    storage site's main language rather than an empty list.
*   **Show nothing.** Appropriate where displaying untranslated content would
    be wrong — legal texts, or anything the site is obliged to present in one
    language only.

What does *not* work is falling back to the language of the site being
rendered. Its UID means nothing in the storage site, which is the problem this
whole page exists to solve.

..  _extbase-cross-site-locales-fallbacks:

When the two sites disagree about fallbacks
===========================================

`fallbackType` is configured per site language, so the storage site and the
rendering site can disagree about what to do with an untranslated record. The
same shared record can be visible on one site and hidden on another, purely
because of that setting.

Which one applies is decided by where the aspect came from:

..  list-table::
    :header-rows: 1

    *   -   The aspect is built from
        -   Translation behavior follows
    *   -   The rendered site's language, the default when you do nothing
        -   The rendered site. Records are shown or hidden according to the
            site the visitor is on, using a language UID that does not belong
            to the storage site.
    *   -   The storage site's matched language, as shown above
        -   The storage site. Every site reading the folder treats its records
            the same way.
    *   -   A :php-short:`\TYPO3\CMS\Core\Context\LanguageAspect` you construct
            yourself
        -   Whatever you set, independent of both sites.

Building the aspect from the matched storage language is the recommended
default, and it is what the example does. It makes the shared records behave
consistently wherever they are shown, which is usually the point of sharing
them.

Where the reading site should keep control — a country site that must hide
untranslated content even though the storage site shows it — construct the
aspect explicitly instead: take the language UID from the matched storage
language, and the overlay type and fallback chain manually constructed to suit
your needs. See :ref:`Setting a language aspect on a query
<extbase-localisation-query-settings-aspect>` for building an aspect by hand.

..  _extbase-cross-site-locales-relations:

What this means for relations
-----------------------------

Relations do not follow the aspect you set. Extbase configures relation queries
itself and passes down **the language of the parent record**, not the language
of the request.

For cross-site reading this is the behavior you want, and it falls out for
free: a conference resolved to the storage site's Italian record fetches its
categories in that same language, without the extension arranging anything.

The consequence to be aware of is that a mismatch propagates. Resolve the
parent record to the wrong language and its relations follow it there, which is
why the locale match belongs at the point where the parent query is built
rather than being corrected afterwards.

..  seealso::

    `Localization in Extbase
    <https://docs.typo3.org/permalink/t3coreapi:extbase-localisation>`_ —
    overlay types, the `fallbackType` settings and what each one returns.
