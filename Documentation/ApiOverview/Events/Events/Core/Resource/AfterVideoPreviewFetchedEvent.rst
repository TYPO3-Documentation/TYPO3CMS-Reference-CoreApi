..  include:: /Includes.rst.txt
..  index:: Events; AfterVideoPreviewFetchedEvent
..  _AfterVideoPreviewFetchedEvent:

=============================
AfterVideoPreviewFetchedEvent
=============================

The purpose of the PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\OnlineMedia\Event\AfterVideoPreviewFetchedEvent`
is to modify the preview file of online media previews (like YouTube and Vimeo).
If, for example, a processed file is bad (blank or outdated), this event can be
used to modify and/or update the preview file.

Example
=======

..  literalinclude:: _AfterVideoPreviewFetchedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterVideoPreviewFetchedEvent.rst.txt
