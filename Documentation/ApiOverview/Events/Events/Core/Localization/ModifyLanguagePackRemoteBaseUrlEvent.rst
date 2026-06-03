..  include:: /Includes.rst.txt
..  index:: Events; ModifyLanguagePackRemoteBaseUrlEvent
..  _ModifyLanguagePackRemoteBaseUrlEvent:

====================================
ModifyLanguagePackRemoteBaseUrlEvent
====================================

..  deprecated:: 14.2
    The event :php:`ModifyLanguagePackRemoteBaseUrlEvent`
    have been moved to :composer:`typo3/cms-core`. Therefore the namespace
    changed from `\TYPO3\CMS\Install\Service\Event\ModifyLanguagePackRemoteBaseUrlEvent`
    to :php:`\TYPO3\CMS\Core\Localization\Event\ModifyLanguagePackRemoteBaseUrlEvent`.

    There is a class alias that will be removed with TYPO3 v15.0.

    See `Deprecation: #109027 - Move language:update command and events to EXT:core <https://docs.typo3.org/permalink/changelog:deprecation-109027-1771514240>`_.


The PSR-14 event
:php:`\TYPO3\CMS\Core\Localization\Event\ModifyLanguagePackRemoteBaseUrlEvent`
allows to modify the main URL of a language pack.

..  seealso::
    :ref:`custom-translation-server`

..  _ModifyLanguagePackRemoteBaseUrlEvent-example:

Example
=======

..  literalinclude:: _ModifyLanguagePackRemoteBaseUrlEvent/_CustomMirror.php
    :caption: EXT:my_extension/Classes/EventListener/CustomMirror.php

..  _ModifyLanguagePackRemoteBaseUrlEvent-api:

API
===

..  include:: /CodeSnippets/Events/Core/ModifyLanguagePackRemoteBaseUrlEvent.rst.txt
