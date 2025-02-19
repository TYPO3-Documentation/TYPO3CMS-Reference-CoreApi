..  include:: /Includes.rst.txt
..  index:: Events; AfterPagePreviewUriGeneratedEvent
..  _AfterPagePreviewUriGeneratedEvent:

=================================
AfterPagePreviewUriGeneratedEvent
=================================

The :php:`\TYPO3\CMS\Backend\Routing\Event\AfterPagePreviewUriGeneratedEvent`
is executed in :php:`\TYPO3\CMS\Backend\Routing->buildUri()`, after the preview
URI has been built - or set by an event listener to
:ref:`BeforePagePreviewUriGeneratedEvent`. It allows to overwrite the built
preview URI. However, this event does not feature the possibility to modify the
parameters, since this will not have any effect, as the preview URI is directly
returned after event dispatching and no further action is done by the
:php:`\TYPO3\CMS\Backend\Routing\PreviewUriBuilder`.

Example
=======

..  literalinclude:: _AfterPagePreviewUriGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/AfterPagePreviewUriGeneratedEvent.rst.txt
