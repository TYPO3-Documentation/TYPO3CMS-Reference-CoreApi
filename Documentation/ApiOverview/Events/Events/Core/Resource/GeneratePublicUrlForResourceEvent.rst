..  include:: /Includes.rst.txt
..  index:: Events; GeneratePublicUrlForResourceEvent
..  _GeneratePublicUrlForResourceEvent:

=================================
GeneratePublicUrlForResourceEvent
=================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\GeneratePublicUrlForResourceEvent`
is fired before TYPO3 FAL's native URL generation for a resource is instantiated.

This allows listeners to create custom links to certain files (for example
restrictions) for creating authorized deep links.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/GeneratePublicUrlForResourceEvent.rst.txt
