..  include:: /Includes.rst.txt
..  index:: Events; BeforeTransformTextForRichTextEditorEvent
..  _BeforeTransformTextForRichTextEditorEvent:

=========================================
BeforeTransformTextForRichTextEditorEvent
=========================================

Modify data when retrieving content from the database and pass to the
rich-text-editor (RTE). As opposed to :ref:`AfterTransformTextForRichTextEditorEvent`
this event is executed **before** TYPO3 applied any kind of internal
transformations like for links.

For a detailed description on how to use this event, see
the corresponding **after** event: :ref:`AfterTransformTextForRichTextEditorEvent`.

For an example see :ref:`AfterTransformTextForPersistenceEvent-example`.

..  _BeforeTransformTextForRichTextEditorEvent-api:

API of BeforeTransformTextForRichTextEditorEvent
================================================

..  include:: /CodeSnippets/Events/Core/Html/BeforeTransformTextForRichTextEditorEvent.rst.txt
