.. include:: /Includes.rst.txt

.. _extension-scope:

===============================
System and Local Extensions
===============================

The files for an extension are installed into a folder named :file:`vendor`
by composers. See also :ref:`directory-vendor`

In legacy installations they are found in :ref:`legacy-directory-typo3-sysext`
(system extensions) or :ref:`legacy-directory-typo3conf-ext` (local extensions).

.. _extension-local:

Local Extensions
================

Local extensions have the Composer type `typo3-cms-extension`:

..  code-block:: json
    :caption: EXT:my_extension/composer.json`

    {
        "name": "myvendor/my-extension",
        "type": "typo3-cms-extension",
        "...": "..."
    }

The extension will be installed in the directory :ref:`vendor <directory-vendor>`
in a directory with the vendor and the composer name. In the above example that
would be directory :file:`vendor/myvendor/my-extension`.

In legacy installations local extensions are located in the
:ref:`typo3conf/ext/ <legacy-directory-typo3conf-ext>` directory.

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

The extensions will be installed in the directory :ref:`vendor <directory-vendor>`.
In the above example that would be directory :file:`vendor/typo3/cms-core`.

In legacy installations system extensions are located in the
:ref:`typo3/sysext/ <legacy-directory-typo3>` directory.
