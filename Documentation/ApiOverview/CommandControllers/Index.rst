:navigation-title: Commands

..  include:: /Includes.rst.txt

..  _cli-mode:
..  _cli-mode-dispatcher:
..  _cli-mode-command-controllers:
..  _symfony-console-commands:

======================
Console commands (CLI)
======================

It is possible to run TYPO3 scripts from the command line.
This functionality can be used to set up cron jobs, for example.

TYPO3 uses Symfony commands API for writing CLI (command line interface) commands.
These commands can also be run from the TYPO3
:ref:`scheduler <symfony-console-commands-scheduler>` if this option is not
disabled in the :file:`Configuration/Services.yaml`.

The starting point for the commands differs depending on the type of your
TYPO3 installation.

*   For installations with Composer, the starting point is the project
    folder, which also contains the :file:`composer.json` file of the project.
    The CLI commands usually start with :file:`vendor/bin/typo3`.
*   For Classic mode installations (without Composer), the starting point is usually
    the web root, so CLI commands start with :file:`typo3/sysext/core/bin/typo3`.

..  attention::
    Using :ref:`Extbase <extbase>` repositories in CLI context is not
    recommended as Extbase relies on frontend :ref:`TypoScript <t3tsref:start>`.
    For example,
    :ref:`conditions using the request object <t3tsref:condition-function-request>`
    may cause problems. Use the :ref:`query builder <database-query-builder>`
    or :ref:`DataHandler <datahandler-basics>` where appropriate.

..  _symfony-console-commands-cli:

Run a command from the command line
=====================================

You can list the available commands by calling:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3

For example, you can clear all caches by calling:

..  include:: /_includes/CliCacheFlush.rst.txt

Show help for the command:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 cache:flush -h

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cache:flush -h


..  _symfony-console-commands-scheduler:

Running the command from the scheduler
======================================

By default, it is possible to run a command from the :doc:`TYPO3 scheduler
<ext_scheduler:Index>` as well. To do this, select the task :guilabel:`Execute console commands`
followed by your command in the :guilabel:`Schedulable Command` field.

..  note::
    You need to save and reopen the task to define command arguments.

In order to prevent commands from being set up as scheduler tasks,
see :ref:`deactivating-the-command-in-scheduler`.

Create a custom command
=======================

See the :ref:`Tutorial: Create a console command <console-command-tutorial>`
for details on how to create commands.

DataHandler usage
=================

Using the :ref:`DataHandler <datahandler-basics>` in a CLI command requires
backend authentication.
See :ref:`dataHandler-cli-command` for more information.

Read more
==========

..  toctree::
    :titlesonly:
    :glob:

    *
