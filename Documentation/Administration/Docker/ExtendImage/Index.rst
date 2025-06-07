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

Once the container is running, you can verify that Node.js is installed by
executing the following command:

..  code-block:: bash

    docker exec -it typo3-nodejs node -v

This should output the installed Node.js version (for example: `v18.19.0`).

You can now use Node.js inside the container to install frontend dependencies
or run build scripts required by your TYPO3 project.

..  _docker-extend-typo3-startup-script:

Add a custom startup script
===========================

You can extend the image further by adding your own startup script. This is
useful if you want to run custom commands each time the container starts—for
example, to set file permissions, log environment variables, or flush caches.

Create a file named ``startup.sh`` in the same folder as your ``Dockerfile``:

..  code-block:: bash
    :caption: startup.sh

    #!/bin/bash
    echo "[INFO] Running custom startup script..."

    # Example: create a log file
    echo "Startscript executed successfully" >> /var/www/html/startup.log

    # Start Apache (required by php:*-apache images)
    exec apache2-foreground

Update your ``Dockerfile`` to copy this script and use it as the new entrypoint:

..  code-block:: docker
    :caption: Dockerfile (excerpt)

    USER root

    COPY ./startup.sh /usr/local/bin/startup.sh
    RUN chmod +x /usr/local/bin/startup.sh

    USER www-data

    ENTRYPOINT ["/usr/local/bin/startup.sh"]

Then rebuild the image and run the container:

..  code-block:: bash

    docker build --no-cache -t typo3-with-nodejs .
    docker rm -f typo3-nodejs
    docker run -d -p 8082:80 --name typo3-nodejs typo3-with-nodejs

You can verify that the script ran by checking for the log file:

..  code-block:: bash

    docker exec -it typo3-nodejs cat /var/www/html/startup.log

And view the container logs:

..  code-block:: bash

    docker logs typo3-nodejs

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

    # Run this to force a rebuild of your local image:
    docker compose build --no-cache

    # Then bring it up:
    docker compose up -d

To verify that Node.js is available inside the container:

..  code-block:: bash

    # Verify that Node.js is available:
    docker exec -it compose-demo-typo3 node -v

    # Verify that the startup script ran by checking for the log file
    docker exec -it compose-demo-typo3 ls -l /var/www/html/startup.log

    # See the output of the startup script:
    docker logs compose-demo-typo3

You can now open your browser at: http://localhost:8081

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

If you want to go one step further and automate the initial TYPO3 installation
(using the CLI instead of the web-based install wizard), see

`Automated TYPO3 installation using the CLI <https://docs.typo3.org/permalink/t3coreapi:docker-cli-automated-setup>`_
