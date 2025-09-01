..  include:: /Includes.rst.txt
..  index:: Events; BeforeEmailFinisherInitializedEvent
..  _BeforeEmailFinisherInitializedEvent:

===================================
BeforeEmailFinisherInitializedEvent
===================================

..  versionadded:: 14.0

    The PSR-14 event :php:`BeforeEmailFinisherInitializedEvent` has
    been introduced to provide developers with control over email
    configuration without needing to extend or override the :php:`EmailFinisher`
    class.

A PSR-14 event :php:`\TYPO3\CMS\Form\Event\BeforeEmailFinisherInitializedEvent`
is dispatched before the :php:`\TYPO3\CMS\Form\Domain\Finishers\EmailFinisher` is
initialized and allows listeners to modify the finisher options.

This enables developers to customize email behavior programmatically, such as:

*   Setting alternative recipients based on frontend user permissions
*   Modifying the email subject or content dynamically
*   Replacing recipients with developer email addresses in test environments
*   Adding or removing CC/BCC recipients conditionally
*   Customizing reply-to addresses

..  _BeforeEmailFinisherInitializedEvent-example:

Example
=======

The corresponding event listener class:

..  literalinclude:: _BeforeEmailFinisherInitializedEvent/_MyEventListener.php
    :caption: EXT:my_package/Classes/Form/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/BeforeEmailFinisherInitializedEvent.rst.txt
