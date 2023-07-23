..  include:: /Includes.rst.txt
..  index:: Events; AfterFileMetaDataDeletedEvent
..  _AfterFileMetaDataDeletedEvent:

=============================
AfterFileMetaDataDeletedEvent
=============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileMetaDataDeletedEvent`
is fired once all metadata of a file was removed, in order to manage custom
metadata that was added previously.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileMetaDataDeletedEvent.rst.txt
