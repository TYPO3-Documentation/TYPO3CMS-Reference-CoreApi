:navigation-title: Extend an Image

..  include:: /Includes.rst.txt
..  _docker-extend-image:

=========================================================
Extending the community-maintained Docker image for TYPO3
=========================================================

In previous chapters, you learned how to run TYPO3 using the community-maintained
Docker image `martinhelmich/typo3 <https://docs.typo3.org/permalink/t3coreapi:classic-docker-installation>`_.
This is a convenient way to get started with TYPO3 13.4 and is suitable for many
development use cases.

However, you might need to add tools or functionality that are not included by
default in the image. This chapter demonstrates how to extend the image with
additional packages by building your own image on top of it.

A common use case is to install Node.js and npm, which are required for many
TYPO3 frontend build pipelines (for example: Webpack, Vite, Tailwind CSS).

..  note::

    The `martinhelmich/typo3` image is maintained by TYPO3 community members.
    It is not an official image provided or endorsed by the TYPO3 Core Team.

..  _docker-extend-typo3-install-nodejs:

Install Node.js and npm in the TYPO3 container
==============================================

To extend the existing Docker image and install Node.js, create a file named
`Dockerfile`. For simplicity, you can place it in the same folder as your
`docker-compose.yml` file created in the chapter
`Create the docker-compose.yml file <https://docs.typo3.org/permalink/t3coreapi:docker-compose-create-composefile>`_.

..  code-block:: docker
    :caption: Dockerfile

    FROM martinhelmich/typo3:13.4

    USER root

    # Install Node.js and npm (NodeSource 20.x)
    RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
        apt-get install -y nodejs

    USER www-data

This example:

-   Starts from the official `martinhelmich/typo3` image
-   Switches to `root` user to install system packages
-   Adds the latest Node.js 20.x LTS version
-   Switches back to the default unprivileged user

..  _docker-extend-typo3-build-image:

Build and run the custom image
==============================

To build and run your extended image, use the following commands:

..  code-block:: bash

    docker build -t typo3-with-nodejs .
    docker run -d -p 8082:80 --name typo3-nodejs typo3-with-nodejs

To avoid conflicts with containers from previous examples, this image uses port
`8082`. For instructions on stopping or removing containers that use other ports,
refer to `Stop and clean up <https://docs.typo3.org/permalink/t3coreapi:docker-compose-stop-cleanup>`_.

..  _docker-extend-typo3-verify-nodejs:

Verify that Node.js is installed
================================

Once the container is running, you can verify that Node.js is installed by
executing the following command:

..  code-block:: bash

    docker exec -it typo3-nodejs node -v

This should output the installed Node.js version (for example: `v18.19.0`).

You can now use Node.js inside the container to install frontend dependencies
or run build scripts required by your TYPO3 project.
..  _docker-extend-typo3-compose-integration:

Use the custom image in your Docker Compose setup
=================================================

After running your extended image manually, you can now integrate it into the
Docker Compose setup described in the chapter
`Create the docker-compose.yml file <https://docs.typo3.org/permalink/t3coreapi:docker-compose-create-composefile>`_.

Before doing so, stop and remove the previously started container that used
your image:

..  code-block:: bash

    # Stop previous example
    docker stop typo3-nodejs
    docker rm typo3-nodejs

    # Stop previous Docker compose
    docker compose down --volumes

    # Remove data from previous runs
    rm -rf typo3conf/* fileadmin/* typo3temp/*

Then update your `docker-compose.yml` to build your custom image instead of
pulling `martinhelmich/typo3` from Docker Hub.

Change the following lines in the `web` service:

..  code-block:: diff
    :caption: docker-compose.yml (excerpt)

     services:
       web:
    -    image: martinhelmich/typo3:latest
    +    build: .
         container_name: compose-demo-typo3

This change tells Docker Compose to build the image locally using your
`Dockerfile`.

Make sure your `Dockerfile` and `docker-compose.yml` are in the same
directory, then start the services:

..  code-block:: bash

    docker compose up -d

You can now open your browser at: http://localhost:8081

To verify that Node.js is available inside the container:

..  code-block:: bash

    docker exec -it compose-demo-typo3 node -v

..  _docker-extend-typo3-advantages:

Advantages of extending the community-maintained image
=======================================================

Extending the `martinhelmich/typo3` image is useful for learning purposes:

-   It helps you understand how Docker images are built and layered
-   You can try out adding tools such as Node.js to a running TYPO3 environment
-   It introduces you to working with custom images without having to build
    everything yourself

This approach is not intended for collaborative or production TYPO3 development.

In real-world projects, you would typically use a Composer-based setup and track
all dependencies (including TYPO3 and extensions) in version control.
