..  include:: /Includes.rst.txt
..  index:: Events; AfterPagePreviewUriGeneratedEvent
..  _AfterPagePreviewUriGeneratedEvent:

=================================
AfterPagePreviewUriGeneratedEvent
=================================

..  versionadded:: 12.0
    This PSR-14 event replaces the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['viewOnClickClass']`
    postProcess hook.

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

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterPagePreviewUriGeneratedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterPagePreviewUriGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/AfterPagePreviewUriGeneratedEvent.rst.txt
