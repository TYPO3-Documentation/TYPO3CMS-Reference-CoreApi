..  include:: /Includes.rst.txt
..  index:: Events; AfterFileAddedToIndexEvent
..  _AfterFileAddedToIndexEvent:

==========================
AfterFileAddedToIndexEvent
==========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileAddedToIndexEvent`
is fired once an index was just added to the database (= indexed).

*Example:* Using listeners for this event allows to additionally populate custom
fields of the :sql:`sys_file` / :sql:`sys_file_metadata` database records.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileAddedToIndexEvent.rst.txt
