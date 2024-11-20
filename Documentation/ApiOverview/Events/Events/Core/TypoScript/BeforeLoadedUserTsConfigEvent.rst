..  include:: /Includes.rst.txt
..  index:: Events; BeforeLoadedUserTsConfigEvent
..  _BeforeLoadedUserTsConfigEvent:

=============================
BeforeLoadedUserTsConfigEvent
=============================

..  versionadded:: 13.0

The PSR-14 event
:php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedUserTsConfigEvent`
can be used to add global static :ref:`user TSconfig <t3tsref:usertsconfig>`
before anything else is loaded. This is especially useful, if user TSconfig is
generated automatically as a string from a PHP function.

It is important to understand that this configuration is considered static and
thus should not depend on runtime / request.

Example
=======

..  literalinclude:: _BeforeLoadedUserTsConfigEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/TypoScript/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/BeforeLoadedUserTsConfigEvent.rst.txt
