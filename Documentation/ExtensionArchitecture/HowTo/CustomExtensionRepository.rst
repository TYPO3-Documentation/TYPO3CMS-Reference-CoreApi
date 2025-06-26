:navigation-title: Extension repositories

.. include:: /Includes.rst.txt
.. index:: Custom Extension Repository
.. _custom-extension-repository:

===========================
Custom Extension Repository
===========================

.. note::

   This section is only relevant for Classic mode installations,
   as Composer Mode installations use the download functionality
   of Composer.

TYPO3 provides functionality that connects to a different repository type
than the "official" TER_ (TYPO3 Extension Repository) to download third-party extensions.
The API is called "Extension Remotes". These remotes are adapters that allow
fetching a list of extensions via the :php:`ListableRemoteInterface` or downloading
an extension via the :php:`ExtensionDownloaderRemoteInterface`.

It is possible to add new remotes, disable registered remotes
or change the default remote.

.. index:: File; EXT:{extkey}/Configuration/Services.yaml

Custom remote configuration can be added in the
:file:`Configuration/Services.yaml` of the corresponding extension.

.. code-block:: yaml

  extension.remote.myremote:
    class: 'TYPO3\CMS\Extensionmanager\Remote\TerExtensionRemote'
    arguments:
      $identifier: 'myremote'
      $options:
         remoteBase: 'https://my_own_remote/'
    tags:
      - name: 'extension.remote'
        default: true

Using :yaml:`default: true`, "myremote" will be used as the default remote.
Setting :yaml:`default: true` only works if the defined service
implements :php:`ListableRemoteInterface`.

Please note that :php:`Vendor\SitePackage\Remote\MyRemote` must implement
:php:`ExtensionDownloaderRemoteInterface` to be registered as remote.

To disable an already registered remote, :yaml:`enabled: false` can be set.

.. code-block:: yaml

  extension.remote.ter:
    tags:
      - name: 'extension.remote'
        enabled: false

.. _TER: https://extensions.typo3.org/
