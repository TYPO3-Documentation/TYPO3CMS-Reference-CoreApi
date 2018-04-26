.. include:: ../../Includes.txt


.. _extension-scope:

System and Local extensions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The files for an extension are located in a folder named by the
*extension key* . The location of this folder can be either inside
`typo3/sysext/` or `typo3conf/ext/`.

The extension *must* be programmed so that it does automatically
detect where it is located and can work from all three locations.

.. _extension-local:

Local extensions
""""""""""""""""

Local extensions are located in the `typo3conf/ext/` directory.

This is where to put extensions  *which are local* for a particular
TYPO3 installation. The `typo3conf` directory is always local, containing
local configuration (e.g.  `LocalConfiguration.php`), local modules etc.
If you put an extension here it will be available for a single TYPO3
installation only. This is a "per-database" way to install an
extension.

.. _extension-global:
.. _extension-system:

System extensions
"""""""""""""""""

System extensions are located in the `typo3/sysext/` directory.

This is system default extensions which cannot and should not be
updated by the EM. They are distributed with TYPO3 core source code
and generally understood to be a part of the core system.

.. _extension-loading-precedence:

Loading precedence
""""""""""""""""""

Local extensions take precedence which means that if an extension
exists both in `typo3conf/ext/` and `typo3/sysext/` the one in `typo3conf/ext/`
is loaded. This means that extensions are loaded in the
order of priority local-system.
