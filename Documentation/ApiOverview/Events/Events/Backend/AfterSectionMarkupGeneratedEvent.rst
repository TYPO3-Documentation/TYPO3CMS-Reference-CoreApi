..  include:: /Includes.rst.txt
..  index:: Events; AfterSectionMarkupGeneratedEvent
..  _AfterSectionMarkupGeneratedEvent:

================================
AfterSectionMarkupGeneratedEvent
================================

The PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\AfterSectionMarkupGeneratedEvent`
allows extension authors to display content in any colPos after the last
content element.

..  seealso::
    * :ref:`BeforeSectionMarkupGeneratedEvent`

Example
=======

..  literalinclude:: _AfterSectionMarkupGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/AfterSectionMarkupGeneratedEvent.rst.txt
