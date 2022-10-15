.. include:: /Includes.rst.txt

.. _extension-scope:

=========================================
System, third-party and custom extensions
=========================================

The files for an extension are installed into a folder named :file:`vendor/`
by Composer. See also :ref:`directory-vendor`.

In legacy installations they are found in :ref:`legacy-directory-typo3-sysext`
(system extensions) or :ref:`legacy-directory-typo3conf-ext` (third-party
and custom extensions).

.. _extension-local:

Third-party and custom extensions
=================================

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
control in a directory like :ref:`directory-local_packages`. They are then
symlinked into :file:`vendor/` by Composer.

In legacy installations third-party extensions are installed into
:ref:`legacy-directory-typo3conf-ext`. Custom extensions can be kept in a
directory outside of the project root and symlinked into :file:`typo3conf/ext/`
or manually inserted in this directory.


.. _extension-global:
.. _extension-system:

System Extensions
=================

System extensions have the composer type `typo3-cms-framework`:

..  code-block:: json
    :caption: EXT:core/composer.json`

    {
        "name": "typo3/cms-core",
        "type": "typo3-cms-framework",
        "...": "..."
    }

Composer installs all TYPO3 extensions, including system extensions in the
directory :ref:`vendor/ <directory-vendor>`.

In legacy installations they are installed into
:ref:`legacy-directory-typo3-sysext`.
