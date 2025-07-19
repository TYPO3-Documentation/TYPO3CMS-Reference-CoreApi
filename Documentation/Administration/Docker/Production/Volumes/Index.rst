:navigation-title: Volumes

..  include:: /Includes.rst.txt
..  _docker-volumes:

============================================
Mounting volumes for TYPO3 Docker containers
============================================

When working with Docker containers, you need to mount volumes. This ensures
that important data persists across container restarts and deployments on the
host machine.

You should typically map these paths to volumes on the host server that you
would not include in an `Incremental deployment
<https://docs.typo3.org/permalink/t3coreapi:manual-deployment-incremental>`_.

This includes user-managed content such as :path:`public/fileadmin`, and cached
content like :path:`var`.

..  _docker-volumes-config:

Configure directories to be mountable in the Docker file
========================================================

Within the :file:`Dockerfile`, you can use the `VOLUME` instruction to create a
mount point for a specified path.

..  seealso::
    `VOLUME in the Official Docker Documentation
    <https://docs.docker.com/reference/dockerfile/#volume>`_

..  tabs::

    ..  group-tab:: Composer mode

        ..  code-block:: bash

            VOLUME /var/www/html/fileadmin
            VOLUME /var/www/html/typo3conf
            VOLUME /var/www/html/typo3temp

    ..  group-tab:: Classic mode

        ..  code-block:: powershell

            VOLUME /var/www/html/public/fileadmin
            VOLUME /var/www/html/public/typo3temp
            VOLUME /var/www/html/var

..  _docker-volumes-mounting:

Mount the defined volumes on the host system
============================================

The method for mounting Docker volumes depends on how you manage your
containers.

If you use Docker on the console and Docker Compose is available, you can
configure volumes to be mounted in the :file:`docker-compose.yml`. See the
chapter `Create the docker-compose.yml file
<https://docs.typo3.org/permalink/t3coreapi:docker-compose-create-composefile>`_.

If you are using pure Docker commands, refer to `Start the TYPO3 container with
mounted writable directories
<https://docs.typo3.org/permalink/t3coreapi:classic-docker-typo3>`_.

Some hosting providers offer a graphical interface to define volumes.

..  note::
    If a volume is **not mounted** on the host server, its content will be lost
    when you stop and restart the container or update it.

    Ensure you have a `secure backup strategy
    <https://docs.typo3.org/permalink/t3coreapi:administration-backups>`_ for
    user-created content in mounted volumes.
