.. include:: /Includes.rst.txt
.. index::
   Extension development; Make backend controller
.. _extension-make-backend-controller:

===============================
Create a new backend controller
===============================

If you do not have one yet, :ref:`create a basic extension <extension-make>`
to put the controller in.

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: bash

            vendor/bin/typo3 make:backendcontroller

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 make:backendcontroller

You will be prompted with a list of installed extensions. If your newly created
extension is missing, check if you installed it properly.

When prompted, choose a name and path for the backend controller. The following
files will be generated, new or changed files marked with a star (*):

..  code-block:: none
    :caption: Page tree of directory :file:`src/extensions`

    $ tree src/extensions
    └── my-test
        ├── Classes
        |   └── Backend (*)
        |   |   └── Controller (*)
        |   |   |   └── MyBackendController.php (*)
        ├── Configuration
        |   ├── Backend (*)
        |   |   └── Routes.php (*)
        |   └── Services.yaml (*)
        ├── composer.json
        └── ext_emconf.php

Learn how to turn the backend controller into a full-fledged backend module in
the chapter :ref:`backend-modules`.
