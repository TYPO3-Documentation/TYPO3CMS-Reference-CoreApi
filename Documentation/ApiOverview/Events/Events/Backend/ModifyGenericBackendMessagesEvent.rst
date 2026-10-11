..  include:: /Includes.rst.txt
..  index:: Events; ModifyGenericBackendMessagesEvent
..  _ModifyGenericBackendMessagesEvent:

===================================
`ModifyGenericBackendMessagesEvent`
===================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent`
allows to add or alter messages that are displayed in the :guilabel:`About`
module (default start module of the TYPO3 backend).

..  versionchanged:: 14.3
    :changelog: important-109493-1788970444

    Before, the module rendered every message as an error infobox. A message
    created without a severity now renders as a green "OK" infobox.

The module renders each message with the severity of its
:php:`\TYPO3\CMS\Core\Messaging\FlashMessage`. The severity defaults to
:php:`\TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::OK`, so state the
severity of the message explicitly.

Extensions such as the :doc:`EXT:reports <ext_reports:Index>` system extension
use this event to display custom messages based on the system status:

..  figure:: /Images/ManualScreenshots/Backend/GenericBackendMessage.png
    :zoom: lightbox

    A generic backend message in the about module

..  _modify-generic-backend-messages-event-example:

Example
=======

..  literalinclude:: _ModifyGenericBackendMessagesEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-generic-backend-messages-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyGenericBackendMessagesEvent.rst.txt
