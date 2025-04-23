:navigation-title: Server installations

..  _direct-server-workflow:

=================================================
Installing and using TYPO3 directly on the server
=================================================

For very small TYPO3 projects or when you're under time pressure, working
directly on the server can be an acceptable approach.

Some hosting providers offer preinstalled TYPO3 installations, usually in
classic mode, where you do not have to install TYPO3 your self.

..  contents:: Table of contents

..  toctree::
    :glob:
    :titlesonly:

    *

..  _direct-server-installation:

Chose the method of installation
================================

If your hosting does not come with a preinstalled TYPO3 project you can install
it yourself.

First you must decide on weather to use Composer or not.

..  _direct-server-installation-composer-if:

Use Composer if:
----------------

-   Your hosting environment supports using the command line and Composer.
-   You are comfortable using the command line.
-   You want better control over TYPO3 and extension versions.
-   You plan to use version control (like Git) and a local development setup in
    the future.
-   You want easier updates and cleaner project structure.

Continue with :ref:`installation-composer`.

..  _direct-server-installation-classic-if:

Use the non-Composer (classic) method if:
-----------------------------------------

-   Your hosting environment is limited or does not support Composer.
-   You are not comfortable using the command line and Composer.
-   You prefer to upload files manually via FTP.

It is perfectly fine to start with the classic installation method if you cannot take
the time right now to learn Composer, Git, or deployment workflows. TYPO3 can
still run well in this setup, especially for smaller projects. Just be aware
that as your project grows or you take on more work, learning these tools will
make your life easier in the long run. You can
`Migrate to Composer <https://docs.typo3.org/permalink/t3coreapi:migratetocomposer>`_
later on.

..  include:: /Includes.rst.txt

..  _direct-server-workflow-pro-con:

Quick wins & caution flags
==========================

..  _direct-server-when:

When it makes sense
-------------------

This workflow is useful when:

-   You want to try out TYPO3 without having to figure out installation etc.
-   The project is very small (a landing page for a campaign or page for a local sports club).
-   Only one person is working on the project.
-   You need to deliver a fast prototype or campaign page.
-   There is no immediate need for collaboration, version control, or automation.

In these cases, skipping complex :ref:`deployment <deployment-what-why>` workflows can be
a valid short-term decision.

..  _direct-server-risks:

What can go wrong
------------------

Despite the convenience, there are significant risks:

**Instant Mistakes**: All changes go live immediately. A typo can take
your site down.

**Updates are harder**: Without a clean setup or version control, updates can
break things, and it is hard to know what was changed or how to fix it.

**Untracked Changes**: Without documentation or Git, it is easy to forget
what was changed and why.

**No Version Control**: Overwriting files without Git means no history, no
rollback, and no recovery if something breaks.

**Collaboration Conflicts**: Multiple developer working directly on the live
server can overwrite each other's changes.

**Non-reproducible Environments**: Manual changes build up over time, making
the setup hard to replicate elsewhere (for testing or staging).

.. _direct-server-safe:

How to make it safer
--------------------

If you must work directly on the server, here are some best practices to
reduce risk:

**Backups**: Regularly back up the file system and database. Use automated
tools or manual exports. Store backups off the live server.

**Use Git locally**: Even without deployment workflows, using Git locally lets
you track changes before uploading manually.

**Avoid changing Core files** in classic installations do not make changes in
the folder :path:`typo3` or :path:`typo3_source`. In Composer-based installations
make no changes in the folder :path:`vendor`.

**Manual changelogs**: Keep a `CHANGES.md` or notes file listing every change.
This is especially helpful when revisiting a project later.

**Avoid direct database editing**: Use the TYPO3 backend instead of modifying
the database through tools like phpMyAdmin.

**Restrict Access**: Limit server and backend access to trusted users. Avoid
casual live editing with full admin permissions.
