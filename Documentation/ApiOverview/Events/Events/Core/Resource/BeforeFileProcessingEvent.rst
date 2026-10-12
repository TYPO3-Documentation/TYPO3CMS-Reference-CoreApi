..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileProcessingEvent
..  _BeforeFileProcessingEvent:

===========================
`BeforeFileProcessingEvent`
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileProcessingEvent`
is fired before a file object is processed. This allows to add further
information or enrich the file before the processing is kicking in.

..  versionchanged:: 15.0
    :changelog: breaking-110702-1789915156

    The event is also dispatched for system resources from `EXT:` and `PKG:`.
    For them, :php:`getFile()` returns a
    :php-short:`\TYPO3\CMS\Core\SystemResource\Type\SystemResourceInterface`
    and :php:`getDriver()` returns `null`. Check both before you use methods
    that only a FAL file or a driver has.

..  _before-file-processing-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-file-processing-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileProcessingEvent.rst.txt
