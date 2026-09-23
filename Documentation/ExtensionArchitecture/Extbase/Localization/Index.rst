:navigation-title: Localization

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation:

=======================
Localization in Extbase
=======================

An Extbase plugin that lists records will show different records in different
languages — and sometimes a different number of them. This chapter explains
what decides that, starting from the setting you are most likely to have
inherited and working towards the cases you control in code.

..  contents:: On this page
    :local:
    :depth: 1

..  note::

    Whatever this chapter says about an object does not automatically hold for
    the objects it relates to. Relations follow different rules almost
    everywhere, so each section states separately what happens to them.

..  _extbase-localisation-site-configuration:

What the site configuration decides
===================================

Extbase does not decide which language your records are fetched in. It reads
the :ref:`language aspect <context_api_aspects_language>` from the
:ref:`Context API <context-api>` and follows it. In the frontend that
aspect is built from the site configuration.

The setting that decides it is
:ref:`fallbackType <confval-sitehandling-addingLanguages-fallbackType>`, which
each language of a site carries:

..  list-table::
    :header-rows: 1

    *   -   `fallbackType`
        -   A visitor requesting Polish sees
    *   -   `free`
        -   Only records actually stored as Polish records. No translation
            handling at all.
    *   -   `fallback`
        -   Polish conferences, plus the English originals of those that have
            no Polish translation.
    *   -   `strict`
        -   Only conferences that exist in Polish (both with a tranlation
            default and stand alone). Untranslated ones
            disappear from the list.


If a site language sets no `fallbackType`, it is `strict`.

Records marked as *all languages* (:sql:`sys_language_uid = -1`) are returned in
every language, whichever setting is in use.

..  _extbase-localisation-overlay-types:

Language Overlay types
----------------------

Internally each of those settings becomes an *overlay type* on the language
aspect. The names appear in query settings, in
:php:`\TYPO3\CMS\Core\Context\LanguageAspect` and in most discussions of the
topic, so it is worth knowing which is which:

..  list-table::
    :header-rows: 1

    *   -   `fallbackType`
        -   Overlay type
    *   -   `free`
        -   :php:`LanguageAspect::OVERLAYS_OFF`
    *   -   `fallback`
        -   :php:`LanguageAspect::OVERLAYS_MIXED`
    *   -   `strict`
        -   :php:`LanguageAspect::OVERLAYS_ON_WITH_FLOATING`

A fourth overlay type, :php:`LanguageAspect::OVERLAYS_ON`, exists in the class
but no site configuration produces it. It appears only where an aspect is
constructed in PHP, as described in
:ref:`extbase-localisation-query-settings`.

..  seealso::

    `Overlay types <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-language-overlay-types>`_ — what each of the four does, independently of Extbase.

..  versionchanged:: 14.3

    Extbase previously ignored `fallbackType` when fetching records and always
    behaved like `fallback`. It now follows the site configuration, so a
    `strict` site probably returns fewer records than before: :php:`findByUid()`
    on an  untranslated record returns :php:`null` rather than the default
    language record, and untranslated related records are dropped from
    relations. See :ref:`Important: #88886 Extbase persistence respects the language overlay type <changelog:important-88886-1784901300>`.
    To keep a single query behaving as before, set an aspect with
    :php:`OVERLAYS_MIXED` on it as shown in
    :ref:`extbase-localisation-query-settings`.

..  _extbase-localisation-site-configuration-relations:

What this means for relations
-----------------------------

The site configuration governs the records a repository fetches directly. It
does not fully govern their relations.

On a `free` site, a query performs no translation handling — but the relations
of the records it returns still do. A conference fetched without translation
handling can still come back with its categories translated. This is
deliberate: relations are usually stored against the default language record,
so Extbase would otherwise return nothing for them.

The practical consequence is that `free` mode is not "translation handling
switched off" for your whole object graph, only for its roots.

..  _extbase-localisation-query-settings:

Deciding per query in your own extension
========================================

When you maintain the extension, a single query can depart from the site
configuration. Every query carries
:ref:`query settings <extbase-persistence-queries-querysettings>`, and the
language aspect is one of them.

