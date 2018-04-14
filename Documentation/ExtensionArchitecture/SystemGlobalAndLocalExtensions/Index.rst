.. include:: ../../Includes.txt


.. _extension-scope:

System, Global and Local extensions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The files for an extension are located in a folder named by the
*extension key* . The location of this folder can be either inside
`typo3/sysext/`, `typo3/ext/` or `typo3conf/ext/`.

The extension *must* be programmed so that it does automatically
detect where it is located and can work from all three locations. If
it is not possible to make the extension that flexible, it is possible
to lock its installation requirement to one of these locations in the
`ext_emconf.php` file (see "lockType").

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

.. note::
   Local extension can successfully be
   symlinked to other local extensions on a server as long as they are
   running under the same TYPO3 source version (which would typically
   also be symlinked). This method is useful for maintenance of the same
   local extension running under several sites on a server.

.. _extension-global:

Global extensions
"""""""""""""""""

Global extensions are located in the `typo3/ext/` directory.

This is a "per-server" way to install an extension; they are global
for the TYPO3 source code on the web server. These extensions will be
available for any TYPO3 installation sharing the source code.

.. note::
   These features have not been consistently supported in recent versions of TYPO3,
   so you may encounter problems when using it.

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
exists both in `typo3conf/ext/` and `typo3/ext/` the one in `typo3conf/ext/`
is loaded. Likewise  *global* extension takes precedence over
*system* extensions. This means that extensions are loaded in the
order of priority local-global-system.

In effect you can therefore have - say - a "stable" version of an
extension installed in the global dir (typo3/ext/) which is used by
all your projects on a server sharing source code, but on a single
experimental project you can import the same extension in a newer
"experimental" version and for that particular project the locally
available extension will be used instead.

