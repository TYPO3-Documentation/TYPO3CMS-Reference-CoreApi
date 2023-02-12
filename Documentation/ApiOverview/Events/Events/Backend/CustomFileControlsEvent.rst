..  include:: /Includes.rst.txt
..  index:: Events; CustomFileControlsEvent
..  _CustomFileControlsEvent:

=======================
CustomFileControlsEvent
=======================

..  versionadded:: 12.0
    This event replaces the :php:`customControls`
    hook option, which is only available for TCA type
    :ref:`inline <t3tca:columns-inline>`.

Listeners to the PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\CustomFileControlsEvent`
are able to add custom controls to a TCA type
:php:`file` field in :ref:`form engine <FormEngine>`.

Custom controls are always displayed below the file references. In contrast
to the selectors, e.g. :guilabel:`Select & upload files` are custom controls
independent of the :php:`readonly` and :php:`showFileSelectors` options.
This means, you have full control in which scenario your custom controls
are being displayed.

API
===

..  include:: /CodeSnippets/Events/Backend/CustomFileControlsEvent.rst.txt
