..  include:: /Includes.rst.txt
..  index:: Events; ModifyEditFormUserAccessEvent
..  _ModifyEditFormUserAccessEvent:

=============================
ModifyEditFormUserAccessEvent
=============================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyEditFormUserAccessEvent\ModifyEditFormUserAccessEvent`
provides the full database row of the record in question next to the
exception, which might have been set by the Core. Additionally, the event allows
to modify the user access decision in an object-oriented way, using
convenience methods.

In case any listener to the new event denies user access, while it was initially
allowed by Core, the :php:`\TYPO3\CMS\Backend\Form\Exception\AccessDeniedListenerException`
will be thrown.

Example
=======

..  literalinclude:: _ModifyEditFormUserAccessEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Backend/ModifyEditFormUserAccessEvent.rst.txt
