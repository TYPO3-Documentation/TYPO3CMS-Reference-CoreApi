..  include:: /Includes.rst.txt
..  index:: Events; BeforePageIsRetrievedEvent
..  _BeforePageIsRetrievedEvent:

==========================
BeforePageIsRetrievedEvent
==========================

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

API
===

..  include:: /CodeSnippets/Events/Core/BeforePageIsRetrievedEvent.rst.txt
