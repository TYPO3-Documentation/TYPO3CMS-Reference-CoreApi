..  include:: /Includes.rst.txt
..  index:: Events; ModifyGenericBackendMessagesEvent
..  _ModifyGenericBackendMessagesEvent:

=================================
ModifyGenericBackendMessagesEvent
=================================

..  versionadded:: 12.0
    This event serves as direct replacement for the now removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['displayWarningMessages']`.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent`
allows to add or alter messages that are displayed in the :guilabel:`About`
module (default start module of the TYPO3 backend).

Extensions such as the :doc:`EXT:reports <ext_reports:Index>` system extension
use this event to display custom messages based on the system status:

..  include:: /Images/ManualScreenshots/Backend/GenericBackendMessage.rst.txt

Example
=======

..  literalinclude:: _ModifyGenericBackendMessagesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyGenericBackendMessagesEvent.rst.txt
