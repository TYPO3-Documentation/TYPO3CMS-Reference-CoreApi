..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordSummaryForLocalizationEvent
..  _AfterRecordSummaryForLocalizationEvent:

======================================
AfterRecordSummaryForLocalizationEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\AfterRecordSummaryForLocalizationEvent`
is fired in the
:php:`\TYPO3\CMS\Backend\Controller\Page\RecordSummaryForLocalization` class
and allows extensions to modify the payload of the :php:`JsonResponse`.


Example
=======

..  literalinclude:: _AfterRecordSummaryForLocalizationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/AfterRecordSummaryForLocalizationEvent.rst.txt
