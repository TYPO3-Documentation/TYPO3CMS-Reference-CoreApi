..  include:: /Includes.rst.txt

..  _upgradecore:

================
Upgrade the Core
================

Upgrading to a major release using Composer
===========================================

This example details how to upgrade from one LTS release to another. In this
example, the installation is running TYPO3 version 12.4.25 and the new LTS
release is version 13.4.3.

Check the required PHP version
------------------------------

TYPO3 13 requires PHP 8.2 as a minimum. Edit the conposer.json file for "config" - "platform" - "php" and set it to a 
valid PHP version.

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
:bash:`composer require typo3/cms-backend:^13.4`.

When upgrading to a new major release, each of TYPO3's packages will need to be
upgraded.

Given that a typical installation of TYPO3 will consist of a number of packages,
it is recommended that the `Composer Helper Tool <https://get.typo3.org/go/composer-helper>`_
be used to help generate the Composer upgrade command.

..  note::
    With TYPO3 v12 the `typo3/cms-recordlist` package was merged into
    `typo3/cms-backend`. With TYPO3 v13 the `typo3/cms-t3editor` package was
    merged into `typo3/cms-backend`. Therefore, if you have one of them
    installed, remove them in your :file:`composer.json` file before upgrading:

    ..  code-block:: bash

        composer remove "typo3/cms-recordlist"
        composer remove "typo3/cms-t3editor"

Assuming that the packages below are installed locally, the following example
would upgrade each of them to version 13.4.

..  code-block:: bash

    composer require --update-with-all-dependencies "typo3/cms-adminpanel:^13.4" \
    "typo3/cms-backend:^13.4" "typo3/cms-belog:^13.4" "typo3/cms-beuser:^13.4" \
    "typo3/cms-core:^13.4" "typo3/cms-dashboard:^13.4"  "typo3/cms-extbase:^13.4" \
    "typo3/cms-extensionmanager:^13.4" "typo3/cms-felogin:^13.4" "typo3/cms-fluid-styled-content:^13.4" \
    "typo3/cms-filelist:^13.4" "typo3/cms-filemetadata:^13.4" "typo3/cms-fluid:^13.4" \
    "typo3/cms-form:^13.4" "typo3/cms-frontend:^13.4" "typo3/cms-impexp:^13.4" \
    "typo3/cms-info:^13.4" "typo3/cms-install:^13.4" "typo3/cms-linkvalidator:^13.4" \
    "typo3/cms-lowlevel:^13.4" "typo3/cms-reactions:^13.4" "typo3/cms-recycler:^13.4" \
    "typo3/cms-rte-ckeditor:^13.4" "typo3/cms-seo:^13.4"  "typo3/cms-setup:^13.4" \
    "typo3/cms-sys-note:^13.4" "typo3/cms-t3editor:^13.4" "typo3/cms-tstemplate:^13.4" \
    "typo3/cms-viewpage:^13.4" "typo3/cms-webhooks:^13.4" 
    

A typical TYPO3 installation is likely to have multiple third-party extensions
installed and running the above command can create dependency errors.

For example, when upgrading from TYPO3 v12 LTS to v13 LTS an error can occur
stating that `"helhum/typo3-console": "^8.1"` is only compatible with v12 LTS,
with the new version `^9.1` supporting TYPO3 v13 LTS.

For each of these dependency errors, add the version requirement
`"helhum/typo3-console:^9.1"` to the end of your :bash:`composer require` string
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
