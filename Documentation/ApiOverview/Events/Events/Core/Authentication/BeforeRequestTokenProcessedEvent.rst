..  include:: /Includes.rst.txt
..  index:: Events; BeforeRequestTokenProcessedEvent
..  _BeforeRequestTokenProcessedEvent:

================================
BeforeRequestTokenProcessedEvent
================================

..  versionadded::  12.1

The event :php:`\TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent`
allows to intercept or adjust a :ref:`request token <authentication-request-token>`
during active user authentication process.

Example
=======

The event can be used to generate the request token individually. This can be
the case when you are not using a login callback and have not the possibility
to submit a request token:

..  literalinclude:: _BeforeRequestTokenProcessedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Authentication/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforeRequestTokenProcessedEvent.rst.txt
