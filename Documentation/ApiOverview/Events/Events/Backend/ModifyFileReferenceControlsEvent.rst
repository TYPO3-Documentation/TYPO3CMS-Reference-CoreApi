..  include:: /Includes.rst.txt
..  index:: Events; ModifyFileReferenceControlsEvent
..  _ModifyFileReferenceControlsEvent:

================================
ModifyFileReferenceControlsEvent
================================

..  versionadded:: 12.0

Listeners to the PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyFileReferenceControlsEvent`
are able to modify the controls of a single file reference of a TCA type
:ref:`file <columns-file>` field. This event is similar to the
:ref:`ModifyInlineElementControlsEvent`, which is only available for TCA
type :ref:`inline <columns-inline>`.

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyFileReferenceControlsEvent.rst.txt
