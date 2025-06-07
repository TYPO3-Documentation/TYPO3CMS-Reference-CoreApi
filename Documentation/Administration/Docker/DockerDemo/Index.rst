:navigation-title: Docker demo

..  include:: /Includes.rst.txt
..  _classic-docker-installation:

=================================================
Classic TYPO3 demo installation using Docker only
=================================================

..  warning::

    This setup is intended for **local testing and learning**.

This guide shows how to set up a TYPO3 demo site using **basic Docker commands** —
without `Docker Compose <https://docs.typo3.org/permalink/t3coreapi:docker-compose-typo3>`_ 
or `DDEV <https://docs.typo3.org/permalink/t3start:install>`_.

By building the environment step by step, you’ll learn how Docker actually works:
how containers run, how they talk to each other, how volumes persist data, and how
services like TYPO3 and MariaDB connect via networking. This hands-on setup is ideal
for those who want to understand the fundamentals of containerized TYPO3 — not just
use a prebuilt stack.

This is a local development setup, **not a production deployment**.

This setup runs TYPO3 in
`Classic mode <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_
using the image
`martinhelmich/typo3 <https://hub.docker.com/r/martinhelmich/typo3>`_
along with a MariaDB container.

..  tip::

    New to Docker? Start here:
    `Docker Get Started Guide <https://docs.docker.com/get-started/>`_.

..  contents::

..  _classic-docker-quickstart:

Quick start
===========

To quickly launch TYPO3 in classic mode with Docker:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    mkdir -p fileadmin typo3conf typo3temp

    # On Linux and WSL during development: Ensure TYPO3 can write to these directories
    # chmod -R 777 fileadmin typo3conf typo3temp

    docker network create typo3-demo-net

..  literalinclude:: _codesnippets/_DockerDbDemo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

..  literalinclude:: _codesnippets/_DockerRunTypo3Demo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

If you are working on Linux or WSL, see :ref:`classic-docker-permissions`.

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

If you are working on Linux or WSL, see :ref:`classic-docker-permissions`.

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

To stop the webserver container for TYPO3, run:

..  code-block:: bash

    docker stop typo3-demo

To start the webserver container for TYPO3, run:

..  code-block:: bash

    docker start typo3-demo

To restart the webserver container for TYPO3, run:

..  code-block:: bash

    docker restart typo3-demo

To remove the webserver container for TYPO3 (all individual stored data is gone), run:

..  code-block:: bash

    docker rm typo3-demo

To re-create the webserver container for TYPO3 (initial file set):

..  literalinclude:: _codesnippets/_DockerRunTypo3Demo.sh
    :language: bash
    :caption: ~/projects/typo3demo/$

To stop the database container (contained data will be kept), run:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker stop typo3db

To restart the database container (contained data will be kept), run:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker restart typo3db

To remove the database container (all data is gone), run:

..  code-block:: bash
    :caption: ~/projects/typo3demo/$

    docker rm typo3db

To re-create the database container with empty data set, run:

..  literalinclude:: _codesnippets/_DockerDbDemo.sh
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

..  _classic-docker-permissions:

Solving file permission issues
==============================

Depending on your host operating system, TYPO3 may not be able to write
to mounted folders like `fileadmin/`, `typo3conf/`, or `typo3temp/`.

Symptoms include:

-   TYPO3 installer shows errors saving config
-   HTTP 500 errors
-   Cache or extension data not persisting

..  _classic-docker-permission-linux:

On Linux or WSL: File ownership and permission tips
---------------------------------------------------

Linux containers often run with a web server user like `www-data` (UID 33).
Your local files may need matching ownership or permissions:

..  code-block:: bash

    # Quick fix for local development (not recommended for production)
    # chmod -R 777 fileadmin typo3conf typo3temp

    # Safer alternative: match the container's web server user (usually UID 33 for www-data)
    sudo chown -R 33:33 fileadmin typo3conf typo3temp

..  _classic-docker-permissions-mac:

macOS and Windows Docker file permission issues
-----------------------------------------------

If you are using Docker Desktop, you usually **do not need to change permissions**.
Docker handles this automatically in most cases.

If you still run into issues, try restarting Docker and ensure file sharing is enabled
for the folder you're working in.

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
