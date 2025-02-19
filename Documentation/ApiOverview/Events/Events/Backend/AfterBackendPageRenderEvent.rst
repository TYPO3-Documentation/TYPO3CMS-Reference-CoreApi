..  include:: /Includes.rst.txt
..  index:: Events; AfterBackendPageRenderEvent
..  _AfterBackendPageRenderEvent:

===========================
AfterBackendPageRenderEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\AfterBackendPageRenderEvent`
gets triggered after the page in the backend is rendered and includes the
rendered page body. Listeners may overwrite the page string if desired.

Example
=======

..  literalinclude:: _AfterBackendPageRenderEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/AfterBackendPageRenderEvent.rst.txt
