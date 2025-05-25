.. include:: /Includes.rst.txt
.. _upgradingextensions:

====================
Upgrading extensions
====================

How you upgrade extensions depends on your role and project setup:

-   If you use third-party extensions, update them via Composer or the
    Extension Manager.
-   If you **maintain your own custom extension or site package**, refer to
    the dedicated guide on updating your codebase.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :card-height: 100

    ..  card:: :ref:`Managing extensions with Composer <extensions-composer>`

        Covers installation, upgrades, downgrades, removal, and update reverts
        for Composer-based TYPO3 projects.

        *   :ref:`Upgrade an extension <extensions-composer-update>`
        *   :ref:`Downgrade an extension <extensions-composer-downgrade>`
        *   :ref:`Revert updates safely <extensions-composer-update-revert>`

    ..  card:: :ref:`Managing extensions via Extension Manager <extensions-classic-mode-management>`

        For projects not using Composer, extensions can be installed and updated
        using the TYPO3 backend's Extension Manager.

        *   :ref:`Extension Manager documentation <extensions-classic-mode-management>`

    ..  card:: :ref:`Maintaining your own extension <update-extension>`

        If you are maintaining a custom extension or site package, see this
        guide for tips on versioning, upgrading for new TYPO3 releases, and
        ensuring compatibility.

        *   :ref:`Update strategy for extension maintainers <update-extension>`
