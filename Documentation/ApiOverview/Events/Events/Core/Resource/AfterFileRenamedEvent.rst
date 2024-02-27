..  include:: /Includes.rst.txt
..  index:: Events; AfterFileRenamedEvent
..  _AfterFileRenamedEvent:

=====================
AfterFileRenamedEvent
=====================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileRenamedEvent`
is fired after a file was renamed in order to further process a file or filename
or update custom references to a file.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileRenamedEvent.rst.txt
