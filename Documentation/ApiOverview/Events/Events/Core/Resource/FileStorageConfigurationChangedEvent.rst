..  include:: /Includes.rst.txt
..  index:: Events; FileStorageConfigurationChangedEvent
..  _FileStorageConfigurationChangedEvent:

======================================
`FileStorageConfigurationChangedEvent`
======================================

..  versionadded:: 15.0
    :changelog: feature-110762-1789862502

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\FileStorageConfigurationChangedEvent`
is dispatched after TYPO3 wrote the file
`config/system/file-storages.yaml <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages>`_.
The property `identifier` holds the identifier of the changed storage. It is
`null` when one write changed several storages or the whole file.

TYPO3 itself uses the event to flush the storages it has already loaded.

..  _FileStorageConfigurationChangedEvent-example:

Example listener for `FileStorageConfigurationChangedEvent`
===========================================================

..  include:: /_includes/EventsContributeNote.rst.txt

..  _FileStorageConfigurationChangedEvent-api:

API of `FileStorageConfigurationChangedEvent`
=============================================

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\FileStorageConfigurationChangedEvent
