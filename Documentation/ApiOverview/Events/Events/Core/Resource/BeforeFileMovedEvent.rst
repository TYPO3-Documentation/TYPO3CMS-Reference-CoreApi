..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileMovedEvent
..  _BeforeFileMovedEvent:

======================
`BeforeFileMovedEvent`
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileMovedEvent`
is fired before a file is about to be moved within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

..  _before-file-moved-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-file-moved-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Resource\Event\BeforeFileMovedEvent
