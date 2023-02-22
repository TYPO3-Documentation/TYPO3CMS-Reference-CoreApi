..  include:: /Includes.rst.txt
..  index:: Events; IsFileSelectableEvent
..  _IsFileSelectableEvent:

=====================
IsFileSelectableEvent
=====================

..  versionadded:: 12.1

The PSR-14 event :php:`\TYPO3\CMS\Backend\ElementBrowser\Event\IsFileSelectableEvent`
allows to decide whether a file can be selected in the file browser.

To get the image dimensions (width and height) of a file, you can retrieve the
file and use the :php:`getProperty()` method.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  literalinclude:: _IsFileSelectableEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _IsFileSelectableEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Backend/IsFileSelectableEvent.rst.txt
