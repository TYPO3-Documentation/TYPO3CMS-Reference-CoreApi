..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordLanguageOverlayEvent
..  _AfterRecordLanguageOverlayEvent:

===============================
AfterRecordLanguageOverlayEvent
===============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\AfterRecordLanguageOverlayEvent`
can be used to modify the actual translated record (if found) to add additional
information or perform custom processing of the record.

..  seealso::
    *   :ref:`BeforeRecordLanguageOverlayEvent`

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/AfterRecordLanguageOverlayEvent.rst.txt
