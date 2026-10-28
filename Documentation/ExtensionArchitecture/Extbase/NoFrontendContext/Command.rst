:navigation-title: Commands

..  include:: /Includes.rst.txt
..  index:: Extbase; Command line
..  _extbase-no-frontend-command:

===========================
Extbase on the command line
===========================

Commands are how an extension does work on a schedule or on demand: importing
data, sending notifications, rebuilding derived records, cleaning up. Reusing
the domain models and repositories an extension already has keeps that work
expressed in the same terms as the rest of the extension.

A command runs without a request. Extbase reads its configuration from the
request, so in a command it has none: no TypoScript, no storagePid, no site
and no language. Part of Extbase copes with that, and part of it does not.
This page shows what a command can use, what it has to supply itself, and
when another API is the better fit.

How to write and register the command itself is described in
:ref:`Symfony commands in TYPO3 <symfony-console-commands>`.

..  contents:: Table of contents
    :local:


..  _extbase-no-frontend-command-persistence:

What Extbase persistence does without a request
===============================================

Repositories work in a command. The persistence layer is deliberately
allowed to run without a request and falls back to fixed defaults where it
would otherwise read configuration:

*   **The storagePid is `0`.** Queries search page `0` alone, which for most
    tables holds no records. A table whose records are stored at the root
    level is not restricted to pages at all, so its queries find records
    anyway.
*   **The language is the default language**, see :ref:`Localization outside
    the frontend context <extbase-localisation-no-frontend>`.
*   **Hidden records are left out**, and so are records outside their start
    and end time. Restrictions to frontend user groups do not apply, as there
    is no frontend user.
*   **New records are stored on page `0`**, unless the object names a page
    itself.

A command that works with records in a folder therefore names that folder.
The following sections show how.


..  _extbase-no-frontend-command-storage-pid:

Telling an Extbase repository where to look from a command
==========================================================

The pages a query searches can be set on its query settings with
:php:`setStoragePageIds()`. A repository method can take them as an argument,
so the caller decides:

..  literalinclude:: _snippets/_ConferenceCommandRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php
    :visible-lines: 13-32

The pages are used exactly as given. The :typoscript:`recursive` setting that
adds subpages in a plugin is applied while Extbase reads its configuration,
which does not happen in a command. To include subpages, a command can
expand the list with
:php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::getPageIdsRecursive()`,
for example from a folder and a depth given on the command line:

..  literalinclude:: _snippets/_UnpublishPastConferencesCommand.php
    :caption: EXT:my_extension/Classes/Command/UnpublishPastConferencesCommand.php
    :visible-lines: 17-59

Other ways to pass the folder work just as well, for example a value from the
extension configuration. More on building the page list is in
:ref:`Building the storagePid array from editor input
<extbase-persistence-storagepid-build>`, and on the query settings in
:ref:`Overriding the storagePid for a single query
<extbase-persistence-storagepid-override>`.

A command that creates records can set the page on each new object with
:php:`setPid()`. Otherwise Extbase stores it on page `0`.


..  _extbase-no-frontend-command-language:

Choosing the language in an Extbase command
===========================================

A command has no site and no language, so its queries use the default
language. A command that works with translated records can build a language
aspect for the language it needs and pass it to the query settings. This is
described in :ref:`Setting the language explicitly
<extbase-localisation-no-frontend-explicit>`.


..  _extbase-no-frontend-command-persist:

Saving changes from an Extbase command with `persistAll()`
==========================================================

In a plugin or a backend module, Extbase writes all changes at the end of the
request. A command is not such a request, and nothing writes the changes for
it. Changed, added and removed objects stay in memory until the command calls
:php:`persistAll()` of the persistence manager:

..  literalinclude:: _snippets/_UnpublishPastConferencesCommand.php
    :caption: EXT:my_extension/Classes/Command/UnpublishPastConferencesCommand.php
    :visible-lines: 61-73

Without the call, the command reports success and the database stays
unchanged. More about when Extbase writes is described in :ref:`Forcing a
write with persistAll() <extbase-persistence-queries-persistall>`.


..  _extbase-no-frontend-command-fails:

What fails in an Extbase command
================================

Everything outside the persistence layer depends on the request. Controllers,
views, and anything that reads :typoscript:`plugin.tx_<extension>` settings
cannot be used in a command. Reading the configuration throws a
:php:`\TYPO3\CMS\Extbase\Configuration\Exception\NoServerRequestGivenException`.
Catching it does not help, because the configuration the code needs is not
there.

Failing is the better outcome here. A controller that ran without its
configuration would produce output that only looks right.

..  warning::

    Some commands set :php:`$GLOBALS['TYPO3_REQUEST']` to a request they build
    themselves, for example to generate links or to render a Fluid email.
    Extbase then reads its configuration from that request, and the
    persistence layer no longer falls back to its defaults:

    *   With a simulated frontend request, every repository query throws an
        exception, unless the request carries the full frontend TypoScript.
    *   With a simulated backend request, queries include hidden records and
        records outside their start and end time, as they do in a backend
        module.

    Pass a simulated request to the API that needs it rather than storing it
    in the global, see :ref:`Simulating a frontend request in TYPO3 commands
    <console-command-tutorial-fe-request>`.


..  _extbase-no-frontend-command-database-api:

When the database API fits a command better
===========================================

Extbase is worth its cost in a command when the command works with the
domain: it applies the logic of the models, follows their relations, and uses
the repository methods the rest of the extension uses.

A command that only reads or writes rows does not need any of that. The
:ref:`database API <database>` does the same work without objects, without a
storagePid, and without anything to establish first. It is the better choice
for bulk changes, such as updating thousands of rows in one statement. A
change that editors should see in the record history, or that should trigger
the hooks of other extensions, belongs in :ref:`DataHandler
<datahandler-basics>` instead.


..  _extbase-no-frontend-command-next:

Next steps for Extbase on the command line
==========================================

A middleware runs inside a request, but before Extbase gets its
configuration, so it meets the same defaults as a command. See
:ref:`Extbase in middlewares <extbase-no-frontend-middleware>`.

The overview of all contexts without a frontend is in :ref:`Using Extbase
outside a frontend request <extbase-no-frontend>`.
