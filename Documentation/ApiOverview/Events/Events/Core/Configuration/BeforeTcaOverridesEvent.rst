..  include:: /Includes.rst.txt
..  index:: Events; BeforeTcaOverridesEvent
..  _BeforeTcaOverridesEvent:

=======================
BeforeTcaOverridesEvent
=======================

..  versionadded:: 13.0

A PSR-14 event :php:`\TYPO3\CMS\Core\Configuration\Event\BeforeTcaOverridesEvent`
enables developers to listen to the state between loaded base TCA and merging of
TCA overrides.

It can be used to dynamically generate TCA and add it as additional
base TCA. This is especially useful for "TCA generator" extensions, which add
TCA based on another resource, while still enabling users to override TCA via
the known TCA overrides API.

..  note::
    :php:`$GLOBALS['TCA']` is not set at this point. Event listeners can only
    work on the :ref:`TCA <t3tca:start>` coming from :php:`$event->getTca()` and
    must not access :php:`$GLOBALS['TCA']`.

    TCA is always "runtime-cached". This means that dynamic
    additions must never depend on runtime state, for example, the current
    :ref:`PSR-7 request <typo3-request>` or similar, because such information
    might not even exist when the first call is done, for example, from
    :ref:`CLI <symfony-console-commands>`.

Example
=======

..  literalinclude:: _BeforeTcaOverridesEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Configuration/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt


API
===

..  include:: /CodeSnippets/Events/Core/BeforeTcaOverridesEvent.rst.txt
