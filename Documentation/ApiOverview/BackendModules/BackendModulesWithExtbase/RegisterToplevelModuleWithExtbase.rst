.. include:: /Includes.rst.txt
.. index:: Backend modules; Toplevel

.. _backend-modules-extbase-toplevel-module:

====================================
Register a toplevel module (Extbase)
====================================

This page describes how to register a toplevel menu with extbase.

Toplevel modules like "Web" or "File" are registered with the same A

:file:`ext_tables.php`:

.. code-block:: php

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'MyExtension',
        'mysection',
        '',
        '',
        [],
        [
            'access' => '...',
            'iconIdentifier' => '...',
            'labels' => '...',
        ]
    );

This adds a new toplevel module ``mysection``. This identifier can now
be used to add submodules to this new toplevel module:

.. code-block:: php

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'MyExtension',
        'mymodule1',
        'mysection',
        '',
        [],
        [
            'access' => '...',
            'labels' => '...'
        ]
    );

.. note::
   The main module name should contain only lowercase characters. Do not use an underscore or dash.
