:navigation-title: Upgrade the Core

..  include:: /Includes.rst.txt
..  _upgradecore:

===========================================
Upgrading to a major release using Composer
===========================================

..  seealso::
    To upgrade a classic installation it is recommended to first switch to
    Composer mode: `Migrate a TYPO3 project to Composer <https://docs.typo3.org/permalink/t3coreapi:migratetocomposer>`_
    and then follow the steps below.

This example details how to upgrade from one LTS release to another. In this
example, the installation is running TYPO3 version 11.5.34 and the new LTS
release is version 12.4.10.

..  _upgradecore-php:

Upgrade the PHP version first during major TYPO3 upgrades
=========================================================

Each TYPO3 version is compatible with at least two PHP versions, with some overlap. When
upgrading to a new major TYPO3 version, **first update PHP** to the highest
version your current TYPO3 version supports.

Test your project thoroughly. Fix any PHP-related issues in custom extensions
and configurations before proceeding.

Next, upgrade TYPO3 while keeping the PHP version unchanged. This will help you
to identify whether errors stem from the TYPO3 core or from PHP.

During development, tools like DDEV make it easy to switch PHP versions.
Some hosting environments also allow multiple PHP versions. Try changes in a
staging or relaunch setup before updating production.

..  _upgradecore-extension:

Check each currently installed extension for compatible versions
================================================================

Many TYPO3 extensions are compatible with two major TYPO3 versions. If an extension in
your project follows this pattern, update it to the highest version still
compatible with your current TYPO3 version. This will help you identify whether
issues are caused by the TYPO3 core or the extension itself.

..  tip::
    Check each extension's changelog (if it exists) before you update an extension.

Ensure all extensions you use are available for the TYPO3 version you're
upgrading to. If a third-party extension isn’t ready, consider supporting or
sponsoring the author to update it. Some agencies offer early access to updated
extensions for a fee.

If an extension is no longer maintained, look for alternatives. Abandoned
extensions are sometimes forked and maintained by others. As a last resort, you
can fork the extension yourself or hire a developer to update it for you.

All custom extensions, including your custom site package (theme), need to be
updated by yourself.

..  seealso::

    *   `Update your extension for new TYPO3 versions <https://docs.typo3.org/permalink/t3coreapi:update-extension>`_

..  _upgradecore-changelog:

Review Core changes in the Changelog before upgrading
=====================================================

TYPO3 system extensions are part of the Core and may change between versions.
Some may be merged, added, deprecated, or removed.

Before starting a major upgrade, make sure to review the TYPO3
:doc:`changelog <ext_core:Index>` for changes to system extensions. This will help
you plan ahead for any required changes.

..  seealso::
    This step is also part of the upgrade preparation process. See:
    `Check the ChangeLog <https://docs.typo3.org/permalink/t3coreapi:check-the-changelog-and-news-md>`_

Being aware of upcoming changes early can help prevent issues during an
upgrade.

..  _install-next-step:
..  _upgradecore-require:

Running :bash:`composer require` with new major version dependencies
====================================================================

..  warning::
    Never try the following on a production system. Work locally and use
    a `deployment strategy <https://docs.typo3.org/permalink/t3coreapi:deployment>`_.

    If you have to work on the server, work on a copy of the production website
    **including a copy of the database**

To upgrade a Composer package, run :bash:`composer require` with the package
name and version number.

For example, to upgrade `typo3/cms-backend` run
:bash:`composer require typo3/cms-backend:^12.4`.

When upgrading to a new major release, each of TYPO3's packages will need to be
upgraded.

Given that a typical installation of TYPO3 will consist of a number of packages,
it is recommended that the `Composer Helper Tool <https://get.typo3.org/go/composer-helper>`_
be used to help generate the Composer upgrade command.

..  note::
    With TYPO3 v12 the `typo3/cms-recordlist` package was merged into
    `typo3/cms-backend`. Therefore, remove the `typo3/cms-recordlist` from your
    :file:`composer.json` file before upgrading:

    ..  code-block:: bash

        composer remove "typo3/cms-recordlist"

Assuming that the packages below are installed locally, the following example
would upgrade each of them to version 12.4.

..  code-block:: bash

    composer require --update-with-all-dependencies "typo3/cms-adminpanel:^12.4" \
    "typo3/cms-backend:^12.4" "typo3/cms-belog:^12.4" "typo3/cms-beuser:^12.4" \
    "typo3/cms-core:^12.4" "typo3/cms-dashboard:^12.4" "typo3/cms-felogin:^12.4" \
    "typo3/cms-filelist:^12.4" "typo3/cms-filemetadata:^12.4" "typo3/cms-fluid:^12.4" \
    "typo3/cms-form:^12.4" "typo3/cms-frontend:^12.4" "typo3/cms-info:^12.4" \
    "typo3/cms-install:^12.4" "typo3/cms-linkvalidator:^12.4" "typo3/cms-lowlevel:^12.4" \
    "typo3/cms-recycler:^12.4" "typo3/cms-rte-ckeditor:^12.4" "typo3/cms-setup:^12.4" \
    "typo3/cms-t3editor:^12.4" "typo3/cms-tstemplate:^12.4" "typo3/cms-viewpage:^12.4"

A typical TYPO3 installation is likely to have multiple third-party extensions
installed and running the above command can create dependency errors.

For example, when upgrading from TYPO3 v11 LTS to v12 LTS an error can occur
stating that `"helhum/typo3-console": "^7.1"` is only compatible with v11 LTS,
with the new version `^8.1` supporting TYPO3 v12 LTS.

For each of these dependency errors, add the version requirement
`"helhum/typo3-console:^8.1"` to the end of your :bash:`composer require` string
and retry the command.

Sometimes version upgrades disrupt Composer’s file structure. If issues persist,
delete the :path:`vendor` folder and possibly also :file:`composer.lock`. Then
manually adjust :file:`composer.json` and run:

..  code-block:: bash

    composer install

Once the upgrade is complete, there are a set of tasks that need to actioned to
complete the process. See :ref:`postupgradetasks`.
