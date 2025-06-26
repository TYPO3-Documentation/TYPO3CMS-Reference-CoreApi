.. include:: /Includes.rst.txt
.. index::
   Extension development; Concepts
.. _extension-concepts:
.. _extension-further-reading:
.. _extension-architecture-introduction:

===============================
The concept of TYPO3 extensions
===============================

**TYPO3 CMS is built entirely on extensions**. Even the Core consists of modular
"system extensions" — some mandatory, others optional.

Thousands of additional extensions are available via the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`_,
with many more hosted on platforms like `GitHub <https://github.com/>`_.

For Composer-based setups, TYPO3 can also pull in any PHP package from
`Packagist <https://packagist.org/>`_.

Thanks to its robust Extension API, TYPO3 can be extended in virtually any
direction without compromising backward compatibility.

.. _extensions-core:

Notable system extensions
=========================

TYPO3’s core functionality is delivered through system extensions.

System extensions have the Composer type `typo3-cms-framework`

In classic mode installations you can find them in directory
:file:`typo3/sysext`.

Below are the most important ones and what they provide:

:composer:`typo3/cms-core`
    Defines essential database tables (e.g., BE users, groups, pages, sys\_*) and
    default global configuration
    (:file:`core/Configuration/DefaultConfiguration.php`). It also provides a
    large set of foundational PHP classes.

:composer:`typo3/cms-backend`
    Powers the TYPO3 backend interface, including controllers, PHP classes, and
    Fluid templates needed to operate the admin environment.

:composer:`typo3/cms-frontend`
    Handles frontend rendering. Key components include content object classes
    in :file:`frontend/Classes/ContentObject`, which manage output for different
    content types.

:composer:`typo3/cms-extbase`
    TYPO3’s MVC framework. Provides structure for extensions. Works alongside
    Fluid, which handles the "View" layer.

:composer:`typo3/cms-fluid`
    A standalone templating engine and the "View" in TYPO3's MVC. This extension
    includes templating logic and many ViewHelpers
    (:file:`fluid/Classes/ViewHelpers`) to build flexible and reusable templates.

:composer:`typo3/cms-install`
    Contains the Install Tool, used for system setup, upgrades, and configuration.

You can use the `get.typo3.or Composer helper <https://get.typo3.org/misc/composer/helper>`_
to compile composer command for minimal, recommended and full TYPO2 installations

.. _extension-scope:

Scope of extensions: System, third-party or custom
==================================================

The files for an extension are installed into a folder named :file:`vendor/`
by Composer. See also :ref:`directory-vendor`.

In Classic mode installations they are found in :ref:`classic-directory-typo3-sysext`
(system extensions) or :ref:`classic-directory-typo3conf-ext` (third-party
and custom extensions).

.. _extension-local:

Third-party and custom extensions
---------------------------------

Third-party and custom  extensions must have the Composer type `typo3-cms-extension`:

..  code-block:: json
    :caption: EXT:my_extension/composer.json`

    {
        "name": "myvendor/my-extension",
        "type": "typo3-cms-extension",
        "...": "..."
    }

The extension will be installed in the directory
:ref:`vendor/ <directory-vendor>` by Composer. Custom extension like sitepackages
or specialized extensions used only in one project can be kept under version
control in a directory like :ref:`directory-packages`. They are then
symlinked into :file:`vendor/` by Composer.

In Classic mode installations third-party extensions are installed into
:ref:`classic-directory-typo3conf-ext`. Custom extensions can be kept in a
directory outside of the project root and symlinked into :file:`typo3conf/ext/`
or manually inserted in this directory.

.. _extension-global:
.. _extension-system:

System extensions
-----------------

System extensions have the Composer type `typo3-cms-framework`:

..  code-block:: json
    :caption: EXT:core/composer.json`

    {
        "name": "typo3/cms-core",
        "type": "typo3-cms-framework",
        "...": "..."
    }

Composer installs all TYPO3 extensions, including system extensions in the
directory :ref:`vendor/ <directory-vendor>`.

In Classic mode installations they are installed into
:ref:`classic-directory-typo3-sysext`.
