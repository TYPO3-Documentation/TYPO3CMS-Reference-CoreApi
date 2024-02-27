..  include:: /Includes.rst.txt
..  index:: Events; ModifyRecordsAfterFetchingContentEvent
..  _ModifyRecordsAfterFetchingContentEvent:

======================================
ModifyRecordsAfterFetchingContentEvent
======================================

..  versionadded:: 13.0
    This event serves as a more powerful replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content_content.php']['modifyDBRow']`
    hook.

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\ModifyRecordsAfterFetchingContentEvent`
allows to modify the fetched records next to the possibility to manipulate most
of the options, such as `slide`. Listeners are also able to set the final
content and change the whole TypoScript configuration, used for further
processing.

Example
=======

..  literalinclude:: _ModifyRecordsAfterFetchingContentEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyRecordsAfterFetchingContentEvent.rst.txt
