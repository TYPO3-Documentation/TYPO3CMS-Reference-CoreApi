.. include:: /Includes.rst.txt

.. _console-command-reference:

=================
Command Reference
=================

This is a list of console commands provided by TYPO3 core extensions.

In the following list, the commands are tagged with one of the following:

command (schedulable):
    is a console command (based on Symfony commands) which can be run from
    the command line, but can also be run via the scheduler (by selecting
    the task "Execute console commands").

command only:
    is a console commands (based on Symfony commands) which is not available
    in the scheduler.

Further information:

*   :ref:`symfony-console-commands`

.. contents::
    :depth: 2
    :local:
    :caption: Table of contents (on this page)

general commands
================

Running the typo3 command without parameters will show a list of all commands.
This is the same as running the command list.

list
----

Show a list of all commands, grouped by (command) namespace. The namespace is
automatically determined by the first part of the command name before the
colon (":"). It has nothing to do with the PHP namespace.

help
----

Displays help for a command.

Example:

.. code-block:: shell
    :caption: console command

    php vendor/bin/typo3 help redirects:checkintegrity


Is the same as running:

.. code-block:: shell
    :caption: console command

    php vendor/bin/typo3 redirects:checkintegrity -h


EXT:core
========

.. _console-command-reference_backend_user_create:

backend:user:create: Create a backend user
------------------------------------------

*command only*

This is not available in the scheduler, but is also available in the Admin tool
:guilabel:`Maintenance > Create Administrative User`.

.. _console-command-reference_backend_lock:

backend:lock: Lock the TYPO3 Backend
------------------------------------

*command (schedulable)*

It is possible to lock the backend, so that users cannot log in and existing
sessions will be terminated. This can be used for example during administrative
tasks, major updates, during a security breach and in particular during
tasks which make it necessary to restrict editing.

Use :ref:`backend:unlock <console-command-reference_backend_unlock>` to unlock
the backend again.

.. _console-command-reference_backend_resetpassword:

backend:resetpassword
---------------------

*command only*

Trigger a password reset for a backend user

.. _console-command-reference_backend_unlock:

backend:unlock
--------------

*command (schedulable)*

Unlock the TYPO3 Backend.

.. _console-command-reference_cache_flush:

cache:flush
-----------

*command only*

Clear cache.

Optionally use the -g option to specify the cache group to clear. Without
the option, all caches are cleared.

For a list of cache groups, see :ref:`console-command-reference_cache_warmup`.

.. _console-command-reference_cache_warmup:

cache:warmup
------------

*command only*

Cache warmup.

Optionally use the -g option to specify the cache group to warmup. Without
the option, all caches are warmed up.

Cache groups:

*   system
*   pages
*   di (dependency injection cache)
*   all

Examples:

.. code-block:: shell
    :caption: console command

    php vendor/bin/typo3 -g system

.. attention::

    This does not warmup all pages. This is just a basic warming up of caches.

.. _console-command-reference_dumpautoload:

dumpautoload
------------

*command only*

.. attention::

    Only relevant in non-Composer mode! In Composer mode composer dump-autoload
    can be used.

Updates class loading information in non-composer mode.

This command does not have a namespace and is thus shown at the top if listing
all commands.

Autoloading can also be triggered in Admin Tools :guilabel:`Maintenance >
Rebuild PHP Autoload Information`.

It is usually not necessary to run this command. If sextension are installed via
the Extension Manager, autoloading of classes is performed automatically. However,
it may be necessary to install an extension via Git or other means and then
it is necessary to manually flush the cache and rebuild the PHP autoload
information.

.. _console-command-reference_backend_extension_list:

extension:list
--------------

*command only*

Shows the list of extensions available to the system.

.. _console-command-reference_mailer_spool_send:

mailer:spool:send
-----------------

*command (schedulable)*

alias: swiftmailer:spool:send

Sends emails from the spool.

.. _console-command-reference_messenger_consume:

messenger:consume
-----------------

*command (schedulable)*

Consume messages.

This is part of the feature :ref:`Adopt Symfony Messenger as a message bus and queue
<message-bus>` introduced in TYPO3 v12.

