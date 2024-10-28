..  include:: /Includes.rst.txt

===============
Version control
===============

Add to version control system
=============================

If you use a version control system such as Git (and you really should!), it is
important to add both files :file:`composer.json` and :file:`composer.lock`
(which were created automatically during the previous steps). The
:file:`composer.lock` file keeps track of the exact versions that are installed,
so that you are on the same versions as your co-workers (and when deploying to
the live system).

..  seealso::
    `Commit your composer.lock file to version control <https://getcomposer.org/doc/01-basic-usage.md#commit-your-composer-lock-file-to-version-control>`__

..  note::
    It is always good practice to exclude passwords from checked-in files
    (for example, :file:`config/system/settings.php`). A solution may be to add
    the setting containing sensitive information to
    :file:`config/system/additional.php` and use an :file:`.env` file in the
    project directory to configure the password and other configuration along
    with `helhum/dotenv-collector <https://github.com/helhum/dotenv-connector>`__.

Additionally, some files and folders added by Composer should be excluded:

-   :file:`public/index.php`
-   :file:`public/typo3/`
-   :file:`public/typo3conf/ext/`
-   :file:`vendor/`

A :file:`.gitignore` file could look like this:

..  todo: Why should labels be versioned?

..  code-block:: none
    :caption: /.gitignore

    /var/*
    !/var/labels
    /vendor/*
    /public/index.php
    /public/typo3/*

Checkout from version control system
====================================

All your co-workers should always run :bash:`composer install` after they have
checked out the files. This command will install the packages in the appropriate
versions defined in :file:`composer.lock`. This way, you and your co-workers
always have the same versions of the TYPO3 Core and the extensions installed.

Maintaining versions / composer update
======================================

In a living project, from time to time you will want to raise the versions of
the extensions or TYPO3 versions you use.

The proper way to do this is to update each package one by one (or at least
grouped with explicit names, if some packages belong together):

.. code-block:: shell
   :caption: typo3_root$

   composer update georgringer/news helhum/typo3-console

You can also raise the requirements on certain extensions if you want to
include a new major release:

.. code-block:: shell
   :caption: typo3_root$

   composer require someVendor/someExtension:^3.0

For details on upgrading the TYPO3 Core to a new major version, please see
:ref:`upgradecore`.

While it can be tempting to just edit the :file:`composer.json` file manually,
you should ideally use the proper :bash:`composer` commands to not introduce
formatting errors or an invalid configuration.

You should avoid running :bash:`composer update` without specifying package names
explicitly. You can use regular maintenance automation (for example via
`Dependabot <https://github.com/dependabot>`__) to regularly update dependencies
to minor and patch-level releases, if your dependency specifications are set up
like this.

After any update, you should commit the updated :file:`composer.lock` file to your
Git repository. Ideally, you add a commit message which :bash:`composer` command(s) you
specifically executed.
