:navigation-title: System Requirements

..  include:: /Includes.rst.txt
..  index:: system requirements, apache, nginx, database, mysql, sqlite
..  _system-requirements:

=====================================
System requirements for running TYPO3
=====================================

TYPO3 requires a web server, PHP, and a supported database system.
Composer is required for Composer-based installations, especially during
development.

..  contents:: Table of contents

..  seealso::
    For current and detailed requirements, including concrete versions, visit:

    *   https://get.typo3.org/version/#system-requirements

    Related topics:

    *   `Installation instructions <https://docs.typo3.org/permalink/t3coreapi:installation-index>`_
    *   `Deployment <https://docs.typo3.org/permalink/t3coreapi:deployment>`_

..  _system-requirements-php:

PHP requirements and configuration
==================================

TYPO3 requires PHP with a supported version and specific configuration
values and extensions.

..  _system-requirements-php-configuration:

Recommended PHP configuration settings
--------------------------------------

The following should be set in your `php.ini` file:

..  code-block:: ini
    :caption: php.ini

    memory_limit = 256M
    max_execution_time = 240
    max_input_vars = 1500
    pcre.jit = 1

To support file uploads, configure:

..  code-block:: ini
    :caption: php.ini

    post_max_size = 10M
    upload_max_filesize = 10M

..  _system-requirements-php-extensions:

Required and optional PHP extensions
------------------------------------

Required extensions:

*   `pdo`
*   `session`
*   `xml`
*   `filter`
*   `SPL`
*   `standard`
*   `tokenizer`
*   `mbstring`
*   `intl`

Optional but commonly used:

*   `fileinfo` – for detecting uploaded file types
*   `gd` – for image generation and scaling
*   `zip` – for language packs and extension archives
*   `zlib` – for Classic installations to unpack extension files
*   `openssl` – for encrypted SMTP mail delivery

..  _system-requirements-php-database-extensions:

Database-specific PHP extensions
--------------------------------

..  tabs::

    ..  tab:: MySQL / MariaDB

        * `pdo_mysql` (recommended)
        * or `mysqli`

        MySQL/MariaDB must support the InnoDB engine.

    ..  tab:: PostgreSQL

        * `pdo_pgsql`
        * `pgsql`

    ..  tab:: SQLite

        * `sqlite3`

.. _system-requirements-image-processing:

Image processing requirements
=============================

If you want TYPO3 to automatically process images (e.g. cropping, resizing,
thumbnail generation), install one of the following tools on your server:

* `GraphicsMagick (≥ 1.3) <http://www.graphicsmagick.org>`__ (recommended)
* `ImageMagick (≥ 6) <https://imagemagick.org>`__

These tools are used by TYPO3 for features such as image rendering in content
elements and backend previews.

..  _system-requirements-web-server:

Supported web servers and configuration
=======================================

TYPO3 supports the following web servers, each requiring specific configuration:

*   :ref:`Apache <system-requirements-apache>` (Linux/macOS/Windows)
*   :ref:`NGINX <system-requirements-nginx>` (Linux/macOS/Windows)
*   :ref:`IIS (Windows) <system-requirements-iis>` (Microsoft Windows only)

..  _system-requirements-apache:

Apache web server configuration
-------------------------------

TYPO3 includes a `.htaccess` file with rewrite and security rules.

..  _htaccess:

Apache .htaccess configuration file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This file configures:

*   URL rewriting
*   Security and access control
*   PHP directives
*   MIME types

TYPO3 installs this file automatically. On major upgrades, check
for new directives and merge them if needed.

You can check the `.htaccess` status under:

:guilabel:`System > Environment > Check Directory Status`

..  _vhost-records:

Apache virtual host requirements
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Your Apache VirtualHost must include:

..  code-block:: apache

    AllowOverride Indexes FileInfo

..  _apache-modules:

Apache modules required or recommended
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

*   `mod_alias`
*   `mod_authz_core`
*   `mod_deflate`
*   `mod_expires`
*   `mod_filter`
*   `mod_headers`
*   `mod_rewrite`
*   `mod_setenvif`

..  _system-requirements-nginx:

NGINX web server configuration
------------------------------

NGINX does not support `.htaccess` files. Configuration must be done
at the system level.

..  literalinclude:: _codesnippets/_nginx.conf
    :language: nginx
    :caption: Example: /etc/nginx/conf.d/typo3.conf

.. _system-requirements-iis:

IIS (Windows) web server configuration
--------------------------------------

TYPO3 includes a default `web.config` file for IIS with rewrite rules.

Requirements:

*   `URL Rewrite plugin <https://www.iis.net/downloads/microsoft/url-rewrite>`_

File location:

:file:`EXT:install/Resources/Private/FolderStructureTemplateFiles/root-web-config`

.. _system-requirements-docker:

Using TYPO3 with Docker-based environments
==========================================

TYPO3 runs well in Docker-based environments. You can combine PHP with Apache
or NGINX using official base images.

Recommended base images:

