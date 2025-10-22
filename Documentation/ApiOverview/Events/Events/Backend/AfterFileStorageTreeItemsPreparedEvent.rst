..  include:: /Includes.rst.txt
..  index:: Events; AfterFileStorageTreeItemsPreparedEvent
..  _AfterFileStorageTreeItemsPreparedEvent:

======================================
AfterFileStorageTreeItemsPreparedEvent
======================================

..  versionadded:: 14.0
    This PSR-14 event was introduced to add visual cues and improved
    accessibility for editors working with file storage and folders.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterFileStorageTreeItemsPreparedEvent`
allows file storage tree items to be modified.

It is dispatched in the :php:`\TYPO3\CMS\Backend\Controller\FileStorage\TreeController`
class after the file storage tree items have been resolved and prepared. The event
provides the current PSR-7 request object and the file storage tree items.

..  _AfterFileStorageTreeItemsPreparedEvent-labels:

Labels
======

Tree node labels can be defined to improve accessibility. Each node can
have multiple labels, sorted by priority, with the highest priority label
taking precedence. All the other labels will be added to the title attribute of
the node.

A label can be assigned to a node in user TSconfig using a folder identifier path:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    options.folderTree.label.1:/campaigns {
        label = Main Storage
        color = #ff8700
    }


..  _AfterFileStorageTreeItemsPreparedEvent-status:

Status information
==================

Status information can be added via the event to provide additional
visual cues. Like labels, status information is sorted by priority, and
only the highest priority status information is displayed. All status
labels are added to the title attribute.

..  _AfterFileStorageTreeItemsPreparedEvent-example:

Example
=======

..  literalinclude:: _AfterFileStorageTreeItemsPreparedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/ModifyFileStorageTreeItems.php

..  _AfterFileStorageTreeItemsPreparedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AfterFileStorageTreeItemsPreparedEvent.rst.txt

..  note::

    The folder identifier path used in TSconfig must not be URL-encoded.
    For example, use :typoscript:`1:/` instead of :typoscript:`1%3A%2F`.
