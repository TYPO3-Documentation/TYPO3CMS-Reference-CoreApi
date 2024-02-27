..  include:: /Includes.rst.txt
..  index:: Events; ModifyLanguagePackRemoteBaseUrlEvent
..  _ModifyLanguagePackRemoteBaseUrlEvent:


====================================
ModifyLanguagePackRemoteBaseUrlEvent
====================================

The PSR-14 event
:php:`\TYPO3\CMS\Install\Service\Event\ModifyLanguagePackRemoteBaseUrlEvent`
allows to modify the main URL of a language pack.

..  seealso::
    :ref:`custom-translation-server`

Example
=======

..  literalinclude:: _ModifyLanguagePackRemoteBaseUrlEvent/_CustomMirror.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/CustomMirror.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Install/ModifyLanguagePackRemoteBaseUrlEvent.rst.txt
