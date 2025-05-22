:navigation-title: Docker Compose demo

..  include:: /Includes.rst.txt
..  _docker-compose-typo3:

====================================================
Classic TYPO3 demo installation using Docker Compose
====================================================

..  warning::

    This setup is intended for **local testing and learning**.

This guide shows how to run the same TYPO3 demo environment from the
:ref:`classic-docker-installation` using **Docker Compose**.

Instead of running each container manually with `docker run`, we define the
entire setup in a single `docker-compose.yml` file. This makes it easier
to start, stop, and manage services as a group.

..  tip::

    New to Docker Compose? Start here:
    `Getting started with Docker Compose <https://docs.docker.com/compose/gettingstarted/>`_.

..  contents:: Table of contents

How to run TYPO3 with Docker Compose
====================================

..  _docker-compose-create-project:

Create a project directory
--------------------------

..  code-block:: bash

    mkdir compose_demo_typo3
    cd compose_demo_typo3
    mkdir -p fileadmin typo3conf typo3temp

    # Linux/WSL only (fix permissions during development)
    # chmod -R 777 fileadmin typo3conf typo3temp
    # sudo chown -R 33:33 fileadmin typo3conf typo3temp

..  _docker-compose-create-composefile:

Create the docker-compose.yml file
----------------------------------

..  literalinclude:: _codesnippets/_docker-compose.yaml
    :caption: docker-compose.yml

..  _docker-compose-start-environment:

Start the environment
---------------------

..  code-block:: bash

    docker compose up -d

..  _docker-compose-open-in-browser:

Open TYPO3 in your browser
--------------------------

Visit:

..  code-block:: text

    http://localhost:8081

Use these installer settings:

-   **Database host**: `db`
-   **Username**: `db`
-   **Password**: `db`
-   **Database name**: `db`

..  _docker-compose-stop-cleanup:

Stop and clean up
=================

To stop all containers:

..  code-block:: bash

    docker compose down

To also remove volumes (e.g. the database):

..  code-block:: bash

    docker compose down --volumes

..  seealso::

    If you encounter file permission issues, see :ref:`classic-docker-permissions`.
