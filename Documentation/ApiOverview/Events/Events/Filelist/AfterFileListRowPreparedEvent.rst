..  include:: /Includes.rst.txt
..  index:: Events; AfterFileListRowPreparedEvent
..  _AfterFileListRowPreparedEvent:

===============================
`AfterFileListRowPreparedEvent`
===============================

..  versionadded:: 15.0

    See `Feature: #110259 - New PSR-14 AfterFileListRowPreparedEvent
    <https://docs.typo3.org/permalink/changelog:feature-110259-1784666471>`_.

The PSR-14 event :php:`\TYPO3\CMS\Filelist\Event\AfterFileListRowPreparedEvent`
is fired after a file or folder row has been fully prepared for the
:guilabel:`Media` module, just before it is rendered into the final table
row markup.

Unlike :ref:`ProcessFileListActionsEvent <ProcessFileListActionsEvent>`,
which only allows the action icons in the control column to be modified, this
event provides access to the already-rendered data of every column in the
row (for example `name`, `size` or any additional metadata columns added
via the column selector), as well as the row's HTML tag attributes. This
mirrors the equivalent event that is already available for the classic record
list:
:php-short:`\TYPO3\CMS\Backend\RecordList\Event\AfterRecordListRowPreparedEvent`.

..  _after-file-list-row-prepared-event-example:

Example: decorate a column value in the file list
=================================================

The following listener decorates the already-rendered values of columns
in each row, without having to resort to hooks or class-name-based reflection
workarounds.

..  literalinclude:: _AfterFileListRowPreparedEvent/_DecorateFileListColumnEventListener.php
    :caption: EXT:my_extension/Classes/FileList/EventListener/DecorateFileListColumnEventListener.php

..  _after-file-list-row-prepared-event-api:

API
===

..  include:: /CodeSnippets/Events/Filelist/AfterFileListRowPreparedEvent.rst.txt