..  _extbase-localisation-query-settings-aspect:

Setting a language aspect
-------------------------

Put a :php-short:`\TYPO3\CMS\Core\Context\LanguageAspect` on the query settings.
This is the supported way to fetch records in a language, or with a translation
behaviour, that differs from the one the site asked for.

Give the repository one method that accepts a finished aspect, rather than one
method per way of choosing a language:

..  literalinclude:: _snippets/_ConferenceRepositoryAspect.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The repository then makes no assumption about where the language came from, and
the same method serves a frontend plugin, a backend module and a command alike.
Choosing the language is a decision for the caller, and there are two ways to
make it.

..  _extbase-localisation-query-settings-from-site:

Deriving the aspect from a site language
----------------------------------------

If your site configuration declares the language configuration you want, create
the language aspect from it. If there is none, you can create the aspect manually.

..  literalinclude:: _snippets/_ConferenceLanguageController_site.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

:php:`LanguageAspectFactory::createFromSiteLanguage()` is the same call the
frontend uses internally. It reads the language UID, the `fallbackType` and
the fallback chain from that one site language, so the three values stay
consistent with each other.

..  _extbase-localisation-query-settings-custom:

Building an aspect that no site configuration produces
------------------------------------------------------

Constructing the aspect by hand, as the action `translatedOnlyAction` does,
is the right move only when you deliberately want behaviour outside what
a site language can express. :php:`LanguageAspect::OVERLAYS_ON` is the
clearest case: it returns translations that have a default language original,
and leaves out records that exist only in the requested language without
a valid default language parent.

..  literalinclude:: _snippets/_ConferenceLanguageController_manual.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

The constructor takes four parameters, each documented as a property of the
aspect in
:ref:`the Context API reference <context_api_aspects_language_properties>`: the
requested language, the language records are fetched in, the overlay type and
the fallback chain. The first two differ only when a page requested in one
language should show the content of another.

Records marked as *all languages* are returned whichever overlay type you set,
so this is not a way to exclude them.

..  warning::

    Constructing a :php-short:`\TYPO3\CMS\Core\Context\LanguageAspect` manually with
    languageUid, overlay type and fallback chain in a combination not declared by
    any site configuration can lead to unexpected results in the delivered record set.
    Make sure to verify especially the fallback chain in such a case, as it relies
    on languageUids that can change in the site configuration without the code ever
    learning about it.

Both routes are used elsewhere in this manual: from
:ref:`outside the frontend <extbase-localisation-no-frontend>`, where no site
implies the language, and when
:ref:`reading records that belong to another site <extbase-cross-site-locales>`.

..  _extbase-localisation-model:
..  _extbase-model-localization:
..  _extbase-localisation-localized-uid:
..  _extbase-model-localizedUid:

Which record you are holding
----------------------------

Once translation handling is involved, the `uid` of a domain object is no
longer simply the `uid` of the row it came from. Extbase keeps both, in
two properties every domain object has:

`uid`
    The identifier of the default language record. This is the one to use when
    building links or storing a reference, because it stays the same in every
    language.

`_localizedUid`
    The identifier of the record the values actually came from — the
    translation, where one was used.

For a conference stored as :sql:`uid:2` in the default language and
:sql:`uid:11` in its Polish translation, a query in Polish returns:

..  list-table::
    :header-rows: 1

    *   -   Translation handling
        -   Default language record
        -   Translated record
    *   -   On (`strict`, `fallback`)
        -   `uid: 2`, `_localizedUid: 2`
        -   `uid: 2`, `_localizedUid: 11`
    *   -   Off (`free`)
        -   `uid: 2`, `_localizedUid: 2`
        -   `uid: 11`, `_localizedUid: 11`

The difference matters when a record is passed back into a query or a link: on
a `free` site the object carries the translated record's own identifier, while
everywhere else it carries the default language one.

A third property, :php:`_languageUid`, holds the language the record belongs
to. It is the property to set when
:ref:`writing a record in a specific language <extbase-localisation-writing-default>`.

..  hint::
    If your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

..  _extbase-localisation-query-settings-all-languages:

Fetching records of all languages
---------------------------------

:php:`setRespectSysLanguage(false)` removes the language restriction from the
query. Records of every language are returned side by side, so a conference
existing in three languages is returned three times.

This is what you want for a listing that deliberately spans languages, such as
a backend overview of all translations of a record. In a frontend list it looks
like duplicates.

..  _extbase-localisation-query-settings-relations:

What this means for relations
-----------------------------

An aspect set on a query applies to the records that query returns. Relations
are fetched by separate queries, which Extbase configures itself, and it
overrules parts of what you set:

*   :php:`setRespectStoragePage(false)` and :php:`setRespectSysLanguage(false)`
    are always applied to relation queries, whatever the parent query said.
*   :php:`OVERLAYS_OFF` is replaced by :php:`OVERLAYS_MIXED`, so relations are
    translation-handled even when the parent query is not.
*   The language of the parent record is passed down, so relations are fetched
    in the language of the record holding them rather than the language of the
    request. Records marked as all languages are exempt.

The overlay type and fallback chain you set are otherwise carried over. In
practice this means you can influence relations, but you cannot switch
translation handling off for them.

..  _extbase-localisation-beyond:

Beyond reading in the frontend
==============================

The rules above describe a plugin reading records in a rendered frontend
request. Three situations depart from that, each on its own page:

:ref:`extbase-cross-site`
    Reading records that belong to another site, where language IDs and
    fallback settings may no longer be the same as for the site you are
    currently handling.

:ref:`extbase-localisation-writing`
    Creating records from frontend forms, where Extbase decides the language
    itself and cannot produce translations.

:ref:`extbase-localisation-no-frontend`
    Backend modules, command line commands and middlewares, where the site and
    language the frontend would have supplied are missing.

..  _extbase-localisation-model:
..  _extbase-model-localization:

Localization of Extbase models
==============================

..  _extbase-localisation-localized-uid:
..  _extbase-model-localizedUid:

Identifiers in localized models
-------------------------------

Domain models have a main identifier :php:`uid` and an additional property
:php:`_localizedUid`.

Depending on whether the `overlay type <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-language-overlay-types>`_
language aspect is enabled (:typoscript:`LanguageAspect::OVERLAYS_ON` or
:typoscript:`LanguageAspect::OVERLAYS_MIXED`) or disabled (:typoscript:`LanguageAspect::OVERLAYS_OFF`),
the identifier contains different values.

When the overlay language aspect is enabled, then the :php:`uid`
property contains the :php:`uid` value of the default language record and
the :php:`uid` of the translated record is kept in the :php:`_localizedUid`.

+------------------------------------------------------------+----------------------------+---------------------------+
| Context                                                    | Record in default language | Translated record         |
+============================================================+============================+===========================+
| Database                                                   | uid:2                      | uid:11, l10n_parent:2     |
+------------------------------------------------------------+----------------------------+---------------------------+
| Domain object values with Overlay language aspect enabled  | uid:2, _localizedUid:2     | uid:2, _localizedUid:11   |
+------------------------------------------------------------+----------------------------+---------------------------+
| Domain object values with Overlay language aspect disabled | uid:2, _localizedUid:2     | uid:11, _localizedUid:11  |
+------------------------------------------------------------+----------------------------+---------------------------+

..  hint::
    If your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

..  _extbase-localisation-translate:

Translating labels
==================

This chapter covers how Extbase handles *records* across languages. Translating
the *labels* of an extension — button captions, flash messages, validation
errors — is a separate topic and handled on dedicated pages:

..  seealso::

    -   :ref:`Translating labels in Extbase <extension-localization-extbase>` —
        in controllers and other PHP code
    -   :ref:`LocalizationUtility API reference <extbase-localization-utility-api>`
        — all parameters of :php:`translate()`
    -   :ref:`Translating labels in Fluid <extension-localization-fluid>` —
        the `<f:translate>` ViewHelper

..  toctree::
    :titlesonly:

    Writing
    NoFrontendContext
