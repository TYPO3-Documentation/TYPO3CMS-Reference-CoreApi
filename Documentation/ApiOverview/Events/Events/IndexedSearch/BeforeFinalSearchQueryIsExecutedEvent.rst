..  include:: /Includes.rst.txt
..  index:: Events; BeforeFinalSearchQueryIsExecutedEvent
..  _BeforeFinalSearchQueryIsExecutedEvent:

=====================================
BeforeFinalSearchQueryIsExecutedEvent
=====================================

..  versionadded:: 13.4.2 / 14.0
    This event was added as a replacement for the removed hook
    `$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['indexed_search']['pi1_hooks']`.

The PSR-14 :php:`\TYPO3\CMS\IndexedSearch\Event\BeforeFinalSearchQueryIsExecutedEvent`
has been introduced which allows developers to manipulate the (internal)
:php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder`
instance, just before the query gets executed.

..  important::

    The provided query (the :php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder`
    instance) is controlled by the
    TYPO3 Core and is not considered public API. Therefore, developers using this
    event need to keep track of underlying changes by TYPO3. Such changes might
    be further performance improvements to the query or changes to the
    database schema in general.

..  _BeforeFinalSearchQueryIsExecutedEvent-example:

Example
=======

Changing the host of the current request and setting it as canonical:

..  literalinclude:: _BeforeFinalSearchQueryIsExecutedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/IndexedSearch/EventListener/MyEventListener.php

..  _BeforeFinalSearchQueryIsExecutedEvent-api:

API
===

..  include:: /CodeSnippets/Events/IndexedSearch/BeforeFinalSearchQueryIsExecutedEvent.rst.txt
