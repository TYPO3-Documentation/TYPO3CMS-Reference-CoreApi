..  include:: /Includes.rst.txt
..  index:: Events; AfterFileContentsSetEvent
..  _AfterFileContentsSetEvent:

=========================
AfterFileContentsSetEvent
=========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterFileContentsSetEvent`
is fired after the contents of a file got set / replaced.

*Example:* Listeners can analyze content for :abbr:`AI (Artificial Intelligence)`
purposes within extensions.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterFileContentsSetEvent.rst.txt
