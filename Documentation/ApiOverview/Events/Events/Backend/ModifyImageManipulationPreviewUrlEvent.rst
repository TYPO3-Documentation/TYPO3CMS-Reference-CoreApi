..  include:: /Includes.rst.txt
..  index::
    Events; ModifyImageManipulationPreviewUrlEvent
..  _ModifyImageManipulationPreviewUrlEvent:

======================================
ModifyImageManipulationPreviewUrlEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent`
can be used to modify the preview URL within the
:ref:`image manipulation <t3tca:columns-imageManipulation>` element, used
for example for the :php:`crop` field of the :sql:`sys_file_reference` table.

As soon as a preview URL is set, the image manipulation element will display
a corresponding button in the footer of the modal window, next to the
:guilabel:`Cancel` and :guilabel:`Accept` buttons. On click, the preview
URL will be opened in a new window.

..  note::
    The element's crop variants will always be appended to the preview URL
    as JSON-encoded string, using the `cropVariants` parameter.

Example
=======

..  literalinclude:: _ModifyImageManipulationPreviewUrlEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyImageManipulationPreviewUrlEvent.rst.txt
