..  include:: /Includes.rst.txt
..  index:: Events; AfterFolderAddedEvent
..  _AfterFolderAddedEvent:

=======================
`AfterFolderAddedEvent`
=======================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFolderAddedEvent`
is fired after a folder was added to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.

This allows to customize permissions or set up editor permissions automatically
via listeners.

..  _after-folder-added-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-folder-added-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFolderAddedEvent.rst.txt
