..  include:: /Includes.rst.txt
..  index:: Events; PackageInitializationEvent
..  _PackageInitializationEvent:

==========================
PackageInitializationEvent
==========================

..  versionadded:: 13.0

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\PackageInitializationEvent`
allows listeners to execute custom functionality after an extension has been
activated.

The event is being dispatched at several places, where extensions get activated.
Those are, for example:

*   on extension installation by the extension manager
*   on calling the :bash:`typo3 extension:setup` command.

The main component dispatching the event is the
:php:`\TYPO3\CMS\Core\Package\PackageActivationService`.

Developers are able to listen to the new event before or after the TYPO3 Core
listeners have been executed, using :php:`before` and :php:`after` in the
listener registration. All listeners are able to store arbitrary data
in the event using the :php:`addStorageEntry()` method. This is also used
by the Core listeners to store their result.


Example
=======

..  literalinclude:: _PackageInitializationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Package/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt


API
===

..  include:: /CodeSnippets/Events/Core/Package/PackageInitializationEvent.rst.txt
