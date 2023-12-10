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
