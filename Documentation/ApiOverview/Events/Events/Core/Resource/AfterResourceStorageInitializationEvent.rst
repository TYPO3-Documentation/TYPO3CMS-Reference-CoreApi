..  include:: /Includes.rst.txt
..  index:: Events; AfterResourceStorageInitializationEvent
..  _AfterResourceStorageInitializationEvent:

=======================================
AfterResourceStorageInitializationEvent
=======================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterResourceStorageInitializationEvent`
is fired after a resource object was built/created. Custom handlers can be
initialized at this moment for any kind of resource as well.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterResourceStorageInitializationEvent.rst.txt
