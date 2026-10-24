..  include:: /Includes.rst.txt
..  index:: Events; BeforeMessengerDoctrineCloseEvent
..  _BeforeMessengerDoctrineCloseEvent:

===================================
`BeforeMessengerDoctrineCloseEvent`
===================================

..  versionadded:: 15.0
    :changelog: feature-110227-1784474977

The PSR-14 event
:php:`\TYPO3\CMS\Core\Messenger\Event\BeforeMessengerDoctrineCloseEvent`
is dispatched for each open database connection before a Messenger worker
closes it after a message. Call :php:`skip()` to keep the connection open
across messages. See
`Database connections of a worker <https://docs.typo3.org/permalink/t3coreapi:message-bus-consume-command-database>`_.

..  _BeforeMessengerDoctrineCloseEvent-example:

Example: Keep the reporting connection open
===========================================

The listener keeps the database connection `Reporting` open across messages:

..  literalinclude:: _BeforeMessengerDoctrineCloseEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Messenger/EventListener/KeepReportingConnectionOpen.php

..  _BeforeMessengerDoctrineCloseEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Messenger\Event\BeforeMessengerDoctrineCloseEvent
