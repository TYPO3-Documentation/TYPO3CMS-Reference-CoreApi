..  include:: /Includes.rst.txt
..  index:: Events; ResolveFailureTransportEvent
..  _ResolveFailureTransportEvent:

==============================
`ResolveFailureTransportEvent`
==============================

..  versionadded:: 15.0
    :changelog: feature-110230-1784620000

The PSR-14 event
:php:`\TYPO3\CMS\Core\Messenger\Event\ResolveFailureTransportEvent` is
dispatched when a message failed in a Messenger worker. It holds the name of
the transport that the message failed on, and the
`failure transport <https://docs.typo3.org/permalink/t3coreapi:message-bus-failure-transport>`_
that the configuration names for it. A listener can name another failure
transport, or set :php:`null`, so that the message is not parked.

..  _ResolveFailureTransportEvent-example:

Example: Park the failed messages of a transport separately
===========================================================

..  literalinclude:: _ResolveFailureTransportEvent/_RouteImportFailures.php
    :caption: EXT:my_extension/Classes/EventListener/RouteImportFailures.php

The failure transport `failed_import` has to be registered, see
`Use a failure transport of its own <https://docs.typo3.org/permalink/t3coreapi:message-bus-failure-transport-per-transport>`_.

..  _ResolveFailureTransportEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Core\Messenger\Event\ResolveFailureTransportEvent
