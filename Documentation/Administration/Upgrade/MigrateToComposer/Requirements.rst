..  include:: /Includes.rst.txt
..  highlight:: bash

============
Requirements
============

TYPO3 version
=============

Composer packages for TYPO3 can be found on `packagist.org`_ down to version
6.2.0: `typo3/cms-*`_.

..  _packagist.org: https://packagist.org/
..  _typo3/cms-*: https://packagist.org/search/?query=typo3%2Fcms-%2A

Composer
========

Composer is a program that is written in PHP. Instructions for downloading and
installing Composer can be found on `getcomposer.org`_.

..  _getcomposer.org: https://getcomposer.org/

Your host needs to be able to execute the :bash:`composer` binary.

Folder structure
================

If the root folder of your project is identical to your web root folder, you
need to change this. Composer will add a :file:`vendor/` folder to your project
root, and if your project root and your web root are identical, this can
be a security issue: files in the :file:`vendor/` folder could be directly
accessible via HTTP request.

**Bad:**

..  code-block:: none
    :caption: Page tree of directory typo3_root

    $ tree typo3_root
    ├── index.php
    ├── fileadmin/
    ├── typo3/
    ├── typo3conf/
    └── typo3temp/

You will need a web root folder in your project. You can find many
tutorials with different names for your web root folder (e.g. :file:`www/`,
:file:`htdocs/`, :file:`httpdocs/`, :file:`wwwroot/`, :file:`html/`).
The truth is: the name does not matter because we can configure it in the
settings in a later step. We will use :file:`public/` in our example.

**Bad:**

..  code-block:: none
    :caption: Page tree of directory typo3_root

    $ tree typo3_root
    └── cms/ (web root)
        └── public/
            ├── index.php
            ├── fileadmin/
            ├── typo3/
            ├── typo3conf/
            └── typo3temp/

Here you would access the installation via `https://example.com/cms/public/index.php`,
which would also be a security issue as any other directory outside of the
dedicated project root directory could be accessible.

Also having a directory structure like that can create file and directory
resolving issues within the TYPO3 backend.

**Good:**

..  code-block:: none
    :caption: Page tree of directory typo3_root

    $ tree typo3_root
    └── public/
        ├── index.php
        ├── fileadmin/
        ├── typo3/
        ├── typo3conf/
        └── typo3temp/

..  todo: What does refactor concrete mean?

If you do not have such a web root directory, you will have to refactor your
project before proceeding. First, you create the new directory :file:`public/` and
basically move everything you have inside that subdirectory. Then check all
of your custom code for path references that need to be adjusted to add
the extra :file:`public/` part inside of it. Usually, HTTP(S) links are relative
to your root, so only absolute path references may need to be changed (e.g. cronjobs,
CLI references, configuration files, :file:`.gitignore`, ...).

Please be aware that you very likely need to tell your web
server about the changed web root folder if necessary. You do that by changing a
`DocumentRoot` (Apache) or `root` (Nginx) configuration option. Most hosting
providers offer a user interface to change the base directory of your project.

For local development with `DDEV <https://ddev.com>`__ or `Docker <https://docker.com>`
you will also need to adjust the corresponding configuration files.

Git version control, local development and deployment
=====================================================

This migration guide expects that you are working locally with your project and use
Git version control for it.

If you previously used the TYPO3 Legacy installation (from a release ZIP) and did
not yet use Git versioning, this is a good time to learn about version control first.

All operations should ideally take place in a separate branch of your Git repository.
Only when everything is completed you should move your project files to your
staging/production instance (usually via :ref:`deployment <t3start:deploytypo3>`,
or via direct file upload to your site). If you do not yet use deployment techniques, this is
a good time to learn about that.

Composer goes hand in hand with a good version control setup and a deployment workflow.
The initial effort to learn about all of this is well worth your time, it will
make any project much smoother and more maintainable.

Local development platforms like `DDEV <https://ddev.com/>`__, `Docker <https://docker.com>`__
or `XAMPP/WAMPP/MAMPP <https://geekflare.com/lamp-lemp-mean-xampp-stack-intro/>`__
allow you to easily test and maintain TYPO3 projects, based on these git, docker and
composer concepts.

Of course you can still perform the Composer migration on your live site without
version control and without deployment, but during the migration your site will not be
accessible, and if you face any problems, you may not be able to easily revert to the
initial state.

..  todo: Point to a good guide for deployment and version control


Code integrity
==============

Your project must have the TYPO3 Core and all installed extensions in their
original state. If you applied manual changes to the files, these will
be lost during the migration steps.

..  note::
    If you need to apply hotfixes or patches to system extensions or publicly
    available extensions, this `tutorial about applying patches via Composer`_
    could help, but requires some advanced steps.


..  _tutorial about applying patches via Composer: https://typo3worx.eu/2017/08/patch-typo3-using-composer/
