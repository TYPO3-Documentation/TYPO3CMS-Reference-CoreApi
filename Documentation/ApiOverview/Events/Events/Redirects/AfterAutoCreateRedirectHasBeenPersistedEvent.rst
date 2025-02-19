..  include:: /Includes.rst.txt
..  index:: Events; AfterAutoCreateRedirectHasBeenPersistedEvent
..  _AfterAutoCreateRedirectHasBeenPersistedEvent:


============================================
AfterAutoCreateRedirectHasBeenPersistedEvent
============================================

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\AfterAutoCreateRedirectHasBeenPersistedEvent`
allows extensions to react on persisted auto-created redirects. This event
can be used to call external APIs or perform other tasks based on the real
persisted redirects.

..  note::
    To handle later updates or react on manually created redirects in the backend
    module, available hooks of :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
    can be used.


Example
=======

..  literalinclude:: _AfterAutoCreateRedirectHasBeenPersistedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Redirects/AfterAutoCreateRedirectHasBeenPersistedEvent.rst.txt
