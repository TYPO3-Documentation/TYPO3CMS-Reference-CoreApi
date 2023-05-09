..  include:: /Includes.rst.txt
..  index:: Events; SanitizeFileNameEvent
..  _SanitizeFileNameEvent:

=====================
SanitizeFileNameEvent
=====================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\SanitizeFileNameEvent` is
fired once an index was just added to the database (= indexed), so it is possible
to modify the file name, and name the files according to naming conventions of a
specific project.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/SanitizeFileNameEvent.rst.txt
