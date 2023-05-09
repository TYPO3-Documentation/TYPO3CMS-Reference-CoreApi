..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileCreatedEvent
..  _BeforeFileCreatedEvent:

======================
BeforeFileCreatedEvent
======================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileCreatedEvent`
is fired before a file is about to be created within a resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
The folder represents the "target folder".

This allows to further analyze or modify the file or filename before it is
written by the driver.

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileCreatedEvent.rst.txt
