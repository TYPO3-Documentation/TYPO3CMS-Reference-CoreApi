..  include:: /Includes.rst.txt
..  index:: Events; AfterFileProcessingEvent
..  _AfterFileProcessingEvent:

==========================
`AfterFileProcessingEvent`
==========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileProcessingEvent`
is fired after a file object has been processed.
This allows to further customize a file object's processed file.

..  versionchanged:: 15.0
    :changelog: breaking-110702-1789915156

    The event is also dispatched for system resources from `EXT:` and `PKG:`.
    For them, :php:`getFile()` returns a
    :php-short:`\TYPO3\CMS\Core\SystemResource\Type\SystemResourceInterface`
    and :php:`getDriver()` returns `null`. Check both before you use methods
    that only a FAL file or a driver has.

..  _after-file-processing-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-file-processing-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileProcessingEvent.rst.txt
