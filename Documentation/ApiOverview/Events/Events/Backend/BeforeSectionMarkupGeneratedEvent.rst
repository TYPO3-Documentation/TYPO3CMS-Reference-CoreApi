..  include:: /Includes.rst.txt
..  index:: Events; BeforeSectionMarkupGeneratedEvent
..  _BeforeSectionMarkupGeneratedEvent:

=================================
BeforeSectionMarkupGeneratedEvent
=================================

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

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeSectionMarkupGeneratedEvent.rst.txt
