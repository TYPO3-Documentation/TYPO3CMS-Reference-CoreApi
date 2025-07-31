:navigation-title: Incremental Deployment

..  include:: /Includes.rst.txt

.. index:: Deployment; Incremental deployment;


..  _manual-deployment-incremental:


======================
Incremental deployment
======================

After the initial deployment, incremental deployments are used to update code and
configuration.

Steps:

..  _prepare_updated_version_locally:

Prepare the updated version locally:
------------------------------------

-   Apply code or configuration changes
-   Run:

    ..  code-block:: bash

        composer install --no-dev

..  _transfer_updated_files:

Transfer only updated files to the server
-----------------------------------------

Include:

-   `public/` (excluding `fileadmin/`, `uploads/`)
-   `config/`
-   `vendor/`
-   `composer.lock`
-   etc.

Do not include dynamic or environment-specific files such as:

-   :path:`var/`, :path:`public/fileadmin/`, (these are managed on the server)

You can speed up the transfer using archive tools like zip or tar, or use
`rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_
to copy only changed files.

..  _if_database_changes_required:

If database changes are required:
---------------------------------

-   Run the Upgrade Wizard in the TYPO3 backend
-   Or apply schema changes via CLI tools

..  _incremental_deploy_flush_caches:

Flush TYPO3 caches:
-------------------

.. code-block:: bash

    ./vendor/bin/typo3 cache:flush

..  note::

    Use a deployment script or tool such as
    `rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_ or
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
    to automate incremental deployments and avoid overwriting persistent data.
