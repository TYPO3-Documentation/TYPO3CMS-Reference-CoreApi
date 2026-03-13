.. include:: /Includes.rst.txt
.. index::
   Extension development; Concepts
.. _extension-concepts:
.. _extension-further-reading:
.. _extension-architecture-introduction:

====================================
The concepts behind TYPO3 extensions
====================================

The **TYPO3 CMS is built entirely out of extensions**. The Core consists of
"system extensions" — some mandatory, others optional.

Thousands of extensions are available in the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`_,
and many more are hosted on platforms like `GitHub <https://github.com/>`_.

And for Composer-based setups, TYPO3 can pull in any PHP packages from
`Packagist <https://packagist.org/>`_.

Extensions allow TYPO3 to be extended in unlimited directions due to the robust
TYPO3 Extension API - and without compromising backward compatibility.

.. _extensions-core:

System extensions
=================

System extensions deliver TYPO3 core functionality. They have the Composer
type `typo3-cms-framework`.

In classic mode installations you can find them in the
:file:`typo3/sysext` directory.

These are the most important ones:

:composer:`typo3/cms-core`
    Defines essential database tables (e.g., BE users, groups, pages, sys\_*) and
    default global configuration
    (:file:`core/Configuration/DefaultConfiguration.php`). It also provides a
    large set of PHP base classes.

:composer:`typo3/cms-backend`
    Powers the TYPO3 backend interface including controllers, PHP classes, and
    the Fluid templates needed to operate the admin environment.

:composer:`typo3/cms-frontend`
    Handles frontend rendering. Key components include content object classes
    in :file:`frontend/Classes/ContentObject`, which provide output for
    content types.

:composer:`typo3/cms-extbase`
    TYPO3’s MVC framework. Provides structure for extensions. Works alongside
    Fluid, which handles the "View" layer.

:composer:`typo3/cms-fluid`
    A standalone templating engine and the "View" in MVC. This extension
    includes templating logic and many ViewHelpers
    (:file:`fluid/Classes/ViewHelpers`) for building flexible and reusable templates.

:composer:`typo3/cms-install`
    Contains the Install Tool, which is used for system setup, upgrades, and configuration.

.. tip::

    You can use `Composer Helper on get.typo3.org <https://get.typo3.org/misc/composer/helper>`_
    to generate a Composer command. Choose between default, minimal, or full TYPO3 installation presets,
    select optional individual packages and specify your desired TYPO3 version.

.. _extension-scope:

Scope of extensions: System, third-party or custom
==================================================

Extension files are installed in the:file:`vendor/`
folder by Composer. See also :ref:`directory-vendor`.

In Classic mode installations they are found in :ref:`classic-directory-typo3-sysext`
(system extensions) or :ref:`classic-directory-typo3conf-ext` (third-party
and custom extensions).

.. _extension-local:

Third-party and custom extensions
---------------------------------

Third-party and custom extensions must have Composer type `typo3-cms-extension`:

..  code-block:: json
    :caption: EXT:my_extension/composer.json`

    {
        "name": "myvendor/my-extension",
        "type": "typo3-cms-extension",
        "...": "..."
    }

The extension will be installed in the :ref:`vendor/ <directory-vendor>`
directory by Composer. Custom extensions like sitepackages
or extensions planned to be used in just one project can be kept under version
control in a directory like :ref:`directory-packages`. They are then
symlinked into :file:`vendor/` by Composer.

In Classic mode installations third-party extensions are installed into
:ref:`classic-directory-typo3conf-ext`. Custom extensions can be kept in a
directory outside of the project root and symlinked into :file:`typo3conf/ext/`
or manually inserted in the directory.

.. _extension-global:
.. _extension-system:

System extensions
-----------------

System extensions have Composer type `typo3-cms-framework`:

..  code-block:: json
    :caption: EXT:core/composer.json`

    {
        "name": "typo3/cms-core",
        "type": "typo3-cms-framework",
        "...": "..."
    }

Composer installs TYPO3 extensions (including system extensions) in the
:ref:`vendor/ <directory-vendor>` directory.

In Classic mode installations they are installed in
:ref:`classic-directory-typo3-sysext`.
