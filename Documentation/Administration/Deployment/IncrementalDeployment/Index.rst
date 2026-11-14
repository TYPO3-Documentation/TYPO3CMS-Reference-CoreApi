:navigation-title: Incremental Deployment

..  include:: /Includes.rst.txt

..  index:: Deployment; Incremental deployment;


..  _manual-deployment-incremental:


======================
Incremental deployment
======================

After the initial deployment, incremental deployments are used to update code and
configuration.

Steps:

..  _prepare-updated-version-locally:

Prepare the updated version locally:
------------------------------------

-   Apply code or configuration changes
-   Run:

    ..  code-block:: bash

        composer install --no-dev

..  _transfer-updated-files:

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

..  _if-database-changes-required:

If database changes are required:
---------------------------------

-   Run the Upgrade Wizard in the TYPO3 backend
-   Or apply schema changes via CLI tools

..  _incremental-deploy-flush-caches:

Flush TYPO3 caches:
-------------------

..  code-block:: bash

    ./vendor/bin/typo3 cache:flush

..  _incremental-deploy-update-reference-index:

Update the reference index:
---------------------------

..  code-block:: bash

    ./vendor/bin/typo3 referenceindex:update

TYPO3 reads relations from the reference index, also in the frontend.
Update it whenever a deployment adds, removes, or updates an extension or
the TYPO3 Core, as this can change the relations defined in TCA. Updating
it after every deployment is recommended. See
`Update reference index <https://docs.typo3.org/permalink/t3coreapi:update-reference-index>`_.

..  note::

    Use a deployment script or tool such as
    `rsync <https://docs.typo3.org/permalink/t3coreapi:deployment-rsync>`_ or
    `Deployer <https://docs.typo3.org/permalink/t3coreapi:deployment-deployer>`_
    to automate incremental deployments and avoid overwriting persistent data.
