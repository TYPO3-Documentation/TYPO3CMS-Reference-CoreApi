..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileContentsSetEvent
..  _BeforeFileContentsSetEvent:

==========================
BeforeFileContentsSetEvent
==========================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileContentsSetEvent`
is fired before the contents of a file gets set / replaced.
This allows to further analyze or modify the content of a file before it is
written by the :ref:`driver <fal-architecture-components-drivers>`.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileContentsSetEvent.rst.txt
