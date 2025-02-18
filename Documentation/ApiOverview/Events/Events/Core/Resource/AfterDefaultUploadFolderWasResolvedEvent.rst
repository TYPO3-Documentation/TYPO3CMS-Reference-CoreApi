..  include:: /Includes.rst.txt
..  index:: Events; AfterDefaultUploadFolderWasResolvedEvent
..  _AfterDefaultUploadFolderWasResolvedEvent:

========================================
AfterDefaultUploadFolderWasResolvedEvent
========================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterDefaultUploadFolderWasResolvedEvent`
allows to modify the default upload folder after it has been resolved for the
current page or user.

Example
=======

..  literalinclude:: _AfterDefaultUploadFolderWasResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterDefaultUploadFolderWasResolvedEvent.rst.txt
