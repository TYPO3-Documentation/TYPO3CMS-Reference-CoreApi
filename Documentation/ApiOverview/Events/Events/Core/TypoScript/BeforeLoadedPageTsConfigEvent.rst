..  include:: /Includes.rst.txt
..  index:: Events; BeforeLoadedPageTsConfigEvent
..  _BeforeLoadedPageTsConfigEvent:

=============================
BeforeLoadedPageTsConfigEvent
=============================

..  versionadded:: 13.0

The PSR-14 event
:php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedPageTsConfigEvent`
can be used to add global static :ref:`page TSconfig <t3tsref:pagetsconfig>`
before anything else is loaded. This is especially useful, if page TSconfig is
generated automatically as a string from a PHP function.

It is important to understand that this configuration is considered static and
thus should not depend on runtime / request.

Example
=======

..  literalinclude:: _BeforeLoadedPageTsConfigEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/TypoScript/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforeLoadedPageTsConfigEvent.rst.txt