* Apache: `php:8.4-apache`
* NGINX: `nginx:stable` + `php:8.4-fpm`

Install required PHP extensions and set suitable PHP configuration.

..  tabs::

    ..  tab:: Apache + PHP 8.4

        ..  literalinclude:: _codesnippets/_Dockerfile-apache-php
            :language: dockerfile
            :caption: Dockerfile for Apache with PHP 8.4

    ..  tab:: NGINX + PHP-FPM 8.4

        ..  literalinclude:: _codesnippets/_Dockerfile-fpm-php
            :language: dockerfile
            :caption: Dockerfile for PHP 8.4 with FPM (for NGINX)

        See :ref:`system-requirements-nginx` for NGINX configuration.

        This image provides PHP-FPM only and is intended to be used together with a
        separate NGINX container. For guidance on configuring NGINX and PHP-FPM
        containers to work together, refer to the official Docker documentation:

        https://docs.docker.com/samples/php/#nginx--php-fpm

The Dockerfiles reference a `php.ini` file with recommended settings:

..  literalinclude:: _codesnippets/_php.ini
    :language: ini
    :caption: Custom php.ini used in Dockerfiles

..  seealso::

    For official base images, see:

    *   PHP images: https://hub.docker.com/_/php
    *   NGINX images: https://hub.docker.com/_/nginx

    Refer to these pages for available image variants (e.g. Alpine, FPM) and
    supported tags for each version.

.. _system-requirements-docker-database-images:

Recommended Docker images for TYPO3-compatible databases
--------------------------------------------------------

When using TYPO3 in Docker-based environments, the following official
images are commonly used for supported databases:

*   MySQL: `mysql:8.0 <https://hub.docker.com/_/mysql>`_
*   MariaDB: `mariadb:10.6 <https://hub.docker.com/_/mariadb>`_
*   PostgreSQL: `postgres:15 <https://hub.docker.com/_/postgres>`_
*   SQLite: Included as an embedded library in PHP; no separate container
    needed.

These images can be used with Docker Compose or similar orchestration tools.
Ensure proper volume mounts and configuration (users, encoding, collation)
for TYPO3 compatibility.

.. _system-requirements-local-environments:

Using DDEV for local TYPO3 development
======================================

DDEV is a widely used and recommended solution for running TYPO3 projects
locally. It provides a preconfigured Docker-based environment with TYPO3-
compatible PHP, web server, and database services.

To set up a TYPO3 project with PHP 8.4, run:

..  code-block:: bash

    ddev config --php-version 8.4 --docroot public --project-type typo3

This will generate the necessary configuration and allow you to start the
project using:

..  code-block:: bash

    ddev start

DDEV supports Composer-based TYPO3 projects and works on Linux, macOS, and
Windows. It is ideal for teams and reproducible local setups.

..  seealso::

    For full DDEV documentation, see:

    *   https://ddev.readthedocs.io/en/stable/users/cli-usage/#typo3


..  _system-requirements-database:

Supported database systems and required permissions
===================================================

TYPO3 supports the following relational database systems:

* MySQL
* MariaDB
* PostgreSQL
* SQLite

See the `system requirements <https://get.typo3.org/>`_  for the minimum database versions supported.

Each system has specific configuration and extension requirements.
See the list of required PHP extensions for supported databases:

* https://docs.typo3.org/permalink/t3coreapi:system-requirements-php-database-extensions

The database user must be granted specific privileges to allow TYPO3 to
function correctly.

..  _system-requirements-database-privileges:

Required database privileges for TYPO3
--------------------------------------

**Required:**

* `SELECT`, `INSERT`, `UPDATE`, `DELETE`
* `CREATE`, `DROP`, `INDEX`, `ALTER`
* `CREATE TEMPORARY TABLES`, `LOCK TABLES`

**Recommended:**

* `CREATE VIEW`, `SHOW VIEW`
* `EXECUTE`, `CREATE ROUTINE`, `ALTER ROUTINE`

**SQL mode compatibility**

TYPO3 expects compatibility with the default `SQL_MODE` settings of
supported databases.

These SQL modes are tested and supported:

* `STRICT_ALL_TABLES`
* `STRICT_TRANS_TABLES`
* `ONLY_FULL_GROUP_BY`
* `NO_ENGINE_SUBSTITUTION`
* `ERROR_FOR_DIVISION_BY_ZERO`

The following mode is known to be incompatible:

* `NO_BACKSLASH_ESCAPES`

Custom or third-party extensions should be tested individually.

..  _system-requirements-web-server-composer:

Composer usage in TYPO3 projects
================================

Composer is required for `Composer-based TYPO3 installations <https://docs.typo3.org/permalink/t3coreapi:installation-composer>`_
and is commonly used in modern development workflows.

It is not required for `Classic mode installations <https://docs.typo3.org/permalink/t3coreapi:legacyinstallation>`_
using the source package.

In production environments, Composer is not needed if the project is
deployed using file-based methods (for example
`Rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_,
`Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_).

..  seealso::

    For Composer installation and usage instructions, see:

    https://getcomposer.org
