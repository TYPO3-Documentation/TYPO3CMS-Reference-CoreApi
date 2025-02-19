..  include:: /Includes.rst.txt
..  index:: Events; ModifyFileReferenceEnabledControlsEvent
..  _ModifyFileReferenceEnabledControlsEvent:

=======================================
ModifyFileReferenceEnabledControlsEvent
=======================================

Listeners to the PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyFileReferenceEnabledControlsEvent`
are able to modify the state (enabled or disabled) for the controls of a single
file reference of a TCA type :ref:`file <t3tca:columns-file>` field. This
event is similar to the :ref:`ModifyInlineElementEnabledControlsEvent`, which
is only available for TCA type :ref:`inline <t3tca:columns-inline>`.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyFileReferenceEnabledControlsEvent.rst.txt
