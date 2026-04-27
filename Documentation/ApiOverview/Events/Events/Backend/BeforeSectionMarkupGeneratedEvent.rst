..  include:: /Includes.rst.txt
..  index:: Events; BeforeSectionMarkupGeneratedEvent
..  _BeforeSectionMarkupGeneratedEvent:

=================================
BeforeSectionMarkupGeneratedEvent
=================================

..  deprecated:: 14.3
    The event :php-short:`\TYPO3\CMS\Backend\View\Event\BeforeSectionMarkupGeneratedEvent`
    is deprecated and will be removed in TYPO3 v15. Existing listeners will keep
    working in v14.

The PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\BeforeSectionMarkupGeneratedEvent`
allows extension authors to display content in any colPos before the first
content element.

..  seealso::
    * :ref:`AfterSectionMarkupGeneratedEvent`

Example
=======

..  literalinclude:: _BeforeSectionMarkupGeneratedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeSectionMarkupGeneratedEvent.rst.txt
