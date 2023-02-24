.. include:: /Includes.rst.txt

.. _cli-mode:
.. _cli-mode-dispatcher:
.. _cli-mode-command-controllers:
.. _symfony-console-commands:

======================
Console commands (cli)
======================

It is possible to run TYPO3 scripts from the command line.
This functionality can be used to set up cron jobs, for example.

TYPO3 uses Symfony commands API for writing CLI (command line interface) commands.
These commands can also be run from the TYPO3
:ref:`scheduler <symfony-console-commands-scheduler>` if this option is not
disabled in the :file:`Configuration/Services.yaml`.

The starting point for the commands differs depending on the kind of your TYPO3 installation.  

 1. In installations with composer TYPO3 the starting point is usually the folder where the
file :file:`composer.json` is resided, in this folder the directories :file:`var` and
:file:`vendor` are also created. CLI-commands start usually with `vendor/bin/`.
 2. In legacy installations (without composer) the starting poin is usually the web-root,
 so that CLI-commands start with `typo3/vendor/bin/`.

.. _symfony-console-commands-cli:

Run a command from the command line
=====================================

You can list the available commands by calling:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3

For example, you can clear all caches by calling:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 cache:flush

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 cache:flush

Show help for the command:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 cache:flush -h

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 cache:flush -h


.. _symfony-console-commands-scheduler:

Running the command from the scheduler
======================================

By default, it is possible to run a command from the :doc:`TYPO3 scheduler
<ext_scheduler:Index>` as well. To do this, select the task :guilabel:`Execute console commands`
followed by your command in the :guilabel:`Schedulable Command` field.

.. note::
   You need to save and reopen the task to define command arguments.

In order to prevent commands from being set up as scheduler tasks,
see :ref:`deactivating-the-command-in-scheduler`.

Create a custom command
=======================

You can create a custom command by extending
:php:`\Symfony\Component\Console\Command\Command`.

See the :ref:`Tutorial: Create a console command <console-command-tutorial>`
for details on how to create commands.

A command has to be registered as a tag of name :yaml:`console.command`:

.. code-block:: yaml
   :caption: EXT:some_extension/Configuration/Services.yaml

   services:
     Vendor\SomeExtension\Command\DoThingsCommand:
       tags:
         - name: 'console.command'
           command: 'someextension:dothings'
           description: 'An example command that demonstrates some stuff'
           schedulable: true
           hidden: false


.. _deactivating-the-command-in-scheduler:
.. _schedulable:

:yaml:`schedulable`
    By default, a command can be used in the scheduler too.
    This can be disabled by setting :yaml:`schedulable` to :yaml:`false`.

:yaml:`hidden`
    A command can be hidden from the command list by setting
    :yaml:`hidden` to :yaml:`true`.

Read more
==========

..  toctree::
    :titlesonly:
    :glob:

    *
