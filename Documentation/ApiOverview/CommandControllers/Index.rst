:navigation-title: Commands

..  include:: /Includes.rst.txt
..  _cli-mode:
..  _cli-mode-dispatcher:
..  _cli-mode-command-controllers:
..  _symfony-console-commands-cli:
..  _symfony-console-commands:

======================
Console commands (CLI)
======================

TYPO3 supports running scripts from the command line. This functionality is
especially useful for automating tasks such as cache clearing, maintenance,
and scheduling jobs.

System administrators and developers can use predefined commands to interact
with the TYPO3 installation directly from the terminal.

To learn how to run TYPO3 CLI commands in various environments (such as Composer
projects, Classic installations, DDEV, Docker, or remote servers), refer to
:ref:`How to run a command <how-to-run-a-command>`.

A list of available Core commands is provided here:
:ref:`List of Core console commands <symfony-console-commands-list>`.
Additional commands may be available depending on installed extensions.
The extension :composer:`helhum/typo3-console` is frequently installed to
provide a wider range of CLI commands.

If you are developing your own TYPO3 extension, you can also create custom
console commands to provide functionality specific to your use case. These
commands integrate with the TYPO3 CLI and can be executed like any built-in
command.

For more information, see :ref:`Writing Custom Commands <writing-custom-commands>`.

..  contents:: Table of contents

..  toctree::
    :caption: Read more
    :titlesonly:
    :glob:

    ListCommands
    CustomCommands
    Tutorial
    *

..  _how-to-run-a-command:

Command usage in terminal environments
======================================

To execute TYPO3 console commands, you need access to a terminal (command line
interface). You can run commands locally or on a remote server.

The entry point for running commands depends on the type of TYPO3 installation.

To display a list of all available commands, use the following:

..  tabs::

    ..  group-tab:: Composer mode

        ..  code-block:: bash

            vendor/bin/typo3

    ..  group-tab:: Classic mode

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3

    ..  group-tab:: DDEV

        ..  code-block:: bash

            ddev typo3

    ..  group-tab:: Core development in the Mono repository

        ..  code-block:: bash

            bin/typo3

..  _how-to-run-a-command-local-development:

Local development environments
------------------------------

If you are working on a local development environment such as DDEV, MAMP, or a
native PHP installation, open a terminal and navigate to your project
directory. Then, run the command using the appropriate entry point for your
installation (Composer or Classic mode).

..  code-block:: bash

    cd my-typo3-project
    vendor/bin/typo3 list

..  _how-to-run-a-command-ddev:

Using the CLI with DDEV
~~~~~~~~~~~~~~~~~~~~~~~

If you are using DDEV, you can run TYPO3 commands from your host machine using
the :command:`ddev typo3` shortcut. This automatically routes the command into
the correct container and environment.

For example, to flush all caches:

..  code-block:: bash

    ddev typo3 cache:flush

You can use this shortcut with any TYPO3 CLI command:

..  code-block:: bash

    ddev typo3 <your-command>

..  _how-to-run-a-command-docker:

Using the CLI in Docker containers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you are using Docker directly (without DDEV or a wrapper), TYPO3 commands
must usually be executed **inside the container** that runs PHP and TYPO3.

First, open a shell inside the container. For example:

..  code-block:: bash

    docker exec -it my_php_container bash

Replace `my_php_container` with the name of your running PHP container.

Once inside the container, navigate to the project directory and run the
command:

..  code-block:: bash

    cd /var/www/html
    vendor/bin/typo3 list

You typically **cannot run** TYPO3 commands from the host system unless the
project's PHP environment is directly accessible outside the container.

..  _how-to-run-a-command-remote-servers-ssh:

Executing commands on remote servers via SSH
--------------------------------------------

For TYPO3 installations on a remote server, you typically access the server
using SSH (Secure Shell).

Use the following command to connect:

..  code-block:: bash

    ssh username@example.com

Replace `username` with your SSH username and `example.com` with the server
hostname or IP address.

Once logged in, navigate to your TYPO3 project directory and execute the
command. For example:

..  code-block:: bash

    cd /var/www/my-typo3-site
    vendor/bin/typo3 list

..  _how-to-run-a-command-file-must-be-executable:

Making the CLI entry point executable
-------------------------------------

The TYPO3 command entry point (e.g. :file:`vendor/bin/typo3`) must be marked as
**executable** in order to run it directly.

To make the file executable, run:

..  code-block:: bash

    chmod +x vendor/bin/typo3

If you do not have permission to change the file mode or the file system is
read-only, you can run the script by calling the PHP interpreter explicitly:

..  code-block:: bash

    php vendor/bin/typo3 list

This method works even if the file is not executable.

..  _symfony-console-commands-scheduler:

Executing commands from the scheduler
-------------------------------------

By default, it is possible to run a command from the
`TYPO3 Scheduler <https://docs.typo3.org/permalink/typo3/cms-scheduler:start>`_
as well. To do this, select the task :guilabel:`Execute console commands`
followed by your command in the :guilabel:`Schedulable Command` field.

..  note::
    You need to save and reopen the task to define command arguments.

In order to prevent commands from being set up as scheduler tasks,
see :ref:`deactivating-the-command-in-scheduler`.

..  _how-to-run-a-command-ci-cd:

Using CLI commands in CI/CD pipelines
-------------------------------------

In continuous integration (CI) or continuous deployment (CD) pipelines, TYPO3
CLI commands can be used for tasks such as preparing the system, checking
configuration, or activating extensions (Classic mode).

See also chapter `CI/CD: Automatic deployment for TYPO3 Projects <https://docs.typo3.org/permalink/t3coreapi:ci-cd-for-typo3-projects>`_.

The exact command entry point depends on your installation type. For example:

..  code-block:: bash

    vendor/bin/typo3 list

Before you can run most TYPO3 CLI commands, ensure the following:

-   You have run :command:`composer install` so that the `vendor/` directory and
    CLI entry point exist.
-   The PHP environment is set up (with extensions such as `pdo_mysql`).
-   The environment variable `TYPO3_CONTEXT` is set appropriately, such as
    `Production` or `Testing`.

..  important::

    If no database is available during the pipeline (in a build-only step),
    many commands will not work. For example, :command:`cache:flush` requires a
    database connection and will fail without one.

If you want to run commands such as :command:`cache:flush` after deployment,
it is common to use the CI pipeline to connect to the remote server and
execute the command there using SSH:

..  code-block:: bash

    ssh user@your-server.example.com 'cd /var/www/html && vendor/bin/typo3 cache:flush'

This pattern is often used in **post-deployment steps** to finalize setup in
the live environment.

..  _command-cache-flush:

Clearing the cache with cache:flush
===================================

A common use case is to use a console command to flush all caches, for example
during development.

..  include:: /_includes/CliCacheFlush.rst.txt

..  _command-help:

Viewing help for CLI commands
=============================

Show help for the command:

..  tabs::

    ..  group-tab:: Composer mode

        ..  code-block:: bash

            vendor/bin/typo3 cache:flush -h

    ..  group-tab:: Classic mode

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 cache:flush -h