.. _console-command-reference_referenceindex_update:

referenceindex:update
---------------------

*command (schedulable)*

Update the reference index of TYPO3

It is recommended to run this regularly, e.g. once a day.

It is also possible to run the reference index check or update in the "DB check"
System module.

It is important for the reference index to be kept up-to-date because
the reference index keeps track of references (connections) between records
(e.g. files, pages). For example if a page links to another page using a page
link a connection is formed from page A via the link to page B. If page B
is deleted, the link will no longer work. The same is true for links to files.
It is possible to see the number of references for a file in the filelist.
This uses the reference index. If no references are displayed, editors might
delete the file, unaware that it is still being used.

In theory, the reference index will be automatically updated when
references change, but for some reason this may not always be the case.

It is the responsibility of DataHandler to update the reference index. Changes
in content which are performed via DataHandler will initiate an update of the
reference index, while changes which are performed via direct database changes
(e.g. via QueryBuilder) will not.

.. _console-command-reference_site_list:

site:list
---------

*command only*

Shows the list of sites available to the system.

.. _console-command-reference_site_show:

site:show
---------

*command only*

Shows the configuration of the specified site.

Example: show site information for site "t3intro":

.. code-block:: shell
    :caption: console command

    php typo3/sysext/core/bin/typo3 site:show t3intro

EXT:extensionmanager
====================

.. _console-command-reference_extension_setup:

extension:setup
---------------

*command only*

Set up extensions. This will perform necessary setup after installing or
updating an extension (including system extensions!).

.. attention::

    This is only relevant for non-Composer installations. Extensions are
    automatically setup when installed via the Extension Manager in non-Composer
    mode.

This includes, but is not limited to:

*   Update the database based on the database schema supplied by the extension
    (in :file:`ext_tables.sql`).
*   Import site configuration from the extension.
*   ...

After running this command, it is usually necessary to also flush the cache.

EXT:impexp
==========

.. _console-command-reference_impexp_export:

impexp:export
-------------

*command (schedulable)

Exports a T3D / XML file with content of a page tree.

More information can be found in the impexp documentation:

*   :ref:`ext_impexp:command_line`

.. _console-command-reference_impexp_import:

impexp:import
-------------

*command (schedulable)*

Imports a T3D / XML file with content into a page tree.

More information can be found in the impexp documentation:

*   :ref:`ext_impexp:command_line`

EXT:install
===========

.. _console-command-reference_language_update:

language:update
---------------

*command (schedulable)*

Update the language files of all activated extensions.

The language update can also be run via Admin Tools
:guilabel:`Maintenance > Manage Language Packs`.

.. _console-command-reference_upgrade_run:

upgrade:run
-----------

*command only*

Run upgrade wizard. Without arguments all available wizards will be run.

The upgrade wizards can also be run via Admin Tools
:guilabel:`Upgrade > Upgrade Wizard`.

.. _console-command-reference_upgrade_list:

upgrade:list
------------

*command only*

List available upgrade wizards.

EXT:lowlevel
============

.. _console-command-reference_cleanup_flexform:

cleanup:flexforms
-----------------

*command (schedulable)*

Updates all database records which have a FlexForm field and the XML data does
not match the chosen datastructure.

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`

.. _console-command-reference_cleanup_localprocessedfiles:

cleanup:localprocessedfiles
---------------------------

*command (schedulable)*

Delete processed files and their database records.

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`


.. _console-command-reference_cleanup_deletedrecords:

cleanup:deletedrecords
----------------------

*command (schedulable)*

Permanently deletes all records marked as "deleted" in the database.

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`

.. _console-command-reference_cleanup_missingrelations:

cleanup:missingrelations
------------------------

*command (schedulable)*

Find all record references pointing to a non-existing record.

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`

.. _console-command-reference_cleanup_orphanrecords:

cleanup:orphanrecords
---------------------

*command (schedulable)*

