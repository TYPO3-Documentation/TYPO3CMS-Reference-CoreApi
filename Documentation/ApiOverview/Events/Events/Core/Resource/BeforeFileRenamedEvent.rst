..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileRenamedEvent
..  _BeforeFileRenamedEvent:

========================
`BeforeFileRenamedEvent`
========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileRenamedEvent`
is fired before a file is about to be renamed. Custom listeners can further
rename the file according to specific guidelines based on the project.

..  _before-file-renamed-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _before-file-renamed-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileRenamedEvent.rst.txt
