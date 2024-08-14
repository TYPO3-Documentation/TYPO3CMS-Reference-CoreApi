..  include:: /Includes.rst.txt
..  index:: Events; AfterTransformTextForRichTextEditorEvent
..  _AfterTransformTextForRichTextEditorEvent:

========================================
AfterTransformTextForRichTextEditorEvent
========================================

..  versionadded:: 13.3
    The events :ref:`BeforeTransformTextForPersistenceEvent`,
    :ref:`AfterTransformTextForPersistenceEvent`,
    :ref:`BeforeTransformTextForRichTextEditorEvent`
    :ref:`AfterTransformTextForRichTextEditorEvent` were introduced as
    replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']`.

Modify data when retrieving content from the database and pass to the
rich-text-editor (RTE). As opposed to :ref:`BeforeTransformTextForRichTextEditorEvent`
this event is executed **after** TYPO3 applied any kind of internal
transformations like for links.

When using a RTE HTML content element, two transformations
take place within the TYPO3 backend:

*   **From database: Fetching the current content from the database (`persistence`) and
    preparing it to be displayed inside the RTE HTML component.**
*   To database: Retrieving the data returned by the RTE and preparing it to
    be persisted into the database.

This event can modify the first part. This allows developers to apply
more customized transformations, apart from the internal and API ones.

Event listeners can use :php:`$value = $event->getHtmlContent()` to get the
current contents, apply changes to :php:`$value` and then store the
manipulated data via :php:`$event->setHtmlContent($value)`,
see example: :ref:`AfterTransformTextForPersistenceEvent-example`.

..  _AfterTransformTextForRichTextEditorEvent-api:

API of AfterTransformTextForRichTextEditorEvent
===============================================

..  include:: /CodeSnippets/Events/Core/Html/AfterTransformTextForRichTextEditorEvent.rst.txt
