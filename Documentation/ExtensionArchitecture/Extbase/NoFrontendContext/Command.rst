:navigation-title: Commands

..  include:: /Includes.rst.txt
..  index:: Extbase; Command line
..  _extbase-no-frontend-command:

===========================
Extbase on the command line
===========================

..  note::

    This page is a work in progress. Content will be added as part of the
    Extbase documentation overhaul.

..  todo::
    Stub page. Planned content: using Extbase from Symfony commands — what has
    to be established, the storagePid trap, and when to use the database API
    instead.

Commands are how an extension does work on a schedule or on demand: importing
data, sending notifications, rebuilding derived records, cleaning up. Reusing
the domain models and repositories an extension already has keeps that work
expressed in the same terms as the rest of the extension.

The essentials:

*   A command runs without any request. None of the frontend TypoScript
    configuration Extbase normally reads has been built, and there is no site
    and no language.
*   The persistence layer is explicitly allowed to run without a request, so
    repositories can be used. Without configuration, though, Extbase has no
    storagePid to work with and queries fall back to searching page :php:`0`
    alone. Ordinary records are stored on real pages, so a command typically
    finds nothing without explicit configuration.
*   The :typoscript:`recursive` setting that expands a storagePid
    down the page tree is applied while the configuration is resolved, which
    does not happen here. Setting a storagePid on the query settings therefore
    selects exactly the pages named, with no descendants. Expanding storagePids therefore is
    an explicit step as well. See
    :ref:`extbase-persistence-storagepid-override`.
*   The rest of Extbase has a hard dependency on the request. Controllers,
    views and everything resolving :typoscript:`plugin.tx_<extension>`
    configuration cannot be used, and attempting it fails rather than
    degrading.
*   The language is not established either, and has to be chosen explicitly.
    See :ref:`extbase-localisation-no-frontend-explicit`.
*   Where a command only needs to read or write database rows, the
    :ref:`database API <database>` does that without Extbase, and without
    anything to establish first.

..  seealso::

    :ref:`Symfony commands in TYPO3 <symfony-console-commands>` for writing and
    registering the command itself.
