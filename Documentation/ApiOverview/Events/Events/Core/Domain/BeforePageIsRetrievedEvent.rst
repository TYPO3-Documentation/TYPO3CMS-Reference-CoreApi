..  include:: /Includes.rst.txt
..  index:: Events; BeforePageIsRetrievedEvent
..  _BeforePageIsRetrievedEvent:

==========================
BeforePageIsRetrievedEvent
==========================

..  versionadded:: 13.0
    This event serves as a more powerful replacement for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage']`
    hook.

The PSR-14 event :php:`\TYPO3\CMS\Core\Domain\Event\BeforePageIsRetrievedEvent`
allows to modify the resolving of page records within
:php:`\TYPO3\CMS\Core\Domain\PageRepository->getPage()`.

It can be used to alter the incoming page ID or to even fetch a fully-loaded
page object before the default TYPO3 behaviour is executed, effectively
bypassing the default page resolving.

Example
=======

..  literalinclude:: _BeforePageIsRetrievedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Access/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforePageIsRetrievedEvent.rst.txt
