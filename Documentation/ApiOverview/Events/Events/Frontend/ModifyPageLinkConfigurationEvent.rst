..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLinkConfigurationEvent
..  _ModifyPageLinkConfigurationEvent:

================================
ModifyPageLinkConfigurationEvent
================================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent`
is called after a page has been resolved, and includes arguments such as the
generated fragment and the to-be-used query parameters.

The page to be linked to can also be modified to link to a different page.


Example
=======

..  literalinclude:: _ModifyPageLinkConfigurationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyPageLinkConfigurationEvent.rst.txt
