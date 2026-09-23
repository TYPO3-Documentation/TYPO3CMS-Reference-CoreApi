:navigation-title: Without frontend context

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation-no-frontend:

==============================================
Extbase language handling outside the frontend
==============================================

When Extbase is used in Frontend Context, a site and a language are resolved
before any Extbase code runs. Backend modules,
command line commands and middlewares do not necessarily have that, and the
language is one of the things they may be missing.

This page covers the language consequences only. Whether Extbase can be used in
those contexts at all, and what else has to be established first, is a broader
question covered in :ref:`extbase-no-frontend`.

Extbase asks the Context API for a language aspect wherever it runs, and
gets one created, if none exists yet. Knowing what it gets explains
a class of surprises.

..  _extbase-localisation-no-frontend-default:

The default aspect
==================

The language aspect is created on first access, with the default values of
:php-short:`\TYPO3\CMS\Core\Context\LanguageAspect`: language :php:`0` and the
overlay type :php:`OVERLAYS_ON_WITH_FLOATING`.

In practice this means a backend module or a command behaves as though it were
a site configured with `fallbackType: strict` in the default language, thus
only default language records are considered.

This is rarely what a command wants. A command that sends mails to users,
generates a report or exports data usually needs a language chosen per record
or per recipient, and no part of the environment will supply it.

..  _extbase-localisation-no-frontend-explicit:

Choosing the language explicitly
================================

Because nothing sets the language for you, set it yourself on the query
settings, exactly as described in
:ref:`extbase-localisation-query-settings`.

The following command sends every frontend user a reminder about upcoming
conferences, in the language stored on the user record:

..  literalinclude:: _snippets/_ConferenceReminderCommand.php
    :caption: EXT:my_extension/Classes/Command/ConferenceReminderCommand.php
    :emphasize-lines: 39, 43, 45-46

Because no site is resolved for the command, the site is named explicitly and
each user's language looked up in it. The aspect built from that language is
handed to :php:`findAllForLanguageAspect()` from
:ref:`extbase-localisation-query-settings-aspect`.

The same repository method is therefore usable from the frontend, where
the aspect comes from the site, and from a command, where it comes from
the caller.

..  note::

    Labels are a separate matter. Translating the subject and body of the mail
    means selecting a language for the language service, not for the query.
    See :ref:`extension-localization-php`.

..  seealso::

    :ref:`extbase-no-frontend-command` covers what else a command has to
    establish before Extbase can be used, including the storagePid.

..  _extbase-localisation-no-frontend-backend:

Backend modules
===============

Backend modules fall into two groups, and the difference decides how much
language configuration is available to them.

..  _extbase-localisation-no-frontend-backend-without-page:

Modules without a page tree
---------------------------

A module that manages records independently of the page tree — a global
administration view, a report, a queue — is in the position described above:
no page, therefore no site, therefore the default aspect. Any language other
than the default has to be set on the query settings explicitly, and there is
no site configuration to take a `fallbackType` from.

..  _extbase-localisation-no-frontend-backend-with-page:

Modules with a page tree
------------------------

A module that uses the page tree navigation component knows which page the
editor selected, and a page belongs to a site. That is enough to recover the
full language configuration: the site's languages, their titles for the
language selector, and their `fallbackType`.

Resolve the site from the page, take the language the editor selected, and
build the aspect from it:

..  literalinclude:: _snippets/_ConferenceModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :emphasize-lines: 24-25, 28, 35

:php:`LanguageAspectFactory::createFromSiteLanguage()` is the same call the
frontend uses to turn a site language into a language aspect. A module that
uses it gets the translation handling the frontend would apply to those
records, including the site's `fallbackType` — rather than the default-language
behaviour it would otherwise inherit.

The aspect is then handed to
:php:`findAllForLanguageAspect()` from
:ref:`extbase-localisation-query-settings-aspect`, which sets it on the query
settings and executes the query.

This is the recommended approach whenever a module edits or displays records
that belong to a page tree, because it keeps the module consistent with what
the site shows.

..  seealso::

    -   :ref:`extbase-no-frontend-backend-module` for using Extbase in a
        backend module beyond the language question.
    -   :ref:`extbase-persistence-storagepid-backend` describes the related
        question of where a backend module looks for records, which is also
        resolved differently without a site.

..  _extbase-localisation-no-frontend-relations:

What this means for relations
=============================

Relations behave as they do everywhere else: they are fetched with translation
handling regardless of the aspect on the parent query, and in the language of
the record holding them.

Because the default aspect is the default language, relations of records
fetched in a command are resolved in the default language as well — unless the
parent record was fetched in another language, in which case its relations
follow it.
