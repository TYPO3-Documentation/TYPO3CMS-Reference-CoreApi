..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLinkConfigurationEvent
..  _ModifyPageLinkConfigurationEvent:

================================
ModifyPageLinkConfigurationEvent
================================

..  versionadded:: 12.0
    This event has been introduced to serve as a more powerful and flexible
    alternative for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typolinkProcessing']['typolinkModifyParameterForPageLinks']`.

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent`
is called after a page has been resolved, and includes arguments such as the
generated fragment and the to-be-used query parameters.

The page to be linked to can also be modified to link to a different page.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyPageLinkConfigurationEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyPageLinkConfigurationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyPageLinkConfigurationEvent.rst.txt
