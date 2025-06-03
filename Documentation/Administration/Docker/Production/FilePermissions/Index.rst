:navigation-title: File Permissions

..  include:: /Includes.rst.txt
..  _docker-permissions-intro:

========================================
File permissions in Docker on production
========================================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

TYPO3 running in Docker may behave differently in production environments
compared to local development. A common issue during deployment is
incorrect file permissions or ownership, particularly when using mounted
volumes.

This document describes how to handle permissions when deploying
TYPO3 in a Docker-based setup on a server.

..  contents:: Table of contents

..  _docker-file-permissions:

Why TYPO3 file permissions fail in Docker-based deployments
===========================================================

The same rules about `secure file permissions (operating system
level) <https://docs.typo3.org/permalink/t3coreapi:security-file-directory-permissions>`_
as in other deployment methods should be followed.

Minimum requirements:

-   All files under `/var/www/html` must be owned by `www-data`
-   Directories should have permissions of `755` (or `775` if group write
    access is required)
-   Files should have permissions of `644`

Writable directories include, in Classic mode:

-   `/var/www/html` (root folder) – TYPO3 may create `FIRST_INSTALL` here
-   `/var/www/html/typo3temp/`
-   `/var/www/html/fileadmin/`
-   `/var/www/html/typo3conf/`

Composer mode:

-   `/var/www/html/public` (document root folder) – TYPO3 may create `FIRST_INSTALL` here
-   `/var/www/html/var/`
-   `/var/www/html/public/fileadmin/`
-   `/var/www/html/conf/`


..  note::

    `755` is usually sufficient and preferable in production environments.
    Use `775` only if the environment or volume setup requires group write
    access.

..  _docker-permissions-checking-permissions:

How to check file permissions in TYPO3 Docker environments
==========================================================

Depending on the hosting setup, it may or may not be possible to verify or
fix permissions manually.

If SSH access to the container is available:

..  code-block:: bash

    ls -ld /var/www/html
    ls -l /var/www/html

This allows inspection of ownership and write access for TYPO3 directories
such as `typo3temp/`, `fileadmin/`, and others.

If no shell access is available, contact the hosting provider:

-   Ask whether volumes are mounted read-only or owned by `root`
-   Confirm whether the web server is running as `www-data`
-   Request that the TYPO3 folders are writable by the web server user

In container-based platforms, incorrect volume mounts can prevent TYPO3 from
writing essential files. This may lead to HTTP 500 errors with no log output.

..  _docker-permissions-symptoms:

Symptoms of permission issues in TYPO3 Docker installations
===========================================================

-   HTTP 500 Internal Server Error
-   No output in Apache or PHP logs
-   Web installer does not load even if `FIRST_INSTALL` is present
-   TYPO3 CLI (`./typo3/sysext/core/bin/typo3`) works, but the frontend does not
-   TYPO3 fails to write cache or configuration files

..  _docker-permissions-how-to-fix:

Fixing ownership and permissions inside the TYPO3 Docker container
==================================================================

TYPO3 must be able to write to specific directories to operate correctly.
Incorrect ownership or permissions may cause the application to return
HTTP 500 errors or fail during setup.

..  _docker-permissions-fix-with-ssh:

If shell access to the container is available
---------------------------------------------

Run the following commands inside the container:

..  code-block:: bash

    chown -R www-data:www-data /var/www/html
    chmod -R 755 /var/www/html

This ensures that Apache and PHP-FPM can read and write all the required files
and folders.

..  _docker-permissions-no-ssh:

If no shell access to the container is available
------------------------------------------------

In environments without shell access to the container, such as shared or
managed hosting, there are two possible approaches:

1.  Ensure correct ownership during the image build or deployment process.

    Example Dockerfile instruction:

    ..  code-block:: dockerfile
        :caption: Dockerfile

        RUN chown -R www-data:www-data /var/www/html

2.  Contact the hosting provider to request the following:

    -   Set ownership of `/var/www/html` to `www-data`
    -   Ensure write permissions (typically `755` for directories)

..  note::

    It is technically possible to run a helper container to modify file
    permissions if Docker CLI access is available, but this is rarely
    feasible or recommended on production servers. It should only be used in
    local development or advanced DevOps environments.

..  _docker-permissions-prevent-issues:

Preventing permission problems in production Docker environments
================================================================

To prevent permission-related issues:

-   Mount volumes in a way that aligns ownership with the container’s web
    server user (`www-data`)
-   In CI/CD pipelines, avoid generating files owned by `root`
-   Use a custom `entrypoint.sh` script to apply ownership and permissions
    automatically during startup

..  _docker-permissions-entrypoint:

Using a custom entrypoint to automatically set TYPO3 permissions
================================================================

Permissions can be set during container startup by including a custom
entrypoint script in the Docker image.

..  code-block:: bash
    :caption: entrypoint.sh

    #!/bin/sh
    chown -R www-data:www-data /var/www/html
    exec apache2-foreground

..  code-block:: dockerfile
    :caption: Dockerfile

    COPY entrypoint.sh /entrypoint.sh
    RUN chmod +x /entrypoint.sh
    ENTRYPOINT ["/entrypoint.sh"]

..  _docker-permissions-mounted-volume-example:

Example: resolving permission issues from mounted host volumes
==============================================================

If the Docker container uses a bind mount:

..  code-block:: yaml

    volumes:
        - ./html:/var/www/html

and the host system owns `./html` as `root`, Apache inside the container will
not be able to write files, resulting in a 500 error.

To fix this issue:

..  code-block:: bash

    docker exec -it <container> bash
    chown -R www-data:www-data /var/www/html
    chmod -R 755 /var/www/html

then reload the TYPO3 site.

..  _docker-permissions-debugging-tools:

Commands to debug permission issues in TYPO3 Docker containers
==============================================================

The following commands may help identify and resolve permission issues:

..  code-block:: bash

    # Inspect file ownership and permissions
    ls -l /var/www/html

    # Check the user Apache is running as
    ps aux | grep apache

    # Verify PHP installation and modules
    php -v
    php -m

    # Check the Apache error log
    tail -f /var/log/apache2/error.log

    # Create a test file to verify PHP via HTTP
    echo "<?php phpinfo();" > /var/www/html/info.php

    # Confirm PHP is executed via HTTP
    curl http://localhost/info.php

    # Remove the file immediately after testing
    rm /var/www/html/info.php

..  _docker-permissions-final-notes:

Ensuring stable deployment through correct permissions
======================================================

Correct file permissions are critical for TYPO3 to function properly in
Docker-based environments. Ensuring that files are owned by `www-data` and
that relevant directories are writable helps prevent unexpected behavior such
as blank pages or failed installations.
