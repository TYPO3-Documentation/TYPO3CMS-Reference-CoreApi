..  include:: /Includes.rst.txt
..  index:: Events; BeforeEmailFinisherInitializedEvent
..  _BeforeEmailFinisherInitializedEvent:

===================================
BeforeEmailFinisherInitializedEvent
===================================

A new PSR-14 event :php:`\TYPO3\CMS\Form\Event\BeforeEmailFinisherInitializedEvent`
has been introduced. This event is dispatched before the :php:`EmailFinisher` is
initialized and allows listeners to modify the finisher options.

This enables developers to customize email behavior programmatically, such as:

*   Setting alternative recipients based on frontend user permissions
*   Modifying the email subject or content dynamically
*   Replacing recipients with developer email addresses in test environments
*   Adding or removing CC/BCC recipients conditionally
*   Customizing reply-to addresses

..  hint::
    This event provides developers with comprehensive control over email
    configuration without needing to extend or override the :php:`EmailFinisher`
    class.

..  _BeforeEmailFinisherInitializedEvent-example:

Example
=======

The corresponding event listener class:

..  literalinclude:: _BeforeEmailFinisherInitializedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php



API
===

..  include:: /CodeSnippets/Events/Core/BeforeEmailFinisherInitializedEvent.rst.txt
