..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordIsRenderedEvent
..  _AfterRecordIsRenderedEvent:

============================
`AfterRecordIsRenderedEvent`
============================

..  versionadded:: 15.0
    :changelog: feature-110815-1790590629

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterRecordIsRenderedEvent` is
fired by the :typoscript:`CONTENT` and :typoscript:`RECORDS` content objects
after each single record is rendered. A listener reads the HTML with
:php:`getRenderedRecord()` and replaces it with
:php:`setRenderedRecord()`, for example to wrap the record in markup of its
own. Whatever a listener writes goes into the page as it is, so escape the
parts that come from the record.

This event covers the records that TypoScript renders, for example through
`styles.content.get`. For the records that Fluid renders, use
`ModifyRenderedRecordEvent
<https://docs.typo3.org/permalink/t3coreapi:ModifyRenderedRecordEvent>`_,
which this event is the counterpart of.

:php:`getRecord()` usually returns a resolved record. Where TYPO3 cannot
resolve the row, it returns a
:php-short:`\TYPO3\CMS\Core\Domain\RawRecord` with the unprocessed row
instead. A custom :typoscript:`select.selectFields` that leaves out a system
field, such as the language or the workspace field, has that effect.

TYPO3 skips the event entirely for a table without TCA, and for a row whose
type field a custom :typoscript:`select.selectFields` left out. No record
object can be built in those cases, and the rendered record stays as it is.

..  _after-record-is-rendered-event-example:

Example
=======

The following listener wraps every content element in an element that names
its uid, and leaves the records of other tables alone:

..  literalinclude:: _AfterRecordIsRenderedEvent/_WrapRenderedRecordListener.php
    :caption: EXT:my_extension/Classes/EventListener/WrapRenderedRecordListener.php

..  _after-record-is-rendered-event-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/AfterRecordIsRenderedEvent.rst.txt
