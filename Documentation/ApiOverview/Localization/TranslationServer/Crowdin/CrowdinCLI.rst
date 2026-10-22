:navigation-title: Crowdin CLI

..  include:: /Includes.rst.txt
..  index:: pair: Crowdin; CLI
..  _crowdin-cli:

=====================
Crowdin CLI for TYPO3
=====================

The `Crowdin CLI for TYPO3 <https://github.com/FriendsOfTYPO3/crowdin-cli>`__
is a command line tool for TYPO3 projects on
`Crowdin <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-server-crowdin>`_.
It is aimed at proofreaders and Crowdin project managers: it reviews and approves
suggestions in bulk, cleans up duplicate suggestions, exchanges whole
translation files, and reports on the active translators and proofreaders of the TYPO3 Core and extensions.

This page summarizes what the tool can do. The commands, their options and
example calls are described in the
`README of the tool <https://github.com/FriendsOfTYPO3/crowdin-cli#readme>`__.

..  contents::
    :local:

..  _crowdin-cli-requirements:

Requirements and setup
======================

The tool is a standalone PHP application, not a TYPO3 extension. It needs
PHP 8.5 with the extensions `json` and `zip`, and is installed with Composer.

It connects with a Crowdin personal access token with the scope "Projects".
To approve translations, the owner of the token needs the proofreader or the
manager role in the project. The reporting commands need further token scopes
and the manager role.

Before the first use, the tool stores the list of projects and their
languages locally.

See `Requirements <https://github.com/FriendsOfTYPO3/crowdin-cli#requirements>`__
and `Installation <https://github.com/FriendsOfTYPO3/crowdin-cli#installation>`__
in the README.

..  _crowdin-cli-project-overview:

Project overview
================

*   List the projects, with the ID the other commands expect and, optionally,
    their languages.
*   Show the translation status of a project per language: the percentage of
    approved strings, of strings translated but not approved yet, and the
    sum of both.

See `List projects <https://github.com/FriendsOfTYPO3/crowdin-cli#list-projects>`__
and `Translation status of a project <https://github.com/FriendsOfTYPO3/crowdin-cli#translation-status-of-a-project>`__.

..  _crowdin-cli-review:

Reviewing and approving translations
====================================

Guided review
    The `interactive` command walks through the whole review with questions:
    project, language, and suggester. It then shows the pending suggestions
    in chunks, with source and translation side by side. A chunk can be
    approved as a whole, except for some suggestions, or only in part, and
    single suggestions can be deleted. Strings with several competing
    suggestions are reviewed one at a time, and approving one of them can
    delete the others. See
    `Guided review <https://github.com/FriendsOfTYPO3/crowdin-cli#guided-review-interactive>`__.

Listing unapproved translations
    Lists the pending suggestions of a language with author, date, source
    text, competing suggestions, and the currently approved translation, if
    there is one. The list can be filtered by user and by file path. See
    `Review unapproved translations <https://github.com/FriendsOfTYPO3/crowdin-cli#review-unapproved-translations>`__.

Bulk approval
    Approves translations by ID, by user, by file path, or by a combination
    of these. A dry run shows what would be approved, and competing
    suggestions for the same strings can be deleted along the way. See
    `Approve translations <https://github.com/FriendsOfTYPO3/crowdin-cli#approve-translations>`__.

Revoking approvals
    Approvals made with the tool are logged per session, and a session can be
    revoked as a whole. Approvals made in the Crowdin web interface and
    deleted suggestions cannot be restored this way. See
    `Revoke approvals <https://github.com/FriendsOfTYPO3/crowdin-cli#revoke-approvals>`__.

Cleaning up duplicate suggestions
    Deletes suggestions whose text is identical to the approved translation or
    to an older suggestion for the same string. The oldest suggestion is kept,
    so its author keeps the credit. See
    `Clean up duplicate suggestions <https://github.com/FriendsOfTYPO3/crowdin-cli#clean-up-duplicate-suggestions>`__.

Glossary suggestions
    Crowdin stores the glossary of a TYPO3 project as a file, so suggested
    glossary translations are reviewed and approved with the same commands,
    filtered by the path of that file. See
    `Glossary suggestions <https://github.com/FriendsOfTYPO3/crowdin-cli#glossary-suggestions>`__.

..  _crowdin-cli-translation-files:

Exchanging translation files
============================

Download
    Has Crowdin build the translation files of a project in one language,
    then downloads and extracts them. Suggestions are included unless only
    approved translations are requested. Crowdin always builds the whole
    project, a subtree cannot be downloaded on its own.

Upload
    Uploads locally edited XLIFF files back to the project. Each file is
    matched to its source file, and only translations that differ from what
    Crowdin already shows are sent. They arrive as suggestions by default,
    and can be approved directly instead.

See `Translation files <https://github.com/FriendsOfTYPO3/crowdin-cli#translation-files>`__.

..  _crowdin-cli-reporting:

Reporting
=========

*   List the members with the proofreader permission per language.
*   Rank the contributors of a project in one language by translated or
    approved strings, optionally for a period of time. The figures come from
    the "Top Members" report of Crowdin.

See `Reporting <https://github.com/FriendsOfTYPO3/crowdin-cli#reporting>`__.

..  _crowdin-cli-scripting:

Use in scripts
==============

Every command except the guided review can return its result as a JSON
document on standard output, while progress messages go to standard error. A
failure returns an exit code other than 0 and an error document. Commands
that change data must then be confirmed by an option, as they cannot ask.

See `JSON output for scripts <https://github.com/FriendsOfTYPO3/crowdin-cli#json-output-for-scripts>`__.
