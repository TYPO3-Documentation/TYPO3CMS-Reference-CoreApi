..  include:: /Includes.rst.txt
..  index:: Events; BeforeImportEvent
..  _BeforeImportEvent:


=================
BeforeImportEvent
=================

The PSR-14 event :php:`\TYPO3\CMS\Impexp\Event\BeforeImportEvent` is triggered
when an import file is about to be imported.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  versionadded:: 12.4.10
    The method :php:`getFile()` has been added.

..  include:: /CodeSnippets/Events/Impexp/BeforeImportEvent.rst.txt
