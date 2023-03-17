..  include:: /Includes.rst.txt
..  index:: Events; AfterAutoCreateRedirectHasBeenPersistedEvent
..  _AfterAutoCreateRedirectHasBeenPersistedEvent:


============================================
AfterAutoCreateRedirectHasBeenPersistedEvent
============================================

..  versionadded:: 12.3

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\AfterAutoCreateRedirectHasBeenPersistedEvent`
allows extension authors to react on persisted auto-created redirects. This
can be used to call external APIs or perform other tasks based on the real
persisted redirects.

..  note::
    To handle later updates or react on manual created redirects in the backend
    module, available hooks of :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
    can be used.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterAutoCreateRedirectHasBeenPersistedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterAutoCreateRedirectHasBeenPersistedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Redirects/AfterAutoCreateRedirectHasBeenPersistedEvent.rst.txt
