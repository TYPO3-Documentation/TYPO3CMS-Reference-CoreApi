..  include:: /Includes.rst.txt
..  index:: Events; BeforeResourceStorageInitializationEvent
..  _BeforeResourceStorageInitializationEvent:

==========================================
`BeforeResourceStorageInitializationEvent`
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\BeforeResourceStorageInitializationEvent`
is fired before a resource object is actually built/created.

The method
:php-short:`\TYPO3\CMS\Core\Resource\Event\BeforeResourceStorageInitializationEvent->getRecord()`
returns the options of the storage, and `setRecord()` replaces them. A
listener can, for example, add dynamic values before TYPO3 creates the
:ref:`storage <fal-architecture-components-storage>`. The record holds the
`options of the storage <https://docs.typo3.org/permalink/t3coreapi:fal-administration-storages-options>`_
with all defaults applied, and the key `identifier`.

..  versionchanged:: 15.0
    :changelog: breaking-110762-1789862500

    Before, the record was the row of the table `sys_file_storage`. TYPO3
    still maps the keys of the former row that a listener passes to
    `setRecord()`, such as `is_public` or `processingfolder`, and
    triggers a deprecation. A listener that reads these keys from
    `getRecord()` gets nothing. Use the new keys, such as `public`
    and `processingFolder`.

..  _before-resource-storage-initialization-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-resource-storage-initialization-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\BeforeResourceStorageInitializationEvent
