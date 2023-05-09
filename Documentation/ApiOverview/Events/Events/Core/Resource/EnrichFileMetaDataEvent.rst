..  include:: /Includes.rst.txt
..  index:: Events; EnrichFileMetaDataEvent
..  _EnrichFileMetaDataEvent:

=======================
EnrichFileMetaDataEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\EnrichFileMetaDataEvent`
is called after a record has been loaded from database. It allows other places
to perform the extension of metadata at runtime or, for example, translation
and workspace overlay.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/EnrichFileMetaDataEvent.rst.txt
