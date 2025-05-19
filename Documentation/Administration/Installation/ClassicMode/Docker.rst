:navigation-title: Docker demo

..  include:: /Includes.rst.txt
..  _classic-docker-installation:

============================================
Classic TYPO3 demo installation using Docker
============================================

..  note::
    This demo setup is **for local development only** and
    **not suitable for production**.

    It runs TYPO3 in
    `Classic mode <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_
    using the image
    `martinhelmich/typo3 <https://hub.docker.com/r/martinhelmich/typo3>`_
    and a MariaDB container.

    For production or team development, use
    `Composer-based <https://docs.typo3.org/permalink/t3coreapi:installation-composer>`_ TYPO3,
    `Version control (Git) <https://docs.typo3.org/permalink/t3coreapi:version-control>`_
    and a custom Docker setup.

..  contents::

..  _classic-docker-quickstart:

Quick start
===========

To quickly launch TYPO3 in classic mode with Docker:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    mkdir -p fileadmin typo3conf typo3temp

    # Ensure TYPO3 can write to these directories
    chmod -R 777 fileadmin typo3conf typo3temp

    docker network create typo3-demo-net

..  literalinclude:: _codesnippets/_DockerDbDemo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

..  literalinclude:: _codesnippets/_DockerRunTypo3Demo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

Then open:

..  code-block:: text

    http://localhost:8080

Use these database settings in the TYPO3 installer:

-   **Database Host**: `typo3db`
-   **Username**: `db`
-   **Password**: `db`
-   **Database Name**: `db`

..  _classic-docker-prerequisites:

Prerequisites for using TYPO3 in Docker locally
===============================================

-   Docker installed. See
    `https://docs.docker.com/get-docker/ <https://docs.docker.com/get-docker/>`_.
-   Basic knowledge of Docker.
-   A web browser to access TYPO3.

..  _classic-docker-setup:

Step-by-step Docker setup
=========================

..  _classic-docker-project:

1. Prepare a project directory
------------------------------

Create a local project directory and subfolders for TYPO3's writable directories:

..  literalinclude:: _codesnippets/_DockerDirDemo.sh
    :language: bash
    :caption: ~/projects/$

..  _classic-docker-network:

2. Create a user-defined Docker network
---------------------------------------

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker network create typo3-demo-net

..  _classic-docker-db:

3. Start the MariaDB database container
---------------------------------------

..  literalinclude:: _codesnippets/_DockerDbDemo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

..  _classic-docker-typo3:

4. Start the TYPO3 container with mounted writable directories
--------------------------------------------------------------

..  literalinclude:: _codesnippets/_DockerRunTypo3Demo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

..  important::
    **Ensure folder permissions are correct**

    Mounted folders must be writable by the web server inside the container.
    If you use mounted folders, adjust their permissions on your host system:

    ..  code-block:: bash
        :caption: ~/projects/typo3demo/$

        chmod -R 777 fileadmin typo3conf typo3temp uploads

    Without correct permissions, TYPO3 may fail with **HTTP 500 errors**
    when trying to write configuration, caches, or uploaded files.

..  _classic-docker-access:

5. Access TYPO3 in your browser
-------------------------------

Open:

..  code-block:: text

    http://localhost:8080

Use these database settings:

- **Database Host**: `typo3db`
- **Username**: `db`
- **Password**: `db`
- **Database Name**: `db`

..  _classic-docker-structure:

6. Project directory structure after setup
------------------------------------------

..  directory-tree::

    *   :path:`fileadmin/`
    *   :path:`typo3conf/`
    *   :path:`typo3temp/`

..  note::
    All writable TYPO3 content is now persisted on your local machine.
    TYPO3 Core files are reset when the container stops. You can inspect them
    by `accessing the TYPO3 container shell <https://docs.typo3.org/permalink/t3coreapi:classic-docker-shell>`_.

..  _classic-docker-stop:

7. Stopping and restarting the containers
-----------------------------------------

To stop TYPO3, run:

..  code-block:: bash

    docker stop typo3-demo

To stop and remove the database:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker stop typo3db

To restart the database:

..  literalinclude:: _codesnippets/_DockerDbDemo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

Then restart TYPO3:

..  literalinclude:: _codesnippets/_DockerRunTypo3Demo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

..  _classic-docker-reset:

Resetting the environment
=========================

To **reset your TYPO3 demo environment completely**, run the following script.

..  caution::
    **This will delete all data and containers**.
    Make sure you no longer need any files or database contents before proceeding.

..  code-block:: bash
    :caption: ~/Projects/typo3site/$

    # Stop and remove containers
    docker stop typo3-demo typo3db || true
    docker rm typo3-demo typo3db || true

    # Remove the Docker network
    docker network rm typo3-demo-net || true

    # Remove project folders
    rm -rf fileadmin typo3conf typo3temp uploads

    # Optionally remove Docker images (uncomment if desired)
    # docker rmi martinhelmich/typo3
    # docker rmi mariadb

After this cleanup, you can **repeat the setup instructions** to start fresh
with a clean environment.

..  _classic-docker-command:

Helpful Docker commands
=======================

..  _classic-docker-shell:

Accessing the TYPO3 container shell
-----------------------------------

While the container is running in detached mode, you can open an
interactive shell in the container to inspect files, check logs,
or run TYPO3 console commands.

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker exec -it typo3-demo /bin/bash

This opens an **interactive bash shell** inside the running TYPO3 container.

Type `exit` to leave the container shell.

..  _classic-docker-console:

Running TYPO3 console commands
------------------------------

TYPO3 provides a **command-line interface (CLI)** via the `typo3/sysext/core/bin/typo3` script.

To run console commands in the running container, use:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker exec -it typo3-demo /var/www/html/typo3/sysext/core/bin/typo3

For example, to list available commands:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker exec -it typo3-demo /var/www/html/typo3/sysext/core/bin/typo3 list

Flush all caches:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker exec -it typo3-demo /var/www/html/typo3/sysext/core/bin/typo3 cache:flush

..  _classic-docker-versions:

Selecting TYPO3 versions in the Docker container
================================================

By default, the `martinhelmich/typo3` image runs the latest available TYPO3
LTS release (at the time of writing `13.4.*`) when using the `latest` tag.

To run a specific TYPO3 version, use the corresponding image tag in your
`docker run` command. For example:

..  code-block:: bash
    :caption: Run TYPO3 version 12.4

    docker run -d -p 8080:80 --name typo3-demo \
        --network typo3-demo-net \
        -v "$(pwd)/fileadmin:/var/www/html/fileadmin" \
        -v "$(pwd)/typo3conf:/var/www/html/typo3conf" \
        -v "$(pwd)/typo3temp:/var/www/html/typo3temp" \
        -v "$(pwd)/uploads:/var/www/html/uploads" \
        martinhelmich/typo3:12.4

Check https://hub.docker.com/r/martinhelmich/typo3/tags for the full list
of available versions.

..  _classic-docker-production:

Considerations for production
=============================

This guide demonstrates a **quick and temporary setup** for local development
and testing purposes only.

It **should not be used in production environments** as is.

-   `Docker production best practices <https://docs.docker.com/develop/dev-best-practices/>`_
-   `Deploying TYPO3 <https://docs.typo3.org/permalink/t3coreapi:deployment>`_
-   `Security guidelines for system administrators <https://docs.typo3.org/permalink/t3coreapi:security-administrators>`_
