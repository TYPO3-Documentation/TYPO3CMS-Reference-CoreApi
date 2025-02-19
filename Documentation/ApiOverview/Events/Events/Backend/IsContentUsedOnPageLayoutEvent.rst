..  include:: /Includes.rst.txt
..  index:: Events; IsContentUsedOnPageLayoutEvent
..  _IsContentUsedOnPageLayoutEvent:

==============================
IsContentUsedOnPageLayoutEvent
==============================

Use the PSR-14 event :php:`\TYPO3\CMS\Backend\View\Event\IsContentUsedOnPageLayoutEvent`
to identify if content has been used in a column that is not in a backend layout.

Setting :php:`$event->setUsed(true)` prevent the following message for the affected content element,
setting it to false displays it:

..  warning::
    **Unused elements detected on this page**
    These elements don't belong to any of the available columns of this page. You should either delete
    them or move them to existing columns. We highlighted the problematic records for you.

..  _IsContentUsedOnPageLayoutEvent-example:

Example: Display "Unused elements detected on this page" for elements with missing parent
=========================================================================================

..  literalinclude:: _IsContentUsedOnPageLayoutEvent/_ContentUsedOnPage.php
    :language: php
    :caption: EXT:my_extension/Classes/Listener/ContentUsedOnPage.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _IsContentUsedOnPageLayoutEvent-api:

API of IsContentUsedOnPageLayoutEvent
=====================================

..  include:: /CodeSnippets/Events/Backend/IsContentUsedOnPageLayoutEvent.rst.txt
