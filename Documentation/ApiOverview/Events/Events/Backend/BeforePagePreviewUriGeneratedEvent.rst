..  include:: /Includes.rst.txt
..  index:: Events; BeforePagePreviewUriGeneratedEvent
..  _BeforePagePreviewUriGeneratedEvent:


==================================
BeforePagePreviewUriGeneratedEvent
==================================

The :php:`\TYPO3\CMS\Backend\Routing\Event\BeforePagePreviewUriGeneratedEvent`
is executed in :php:`\TYPO3\CMS\Backend\Routing->buildUri()`, before the preview
URI is actually built. It allows to either adjust the parameters, such as the
page id or the language id, or to set a custom preview URI, which will then stop
the event propagation and also prevents
:php:`\TYPO3\CMS\Backend\Routing\PreviewUriBuilder` from building the URI based
on the parameters.

..  note::
    The overwritten parameters are used for building the URI and are also passed
    to the :ref:`AfterPagePreviewUriGeneratedEvent`. They however do not
    overwrite the related class properties in :php:`PreviewUriBuilder`.

Example
=======

..  literalinclude:: _BeforePagePreviewUriGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/BeforePagePreviewUriGeneratedEvent.rst.txt
