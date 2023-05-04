..  include:: /Includes.rst.txt
..  index:: Events; BeforePagePreviewUriGeneratedEvent
..  _BeforePagePreviewUriGeneratedEvent:


==================================
BeforePagePreviewUriGeneratedEvent
==================================

..  versionadded:: 12.0
    This PSR-14 event replaces the
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['viewOnClickClass']`
    preProcess hook.

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

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _BeforePagePreviewUriGeneratedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _BeforePagePreviewUriGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/BeforePagePreviewUriGeneratedEvent.rst.txt
