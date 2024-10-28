..  include:: /Includes.rst.txt

..  _upgradecore:

================
Upgrade the Core
================

Upgrading to a major release using Composer
===========================================

This example details how to upgrade from one LTS release to another. In this
example, the installation is running TYPO3 version 11.5.34 and the new LTS
release is version 12.4.10.

Check which TYPO3 packages are currently installed
--------------------------------------------------

TYPO3's Core contains a mix of required and optional packages. For example,
`typo3/cms-backend` is a required package. `typo3/cms-sys-note` is an optional
package and does not need to be installed for TYPO3 to work correctly.

Prior to upgrading, check which packages are currently installed and make a note
of them.

Running :bash:`composer info "typo3/*"` will output a list of all TYPO3 packages that
are currently installed.


Running :bash:`composer require`
--------------------------------

To upgrade a Composer package, run :bash:`composer require` with the package name and
version number.

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

Monitoring changes to TYPO3's Core
----------------------------------

The system extensions that are developed and exist within TYPO3's Core
are likely to change over time. Some extensions are merged into others, new
system extensions are added and others abandoned.

These changes are published the :doc:`changelog <ext_core:Index>`.


..  _install-next-step:

Next steps
==========

Once the upgrade is complete, there are a set of tasks that need to actioned to
complete the process. See :ref:`postupgradetasks`.
