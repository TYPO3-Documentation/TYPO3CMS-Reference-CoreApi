:navigation-title: Maintenance

..  include:: /Includes.rst.txt
..  _admin-tools-maintenance:

=========================
Maintenance (Admin Tools)
=========================

Only available if :composer:`typo3/cms-install` is installed.

The backend module :guilabel:`Admin Tools > Maintenance` offers tools
to system maintainers that are necessary during development or updates.

Some of the tools available here include:

..  todo: describe the other tools

..  contents::

..  _admin-tools-maintenance-flush-cache:
..  _clear-caches:

Flush TYPO3 and PHP Cache
=========================

By clicking the button :guilabel:`Flush cache` you can flush all caches. This is
necessary during development if you changed files like
:ref:`Fluid templates <fluid-templates>`, :ref:`TypoScript files <typoscript>`,
or PHP files.

It is also necessary to flush caches after installing or updating extensions.

You can achieve the same effect by calling

..  code-block:: bash

    ddev typo3 cache: flush

..  note::
    Flushing the cache via the "Clear cache" buttons in the
    Top Bar does not have the same effect. It does not flush
    PHP related caches.


..  _admin-tools-maintenance-database-analyzer:
..  _run-the-database-analyser:
..  _database-analyser:

Analyze Database Structure
==========================

Before running a database compare, try `flushing the cache <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-flush-cache>`_.
This flushes cached TCA definitions that might inadvertently determine the database structure.

Despite its name, this tool not only analyzes the database structure but also
offers to fix it for you.

Database changes can be necessary when TCA files have changed or
extensions installed / updated.

..  _database-analyser-add:

Add tables and columns using the database analyzer
--------------------------------------------------

When the database analyser suggests adding columns or tables you can
safely do so.

..  _database-analyser-remove:

Change or remove columns and tables in the database analyzer
------------------------------------------------------------

Before you remove tables or columns, make a
`database backup <https://docs.typo3.org/permalink/t3coreapi:security-backup-database>`_.

The database analyzer gives you the
possibility to *remove* old and redundant tables and columns from the database.

See also
`Database compare during update and installation <https://docs.typo3.org/permalink/t3coreapi:database-upgrade>`_.

It executes queries to remove these tables and columns so that
your database corresponds to the structure required in the new TYPO3 version.

..  note::
    TYPO3 does not immediately delete tables and fields. Instead, it adds
    a `zzz_deleted_*` prefix to the table names.

    This lets you verify whether they’re truly obsolete or just mistakenly marked
    for deletion. Once confirmed, you can permanently remove them via the wizard.

When you then click "Compare current database with specification" again and you
see the message "Database schema is up to date. Good job!", then all
database updates have been applied.

..  _remove-temporary-assets:

Remove temporary assets
=======================

After an upgrade to a new major version, it might be necessary to delete
temporary files which TYPO3 saves in the :file:`typo3temp/` folder.

In the :guilabel:`Admin Tools > Maintenance` module, click on the
:guilabel:`Remove Temporary Assets > Scan temporary files` button and select the
appropriate folders.

..  _rebuild-autoload-information:

Rebuild PHP autoload information
================================

This tool in module :guilabel:`Admin Tools > Maintenance` is only available
in classic mode installations. If PHP classes are not found even after
`flushing the cache <https://docs.typo3.org/permalink/t3coreapi:admin-tools-maintenance-flush-cache>`_,
rebuilding the autoload information might help.

In Composer mode installations you can use the following Composer command to
achieve the same thing:

..  code-block:: bash

    composer dump-autoload

..  _clear-persistent-database-tables:

Clear persistent database tables
================================

You can use this tool to clear persistent database tables like `sys_log` and
`sys_history` manually.

If you need to clear these tables on a regular basis, set up a task
in the module :guilabel:`System > Scheduler`.

..  _admin-tools-maintenance-create-admin:

Create administrative user
==========================

This tool can be used to create a new administrative backend user with or
without maintainer privileges.

You can also create new backend users using the console:

..  code-block:: bash

    vendor/bin/typo3 backend:user:create

and in the module :guilabel:`System > Backend Users`. Using this module, admins
can create new admins but not system maintainers.

..  _clear-user-settings:

Reset backend user preferences
==============================

You might consider clearing the Backend user preferences. This
can avoid problems if something in the upgrade requires this. Open
:guilabel:`Admin Tools > Maintanance`, scroll to
"Reset user preferences" and click "Reset backend
user preferences".


..  _update_backend_translation:
..  _update-translations:

Manage language packs
=====================

In the module :guilabel:`Admin Tools > Maintenance`, open tool "Manage language
packs". You can add additional languages to be downloaded or update the language
packs for languages already in use.
