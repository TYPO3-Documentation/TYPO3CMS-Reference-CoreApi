..  include:: /Includes.rst.txt
..  index:: Events; AfterFileAddedEvent
..  _AfterFileAddedEvent:

===================
AfterFileAddedEvent
===================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileAddedEvent`
is fired after a file was added to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.

*Example:* Using listeners for this event allows, for example, to post-check
permissions or perform specific analysis of files like additional metadata
analysis after adding them to TYPO3.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileAddedEvent.rst.txt
