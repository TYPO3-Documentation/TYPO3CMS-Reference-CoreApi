..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileRenamedEvent
..  _BeforeFileRenamedEvent:

======================
BeforeFileRenamedEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileRenamedEvent`
is fired before a file is about to be renamed. Custom listeners can further
rename the file according to specific guidelines based on the project.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileRenamedEvent.rst.txt
