..  include:: /Includes.rst.txt
..  index:: Events; BeforeFileAddedEvent
..  _BeforeFileAddedEvent:

====================
BeforeFileAddedEvent
====================

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\BeforeFileAddedEvent`
is fired before a file is about to be added to the resource
:ref:`storage <fal-architecture-components-storage>` /
:ref:`driver <fal-architecture-components-drivers>`.
This allows to perform custom checks to a file or restrict access to a file
before the file is added.

Example
=======

..  literalinclude:: _BeforeFileAddedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/BeforeFileAddedEvent.rst.txt
