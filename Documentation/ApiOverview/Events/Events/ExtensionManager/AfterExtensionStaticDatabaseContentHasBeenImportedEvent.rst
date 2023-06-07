..  include:: /Includes.rst.txt
..  index:: Events; AfterExtensionStaticDatabaseContentHasBeenImportedEvent
..  _AfterExtensionStaticDatabaseContentHasBeenImportedEvent:


=======================================================
AfterExtensionStaticDatabaseContentHasBeenImportedEvent
=======================================================

..  versionadded:: 10.3
    The event was introduced to replace the Signal/Slot
    `\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::afterExtensionStaticSqlImport`.

The PSR-14 event
:php:`\TYPO3\CMS\Extensionmanager\Event\AfterExtensionStaticDatabaseContentHasBeenImportedEvent`
is triggered after a package has imported the database file shipped within
:file:`ext_tables_static+adt.sql`.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

.. include:: /CodeSnippets/Events/ExtensionManager/AfterExtensionStaticDatabaseContentHasBeenImportedEvent.rst.txt
