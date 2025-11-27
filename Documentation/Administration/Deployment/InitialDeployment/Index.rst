:navigation-title: Initial Deployment

..  include:: /Includes.rst.txt

.. index:: Deployment; Initial deployment;

..  _manual-deployment-initial:

==================
Initial deployment
==================

This is the first deployment of TYPO3 to a production environment. It includes
setting up the full application, database, and user-generated content.

Steps:

..  _build_project_locally:

Build the project locally:
--------------------------

..  code-block:: bash

    composer install --no-dev

..  _export_local_database:

Export the local database
-------------------------

Export the local database using `mysqldump <https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html>`_,
`ddev export-db <https://ddev.readthedocs.io/en/stable/users/cli-usage/>`_,
or a GUI-based tool like Heidi SQL or phpmyadmin.

..  tabs::

    ..  group-tab:: Linux / macOS / WSL

        ..  code-block:: bash

            mysqldump -u <user> -p -h <host> <database_name> > dump.sql

    ..  group-tab:: DDEV

        ..  code-block:: bash

            ddev export-db --file=dump.sql

The database credentials can either be entered during the installation process
using the Install Tool, or manually adjusted later in the file :path:`config/system/settings.php`.

..  _transfer_files_to_server:

Transfer all necessary files to the server
------------------------------------------

Folders to include:

-   :path:`public/`
-   :path:`config/`
-   :path:`vendor/`,
-   Files from the project directory: :file:`composer.json`, :path:`composer.lock`

You can speed up the transfer using archive tools like zip or tar, or use
`rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_.

..  _import_database:

Import the database on the production server
------------------------------------------

For example using
`mysql <https://dev.mysql.com/doc/refman/8.0/en/mysql.html>`_:

..  code-block:: bash

    mysql -u <user> -p -h <host> <database_name> < dump.sql

..  note::

    You will be prompted to enter the MySQL user password. Make sure the
    target database exists before running this command.

..  _set_up_server_directories:

Set up shared and writable directories on the server:
-----------------------------------------------------

-   :path:`public/fileadmin/`
-   :path:`var/`

..  _update_web_server:

Update web server configuration:
--------------------------------

-   Set the document root to `public/`
-   Ensure correct permissions for writable folders

..  _initial_deploy_flush_caches:

Flush TYPO3 caches:
-------------------

.. code-block:: bash

    ./vendor/bin/typo3 cache:flush

..  note::

    You can use the `Install Tools <https://docs.typo3.org/permalink/t3start:admin-tools>`_
    to verify folder permissions and environment compatibility.
    Open: `https://example.org/typo3/install.php` and go to
    the :guilabel:`System > Environment` module.
