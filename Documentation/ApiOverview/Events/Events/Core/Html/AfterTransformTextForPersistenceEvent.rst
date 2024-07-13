..  include:: /Includes.rst.txt
..  index:: Events; AfterTransformTextForPersistenceEvent
..  _AfterTransformTextForPersistenceEvent:

=====================================
AfterTransformTextForPersistenceEvent
=====================================

..  versionadded:: 13.3
    The events :ref:`BeforeTransformTextForPersistenceEvent`,
    :ref:`AfterTransformTextForPersistenceEvent`,
    :ref:`BeforeTransformTextForRichTextEditorEvent`
    :ref:`AfterTransformTextForRichTextEditorEvent` were introduced as
    replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS'] ['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']`.

Modify data when saving rich-text-editor (RTE) content to the database
(persistence). As opposed to :ref:`BeforeTransformTextForPersistenceEvent`
this event is executed **after** TYPO3 applied any kind of internal
transformations like for links.

When using a RTE HTML content element, two transformations
take place within the TYPO3 backend:

*  From database: Fetching the current content from the database (`persistence`) and
   preparing it to be displayed inside the RTE HTML component.
*  **To database: Retrieving the data returned by the RTE and preparing it to
   be persisted into the database.**

This event can modify the later part. This allows developers to apply
more customized transformations, apart from the internal and API ones.

Event listeners can use :php:`$value = $event->getHtmlContent()` to get the
current contents, apply changes to :php:`$value` and then store the
manipulated data via :php:`$event->setHtmlContent($value)`,
see example:

..  _AfterTransformTextForPersistenceEvent-example:

Example: Transform a text before saving to database
===================================================

An event listener class is constructed which will take an RTE input *TYPO3* and internally
store it in the database as *[tag:typo3]*. This could allow a content element data processor
in the frontend to handle this part of the content with for example internal glossary operations.

The workflow would be:

*   Editor enters "TYPO3" in the RTE instance.
*   **When saving, this gets stored as "[tag:typo3]".**
*   When the editor sees the RTE instance again, "[tag:typo3]" gets replaced to "TYPO3" again.
*   So: The editor will always only see "TYPO3" and not know how it is internally handled.
*   The frontend output receives "[tag:typo3]" and could do its own content element magic,
    other services accessing the database could also use the parseable representation.

The corresponding event listener class:

..  literalinclude:: _TransformTextEvents/_TransformListener.php
    :caption: EXT:my_extension/Classes/EventListener/TransformListener.php

..  _AfterTransformTextForPersistenceEvent-api:

API of AfterTransformTextForPersistenceEvent
============================================

..  include:: /CodeSnippets/Events/Core/Html/AfterTransformTextForPersistenceEvent.rst.txt
