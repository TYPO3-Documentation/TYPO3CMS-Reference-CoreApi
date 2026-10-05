..  include:: /Includes.rst.txt
..  index:: Events; AfterRecordListRowPreparedEvent
..  _AfterRecordListRowPreparedEvent:

=================================
`AfterRecordListRowPreparedEvent`
=================================

..  versionadded:: 14.2
    :changelog: feature-107003-1751223220

The PSR-14 event
:php:`\TYPO3\CMS\Backend\RecordList\Event\AfterRecordListRowPreparedEvent` is
fired by :php:`\TYPO3\CMS\Backend\RecordList\DatabaseRecordList` once a row of
the record list is prepared, just before it is rendered. A listener reads the
rendered cells of the row and the HTML attributes of its :html:`<tr>` element,
and can replace either.

:php:`getData()` returns the cells by column name. Writing a key that the
list does not render has no effect, so these are the ones worth changing:

`_SELECTOR_`
    The checkbox of the row.

`icon`
    The record icon.

`__label`
    The title of the record, including its link. `header` holds the same
    value and is used only while `__label` is unset, so write `__label`.

`_CONTROL_`
    The buttons at the end of the row.

`_LOCALIZATION_`, `_LOCALIZATION_b`
    The language of the record and the language it is translated from.

`rowDescription`
    The description of the row.

`uid`
    The uid of the record. TYPO3 ignores a change to it.

:php:`getTagAttributes()` returns `class`, `data-table` and `title` for the
row element. TYPO3 has already filled them, so add to a value instead of
replacing it, or the state the list shows gets lost.

The event also carries the table name, the record, its title, and its lock
information. :php:`getRecordList()` returns the
:php-short:`\TYPO3\CMS\Backend\RecordList\DatabaseRecordList` itself. TYPO3
Core passes this parent object on purpose, because the class still exposes
state that a listener needs. Use as little of it as you can. TYPO3 Core plans
to split the class up, and the method goes with it.

For the :guilabel:`File > Media` module the counterpart is
`AfterFileListRowPreparedEvent
<https://docs.typo3.org/permalink/t3coreapi:AfterFileListRowPreparedEvent>`_.

..  _AfterRecordListRowPreparedEvent-example:

Example: mark a row that somebody else is editing
=================================================

The following listener marks every record that somebody else is editing. It
adds a class to the row and puts the lock message into the `title` attribute.
It also appends a marker to the record title:

..  literalinclude:: _AfterRecordListRowPreparedEvent/_MarkLockedRecordListRowListener.php
    :caption: EXT:my_extension/Classes/EventListener/MarkLockedRecordListRowListener.php

..  _AfterRecordListRowPreparedEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/AfterRecordListRowPreparedEvent.rst.txt
