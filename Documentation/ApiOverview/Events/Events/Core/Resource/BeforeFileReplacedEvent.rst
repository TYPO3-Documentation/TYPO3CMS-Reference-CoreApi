..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileReplacedEvent
..  _BeforeFileReplacedEvent:

=======================
BeforeFileReplacedEvent
=======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileReplacedEvent`
is fired before a file is about to be replaced. Custom listeners can check for
file integrity or analyze the content of the file before it gets added.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileReplacedEvent.rst.txt
