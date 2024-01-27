..  include:: /Includes.rst.txt
..  index:: Events; ModifyUrlForCanonicalTagEvent
..  _ModifyUrlForCanonicalTagEvent:


=============================
ModifyUrlForCanonicalTagEvent
=============================

With the PSR-14 event `\TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent`
the URL for the :html:`href` attribute of the canonical tag can be altered or
emptied.

..  versionadded:: 12.4.9
    The methods :php:`getRequest()` and :php:`getPage()` have been added.

..  versionchanged:: 13.0
    The event is being dispatched after the standard functionality has been
    executed, such as fetching the URL from the page properties. Effectively,
    this also means that :php:`getUrl()` might already return a non-empty
    string.

..  note::
    ..  versionchanged:: 13.0
    The event is even dispatched in case the canonical tag generation is
    disabled via TypoScript
    (:ref:`disableCanonical <t3tsref:setup-config-disableCanonical>`) or via
    the page property :sql:`no_index`. If disabled, the
    :php:`\TYPO3\CMS\Seo\Exception\CanonicalGenerationDisabledException` is
    thrown. The exception is caught and transferred to the event, allowing
    listeners to determine whether the generation is disabled, using the
    :php:`getCanonicalGenerationDisabledException()` method, which either
    returns the exception with the corresponding reason or :php:`null`.

Example
=======

Changing the host of the current request and setting it as canonical:

..  literalinclude:: _ModifyUrlForCanonicalTagEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Seo/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


API
===

..  include:: /CodeSnippets/Events/Seo/ModifyUrlForCanonicalTagEvent.rst.txt
