:navigation-title: Docker Container

..  include:: /Includes.rst.txt
..  _docker-container-database:

=======================================================
Database considerations for deploying TYPO3 with Docker
=======================================================

..  include:: /Administration/Deployment/Docker/_Experimental.rst.txt

TYPO3 requires a relational database in order to store content, configuration, and
extension data. When running TYPO3 in a Docker container on a server,
there are several database deployment options — each with different
levels of complexity and production readiness.

The table below provides a quick comparison. You can click on each setup
type to jump to a more detailed explanation.

..  t3-field-list-table::
    :header-rows: 1

    -   :Setup type:                Setup type
        :Production-ready:          Suitable for production?
        :Persistence:               Persistence strategy
        :Backups needed:            Backup required?
        :Notes:                     Notes

    -   :Setup type:                 `External or managed database service <docker-container-external-database_>`__
        :Production-ready:          ✅ Yes
        :Persistence:               Managed externally
        :Backups needed:            ✅ Recommended
        :Notes:                     Scalable, secure, ideal for production. Offloads maintenance.

    -   :Setup type:                 `MariaDB/MySQL in separate container <docker-container-mariadb-separate-container_>`__
        :Production-ready:          ✅ Yes
        :Persistence:               Docker volume or bind mount
        :Backups needed:            ✅ Yes
        :Notes:                     Flexible and common. Requires backup strategy and network setup.

    -   :Setup type:                 `SQLite inside TYPO3 container <docker-container-sqlite-single-container_>`__
        :Production-ready:          ❌ No
        :Persistence:               None or bind mount
        :Backups needed:            ⚠️ Manual
        :Notes:                     Simple but fragile. Not recommended beyond test/demo use.

..  _docker-container-external-database:

External or managed database service
====================================

You can connect your TYPO3 container to an external or managed database,
such as one provided by your hosting environment or an infrastructure
platform.

**Benefits:**

-   No need to manage the database container yourself
-   Professional-grade storage, backup, and monitoring
-   Excellent for production scalability and reliability

**But remember:**

-   Pass credentials securely using environment variables or secrets
-   Ensure network access is reliable and secure

This approach is ideal if you already have database infrastructure in place
or want to reduce operational complexity by offloading maintenance.

..  _docker-container-mariadb-separate-container:

MariaDB/MySQL in separate container
===================================

Running the database in a separate container is a popular, flexible solution.
Containers provide modular services and work well with Docker Compose, Swarm, or
Kubernetes.

**Important considerations:**

-   Use Docker volumes for persistence
-   Ensure the TYPO3 container can reach the database on the network
-   Handle startup timing to avoid connection errors
-   Schedule regular database backups

..  seealso::

    -   Docker Compose: https://docs.docker.com/compose/
    -   MariaDB in Docker: https://hub.docker.com/_/mariadb
    -   MySQL in Docker: https://hub.docker.com/_/mysql

..  _docker-container-sqlite-single-container:

SQLite inside TYPO3 container
=============================

A simple solution is to use SQLite and include the database file inside a
TYPO3 Docker container. This works for quick tests, demos, or very small-scale
sites.

**Drawbacks:**

- No real persistence unless explicitly mounted
- Fragile: data is lost on rebuild unless carefully managed
- Not suitable for production

..  seealso::

    -   SQLite official documentation: https://www.sqlite.org/docs.html
