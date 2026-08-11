..  include:: /Includes.rst.txt
..  index:: Events; ModifyIconForResourcePropertiesEvent
..  _ModifyIconForResourcePropertiesEvent:

======================================
`ModifyIconForResourcePropertiesEvent`
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\ModifyIconForResourcePropertiesEvent`
is dispatched when an icon for a resource (file or folder) is fetched, allowing
to modify the icon or overlay in an event listener.

..  _modify-icon-for-resource-properties-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _modify-icon-for-resource-properties-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/ModifyIconForResourcePropertiesEvent.rst.txt
