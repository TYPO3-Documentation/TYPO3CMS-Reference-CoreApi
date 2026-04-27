..  include:: /Includes.rst.txt
..  index:: Events; AfterSectionMarkupGeneratedEvent
..  _AfterSectionMarkupGeneratedEvent:

================================
AfterSectionMarkupGeneratedEvent
================================

..  deprecated:: 14.3
    The event :php-short:`\TYPO3\CMS\Backend\View\Event\AfterSectionMarkupGeneratedEvent`
    is deprecated and will be removed in TYPO3 v15. Existing listeners will keep
    working in v14. There is no direct replacement so listeners that decorated
    backend layout columns with this event should be removed.


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

API
===

..  include:: /CodeSnippets/Events/Backend/AfterSectionMarkupGeneratedEvent.rst.txt
