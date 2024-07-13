..  include:: /Includes.rst.txt
..  index:: Events; BeforeTransformTextForPersistenceEvent
..  _BeforeTransformTextForPersistenceEvent:

======================================
BeforeTransformTextForPersistenceEvent
======================================

..  versionadded:: 13.3
    The events :ref:`BeforeTransformTextForPersistenceEvent`,
    :ref:`AfterTransformTextForPersistenceEvent`,
    :ref:`BeforeTransformTextForRichTextEditorEvent`
    :ref:`AfterTransformTextForRichTextEditorEvent` were introduced as
    replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS'] ['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']`.

Modify data when saving rich-text-editor (RTE) content to the database
(persistence). As opposed to :ref:`AfterTransformTextForPersistenceEvent`
this event is executed **before** TYPO3 applied any kind of internal
transformations like for links.

For a detailed description on how to use this event, see
the corresponding **after** event: :ref:`AfterTransformTextForPersistenceEvent`.

For an example see :ref:`AfterTransformTextForPersistenceEvent-example`.

..  _BeforeTransformTextForPersistenceEvent-api:

API of BeforeTransformTextForPersistenceEvent
=============================================

..  include:: /CodeSnippets/Events/Core/Html/BeforeTransformTextForPersistenceEvent.rst.txt
