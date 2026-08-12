..  include:: /Includes.rst.txt
..  index:: Events; AfterFileReplacedEvent
..  _AfterFileReplacedEvent:

========================
`AfterFileReplacedEvent`
========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\AfterFileReplacedEvent`
is fired after a file was replaced.

*Example*: Further process a file or create variants, or index the
contents of a file for :abbr:`AI (Artificial Intelligence)` analysis etc.

..  _after-file-replaced-event-example:

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

..  _after-file-replaced-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileReplacedEvent.rst.txt
