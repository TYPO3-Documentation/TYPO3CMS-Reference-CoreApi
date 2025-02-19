..  include:: /Includes.rst.txt
..  index:: Events; ModifyAutoCreateRedirectRecordBeforePersistingEvent
..  _ModifyAutoCreateRedirectRecordBeforePersistingEvent:


===================================================
ModifyAutoCreateRedirectRecordBeforePersistingEvent
===================================================

The PSR-14 event
:php:`\TYPO3\CMS\Redirects\Event\ModifyAutoCreateRedirectRecordBeforePersistingEvent`
allows extensions to modify the redirect record before it is persisted to
the database. This can be used to change values according to circumstances, such
as different sub-tree settings that are not covered by the Core
site configuration. Another use case could be to write data to additional
:sql:`sys_redirect` columns added by a custom extension for later use.

..  note::
    To handle updates or react on manual created redirects in the backend
    module, available hooks of :php:`\TYPO3\CMS\Core\DataHandling\DataHandler`
    can be used.


Example
=======

..  literalinclude:: _ModifyAutoCreateRedirectRecordBeforePersistingEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Redirects/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

.. include:: /CodeSnippets/Events/Redirects/ModifyAutoCreateRedirectRecordBeforePersistingEvent.rst.txt
