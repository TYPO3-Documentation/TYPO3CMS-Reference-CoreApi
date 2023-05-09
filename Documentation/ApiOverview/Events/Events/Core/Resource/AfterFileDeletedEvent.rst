..  include:: /Includes.rst.txt
..  index:: Events; AfterFileDeletedEvent
..  _AfterFileDeletedEvent:

=====================
AfterFileDeletedEvent
=====================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileDeletedEvent`
is fired after a file was deleted.

*Example*: If an extension provides additional functionality (for example
variants), this event allows listeners to also clean up their custom handling.
This can also be used for versioning of files.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileDeletedEvent.rst.txt
