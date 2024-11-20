..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordDownloadPresetsAreDisplayedEvent
..  _BeforeRecordDownloadPresetsAreDisplayedEvent:

============================================
BeforeRecordDownloadPresetsAreDisplayedEvent
============================================

..  versionadded:: 13.2

The event :php:`TYPO3\CMS\Backend\RecordList\Event\BeforeRecordDownloadPresetsAreDisplayedEvent`
can be used to manipulate the list of available download presets in
the :guilabel:`Web > List` module.

See :confval:`mod.web_list.downloadPresets <t3tsref:mod-web-list-downloadpresets>`
on how to configure download presets.

Note that the event is dispatched for one specific database table name. If
an event listener is created to attach presets to different tables, the
listener method must check for the table name, as shown in the example below.

If no download presets exist for a given table, the PSR-14 event can still
be used to modify and add presets to it via the :php:`setPresets()` method.

The array passed from :php:`getPresets()` to :php:`setPresets()` can contain
an array collection of :ref:`TYPO3\CMS\Backend\RecordList\DownloadPreset <DownloadPreset-api>`
objects with the array key using the preset label.

The event listener can also remove array indexes, or also columns of existing
array entries by passing a newly constructed :php:`DownloadPreset` object with the
changed `label` and `columns` constructor properties.

..  contents:: Table of contents

..  _BeforeRecordDownloadPresetsAreDisplayedEvent-example:

Example: Manipulate download presets
====================================

..  literalinclude:: _BeforeRecordDownloadPresetsAreDisplayedEvent/_PresetListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/DataListener.php

..  _BeforeRecordDownloadPresetsAreDisplayedEvent-api:

API of BeforeRecordDownloadPresetsAreDisplayedEvent
===================================================

..  include:: /CodeSnippets/Events/Backend/BeforeRecordDownloadPresetsAreDisplayedEvent.rst.txt

..  _DownloadPreset-api:

API of DownloadPreset
=====================

..  include:: /CodeSnippets/Events/Backend/DownloadPreset.rst.txt
