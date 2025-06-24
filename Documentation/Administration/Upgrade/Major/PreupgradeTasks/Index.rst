:navigation-title: Pre-upgrade

..  include:: /Includes.rst.txt
..  _preupgradetasks:

==============================================
Pre-upgrade tasks for major TYPO3 Core updates
==============================================

Before starting the upgrade check your system for compatibility with a newer
TYPO3 version.

*   Before you upgrade to the next major version, make sure you have run all
    Upgrade Wizards of the current TYPO3 major version.

*   Check for deprecations: Enable the deprecation log and let it log all
    deprecations for a while.

*   Alternatively (or additionally) run the
    :ref:`extension scanner <t3coreapi:extension-scanner>` and
    :ref:`handle deprecations <handling-deprecations>` (below).

*   Check installed extensions for versions compatible to the target TYPO3
    version

*   Try the upgrade on a development system first or create a parallel instance

Check that all system requirements for upgrading are met:

*   See :ref:`t3start:system-requirements`

..  contents:: Table of contents

..  _preupgradetasks_make_a_backup:

Make a backup
=============

Make a backup first! If things go wrong, you can at least go back to the old
version. You need a backup of

*   all files of your TYPO3 installation (by using FTP, SCP, rsync, or any other
    method)

*   the database (by exporting the database to an SQL file)

Also, you may prefer to upgrade a copy of your site first, if there have been a
lot of changes and some of them might interfere with functions of your site.
See the :doc:`changelog <ext_core:Index>` to check that.

For more detailed information about TYPO3 backups see :ref:`t3coreapi:security-backups`
in *TYPO3 Explained*.

..  _update_reference_index:

Update Reference Index
======================

..  tip::
    As the reference index might take some time, especially on instances not
    running it regularly, an upgrade via
    :ref:`command line (CLI) <t3coreapi:symfony-console-commands>` is
    recommended to avoid a timeout.


..  _reference-index:

With command line (recommended)
-------------------------------

To run the reference index update, execute in the root folder of your project:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 referenceindex:update

    ..  group-tab:: Classic mode installation (No Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 referenceindex:update


..  tip::
    Use :bash:`referenceindex:update 2> /dev/null` to suppress the progress
    output, for example, if the command is executed by a cronjob.


..  _reference-index-gui:

Without command line
--------------------

Still in your old TYPO3 version, go to the
:guilabel:`System > DB check` module and use the
:guilabel:`Manage Reference Index` function.

Click on :guilabel:`Update reference index` to update the reference index. In
case there is a timeout, and you do not have CLI access (see above) you might
have to run the update multiple times.

..  note::
    The :doc:`lowlevel system extension <ext_lowlevel:Index>` must be installed
    for the mentioned backend module.

..  tip::
    As the reference index might take some time, especially on instances not
    running it regularly, an upgrade via
    :ref:`command line (CLI) <t3coreapi:symfony-console-commands>` is
    recommended to avoid a timeout.

With command line (recommended)
-------------------------------

To run the reference index update, execute in the root folder of your project:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 referenceindex:update

    ..  group-tab:: Classic mode installation (No Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 referenceindex:update


..  tip::
    Use :bash:`referenceindex:update 2> /dev/null` to suppress the progress
    output, for example, if the command is executed by a cronjob.

Without command line
--------------------

Still in your old TYPO3 version, go to the
:guilabel:`System > DB check` module and use the
:guilabel:`Manage Reference Index` function.

Click on :guilabel:`Update reference index` to update the reference index. In
case there is a timeout, and you do not have CLI access (see above) you might
have to run the update multiple times.

..  note::
    The :doc:`lowlevel system extension <ext_lowlevel:Index>` must be installed
    for the mentioned backend module.


..  _check-the-changelog-and-news-md:

Check the ChangeLog
===================

In addition to the deprecations you may want to read the information about important
changes, new features and breaking changes for the release you are updating to.

The changelog is divided into four sections "Breaking Changes", "Features", "Deprecation" and
"Important". Before upgrading you should at least take a look at the sections "Breaking Changes"
and "Important" - changes described in those areas might affect your website.

..  tip::
    Breaking changes should be of no concern to you if you already handled the
    deprecations before upgrading.

The detailed information contains a section called "Affected Installations" which contains hints
whether or not your website is affected by the change.

There are 3 different methods you can use to read the changelogs:

#.  Look through the :doc:`changelogs <ext_core:Index>`
    online. This has the advantage that code blocks will be formatted nicely with
    syntax highlighting.
#.  Read the changelogs in the backend: :guilabel:`Upgrade > View Upgrade Documentation`.
    This has the advantage that you can filter by tags and mark individual changelogs
    as done. This way, it is possible to use the list like a todo list.
#.  Read the changelog in the :ref:`Extension Scanner <t3coreapi:extension-scanner>`
    (as explained above).

..  include:: /Images/AutomaticScreenshots/Upgrade/UpgradeAnalysis.rst.txt


..  _handling-deprecations:
..  _deprecations:

Resolve deprecations
====================

If you notice some API you are using is deprecated, you should look up the
corresponding :doc:`changelog <ext_core:Index>`
entry and see how to migrate your code corresponding to the documentation.

Since TYPO3 v9 an :ref:`extension scanner <t3coreapi:extension-scanner>` is
included, that provides basic scanning of your extensions for deprecated code.
While it does not catch everything, it can be used as a base for an upgrade. You
can either access the extension scanner via the TYPO3 admin tools (in the
Backend: :guilabel:`Module "Upgrade" > "Scan Extension Files"`)
or as a standalone tool (https://github.com/tuurlijk/typo3scan).

The extension scanner will show the corresponding changelog which contains
a description of how to migrate your code. See :ref:`check-the-changelog-and-news-md`
for more information about the changelogs and how to read them.

In addition, you can use the tool `typo3-rector <https://github.com/sabbelasichon/typo3-rector>`__
to automatically refactor the code for a lot of deprecations.

..  note::

    TYPO3 aims at providing a reliable backwards compatibility between versions:

    *   Minor versions are always backwards compatible - unless explicitly stated
        otherwise (for example in case of security updates)

    *   Major versions may contain breaking changes - normally these are
        deprecated one major version in advance

    *   Most breaking changes usually happen in the first Sprint Release

    If PHP classes, methods, constants, functions or parameters are to be
    removed, they will be *marked as deprecated* first and not removed until the
    next major release of TYPO3. For example: a method that gets deprecated in
    version 12.3.0 will remain fully functional in all 12.x.y releases, but will
    be removed in version 13.

    This strategy gives developers sufficient time to adjust their TYPO3
    extensions, assuming many agencies upgrade from one LTS release to the next
    (usually 1.5 years).


.. _convert_global_extensions:

Convert Global Extensions
=========================

.. include:: ConvertGlobalExtensions.rst.txt
