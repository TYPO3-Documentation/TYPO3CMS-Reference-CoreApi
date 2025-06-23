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

(This URL works because port 8081 on your host maps to port 80 in the container;
see :ref:`docker-compose-port-mapping`)

Use these installer settings:

-   **Database host**: `db`
-   **Username**: `db`
-   **Password**: `db`
-   **Database name**: `db`

..  _docker-compose-port-mapping:

About port mapping in Docker Compose
====================================

By default, the TYPO3 container exposes **port 80** internally. In the
`docker-compose.yml` file, this is mapped to a port on your local machine
using the `ports` option:

..  code-block:: yaml

    ports:
      - "8081:80"

This means:

*   `80` is the container’s internal web server port
*   `8081` is the port on your local machine

With this mapping, you can access TYPO3 at:

..  code-block:: text

    http://localhost:8081

You can change the `8081` part to any available port above `1024`, if needed.
The internal port `80` should not be changed, as it is required by the webserver
in the TYPO3 image.

..  tip::

    Learn more: `Docker Compose Networking – Ports
    <https://docs.docker.com/compose/compose-file/#ports>`_

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
