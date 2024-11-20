..  include:: /Includes.rst.txt
..  index:: Events; ModifyRedirectManagementControllerViewDataEvent
..  _ModifyRedirectManagementControllerViewDataEvent:


===============================================
ModifyRedirectManagementControllerViewDataEvent
===============================================

..  versionadded:: 12.3

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\ModifyRedirectManagementControllerViewDataEvent`
allows extensions to modify or enrich view data for
:t3src:`redirects/Classes/Controller/ManagementController.php`. This makes it
possible to display more or other information along the way.

For example, this event can be used to add additional information to current
page records.

Therefore, it can be used to generate custom data, directly assigning to the
view. With :ref:`overriding the backend view template <t3tsref:pagetemplates>`
via :ref:`page TSconfig <t3tsref:pagetsconfig>` this custom data can be
displayed where it is needed and rendered the way it is wanted.

..  versionadded:: 13.0
    The methods :php:`getIntegrityStatusCodes()` and
    :php:`setIntegrityStatusCodes()` have been added to the event class.

Example
=======

..  literalinclude:: _ModifyRedirectManagementControllerViewDataEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Redirects/ModifyRedirectManagementControllerViewDataEvent.rst.txt