Find and delete records that have lost their connection with the page tree.

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`

.. _console-command-reference_syslog_list:

syslog:list
-----------

*command (schedulable)*

Show entries from the sys_log database table of the last 24 hours.

.. note::

    This is a schedulable command, but it does not make sense currently to run
    this via the scheduler since this command will output information on the
    console. If you schedule it via the scheduler and then run it via the
    command line with scheduler:run, it will also not output any information.
    Just run the command on the command line directly!

Example output:

.. code-block:: text

    Show entries from the sys_log database table of the last 24 hours.
    ==================================================================

    -------- ---------------- --------- ----------------------------------------------------------------------------------------------------------------------------------
     Log ID   Date & Time      User ID   Message
    -------- ---------------- --------- ----------------------------------------------------------------------------------------------------------------------------------
     87       13-06-23 06:55   1         Scheduler task "Execute console commands" (UID: 11, Class: "TYPO3\CMS\Scheduler\Task\ExecuteSchedulableCommandTask") was updated
     86       13-06-23 06:54   1         Scheduler task "Execute console commands" (UID: 11, Class: "TYPO3\CMS\Scheduler\Task\ExecuteSchedulableCommandTask") was added
     85       13-06-23 06:19   1         User system logged in from ###IP###
     84       12-06-23 19:08   1         User system logged in from ###IP###
    -------- ---------------- --------- ----------------------------------------------------------------------------------------------------------------------------------

This command is supplied by the system extension lowlevel. More information
about this extension:

*   :ref:`ext_lowlevel:command-line`

EXT:redirects
=============

.. _console-command-reference_redirects_checkintegrity:

redirects:checkintegrity
------------------------

*command (schedulable)*

Check integrity of redirects.

The output can also be viewed in the system report.

More information is available in the redirects documentation:

*   :ref:`ext_redirects:redirects-checkintegrity`

.. _console-command-reference_redirects_cleanup:

redirects:cleanup
-----------------

*command (schedulable)*

Cleanup old redirects periodically for given constraints like days, hit count
or domains.

More information is available in the redirects documentation:

*   :ref:`ext_redirects:redirects-cleanup`

EXT:scheduler
=============

.. _console-command-reference_scheduler_run:

scheduler:run
-------------

*command only*

Start the TYPO3 Scheduler from the command line.

.. _console-command-reference_scheduler_execute:

scheduler:execute
-----------------

*command only*

Execute given Scheduler tasks. You must use the id (uid) of an existing
scheduler task.

Example:

.. code-block:: shell
    :caption: command line

    php vendor/bin/typo3 scheduler:execute -i 43 -f


.. _console-command-reference_scheduler_list:

scheduler:list
--------------

*command only*

List all Scheduler tasks.

EXT:styleguide
==============

The styleguide extension is a very helpful tool for developers, used in core
development and for viewing FormEngine / TCA styles in the backend. It is
usually not used in production.

.. _console-command-reference_styleguide_generate:

styleguide:generate
-------------------

*command only*

Generate page tree for Styleguide TCA backend and/or Styleguide frontend.

The commands are not available in the scheduler but generating the page tree
can also be performed in the TYPO3 backend by selecting the helpmenu (in the
topbar, click on "?") and then :guilabel:`Styleguide > Index`.

.. _console-command-reference_styleguide_kauderwelsch:

styleguide:kauderwelsch
-----------------------

*command only*

Generate some bacon text.

EXT:workspaces
==============

.. _console-command-reference_cleanup_previewlinks:

cleanup:previewlinks
--------------------

*command (schedulable)*

Clean up expired preview links from shared workspace previews.

.. note::

    This command is supplied by the workspaces extension, even though it is
    listed in the "cleanup" namespace together with the other cleanup commands
    supplied by EXT:lowlevel.

More information can be found in the workspaces extension manual:

* :ref:`ext_workspaces:scheduler`

.. _console-command-reference_cleanup_versions:

cleanup:versions
----------------

*command (schedulable)*

.. note::

    This command is supplied by the workspaces extension, even though it is
    listed in the "cleanup" namespace together with the other cleanup commands
    supplied by EXT:lowlevel.

Find all versioned records and possibly cleans up invalid records in the database.

.. _console-command-reference_workspace_autopublish:

workspace:autopublish
---------------------

*command (schedulable)*

Publish a workspace with a publication date.

More information can be found in the workspaces extension manual:

* :ref:`ext_workspaces:scheduler`
