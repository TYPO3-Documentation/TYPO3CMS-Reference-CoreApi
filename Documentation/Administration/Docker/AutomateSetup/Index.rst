:navigation-title: Automate TYPO3 Setup

..  include:: /Includes.rst.txt
..  _docker-cli-automated-setup:

==================================
Automate TYPO3 setup using the CLI
==================================

This section demonstrates how to fully automate TYPO3 installation using the CLI
command `typo3 setup`, removing the need to complete the install wizard in the
browser.

This is particularly useful for repeatable local setups, CI pipelines, or scripted
Docker environments.

..  note::

    While this example uses a classic TYPO3 installation based on the
    `martinhelmich/typo3` image, the same approach can be adapted for
    Composer-based projects. To do so, use a different base image (e.g.
    `php:8.4-apache`) and update the CLI path to match the Composer installation,
    typically `vendor/bin/typo3`.

..  contents:: Table of contents

..  _docker-cli-automated-setup-dockerfile:

Update the Dockerfile to install gosu and Node.js
=================================================

Extend the Dockerfile to install `gosu`, which enables secure user switching, and include the `startup.sh` script to automate the setup process.

..  literalinclude:: _codesnippets/_Dockerfile
    :language: docker
    :caption: Dockerfile

..  _docker-cli-automated-setup-startup:

Create a startup script that runs TYPO3 setup
=============================================

The startup script checks if TYPO3 has already been installed. If not, it runs
the `typo3 setup` CLI command in non-interactive mode using environment
variables defined in Docker Compose.

..  literalinclude:: _codesnippets/_startup.sh
    :language: bash
    :caption: startup.sh

This script:

-   Detects if TYPO3 has already been installed
-   Runs the CLI-based `setup` command only once
-   Starts Apache in the foreground as required for Docker

..  note::

    The `gosu` command is used instead of `su` to preserve environment variables
    passed by Docker Compose. Without this, the `typo3 setup` command would not
    receive the necessary database and admin credentials.

..  tip::

    If you see this message in the logs:
    `AH00558: apache2: Could not reliably determine the server's fully qualified domain name...`
    you can safely ignore it, or suppress it by setting `ServerName localhost` in Apache's config.

..  _docker-cli-automated-setup-compose:

Define setup parameters in docker-compose.yml
=============================================

To automate setup, you must provide all required parameters via environment
variables. Add these to the `web` service in your `docker-compose.yml`:

..  literalinclude:: _codesnippets/_docker-compose.yml
    :language: yaml
    :caption: docker-compose.yml (excerpt)

..  warning::

    If you previously ran this setup, you need to remove existing files and
    volumes before rebuilding to trigger setup again:

    ..  code-block:: bash

        docker compose down --volumes
        rm -rf typo3conf/* typo3temp/* fileadmin/*

    Then rebuild and start the containers:

    ..  code-block:: bash

        docker compose build --no-cache
        docker compose up -d

..  _docker-cli-automated-setup-verify:

Verify that TYPO3 setup ran successfully
========================================

Check the logs to confirm that the setup script executed on startup:

..  code-block:: bash

    docker logs -f compose-demo-typo3

Expected output includes:

..  code-block:: text

    [INFO] No settings.php found, running 'typo3 setup'...
    ✓ Congratulations - TYPO3 Setup is done.

If the `settings.php` file is already present, you’ll instead see:

..  code-block:: text

    [INFO] settings.php found, skipping setup.

..  _docker-cli-automated-setup-login:

Log in to the TYPO3 backend
===========================

After the container is running and TYPO3 has been initialized, you can open the
TYPO3 backend in your browser:

..  code-block:: text

    http://localhost:8080/typo3/

Log in using the credentials you provided in `docker-compose.yml`, for example:

..  code-block:: text

    Username: j.doe
    Password: Password.1

You should now see the TYPO3 backend dashboard and can start working on your site.
