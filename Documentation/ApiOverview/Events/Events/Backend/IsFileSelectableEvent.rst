..  include:: /Includes.rst.txt
..  index:: Events; IsFileSelectableEvent
..  _IsFileSelectableEvent:

=====================
IsFileSelectableEvent
=====================

The PSR-14 event :php:`\TYPO3\CMS\Backend\ElementBrowser\Event\IsFileSelectableEvent`
allows to decide whether a file can be selected in the file browser.

To get the image dimensions (width and height) of a file, you can retrieve the
file and use the :php:`getProperty()` method.

Example
=======

..  literalinclude:: _IsFileSelectableEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Backend/IsFileSelectableEvent.rst.txt
