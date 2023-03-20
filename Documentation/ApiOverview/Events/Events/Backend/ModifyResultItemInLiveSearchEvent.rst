..  include:: /Includes.rst.txt
..  index:: Events; ModifyResultItemInLiveSearchEvent
..  _ModifyResultItemInLiveSearchEvent:

=================================
ModifyResultItemInLiveSearchEvent
=================================

..  versionadded:: 12.2

The PSR-14 event :php:`\TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent`
is available to allow extension developers to take control over search result
items rendered in the backend search.

Example
=======

..  warning::
    Some code in this example is experimental API and may change until TYPO3
    v12 LTS.

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyResultItemInLiveSearchEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyResultItemInLiveSearchEvent.rst.txt
