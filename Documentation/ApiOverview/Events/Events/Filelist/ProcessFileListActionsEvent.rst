..  include:: /Includes.rst.txt
..  index:: Events; ProcessFileListActionsEvent
..  _ProcessFileListActionsEvent:

=============================
`ProcessFileListActionsEvent`
=============================

The PSR-14 event :php:`\TYPO3\CMS\Filelist\Event\ProcessFileListActionsEvent`
is fired after actions are generated for the
:guilabel:`Media` module files and folders listing.

This event can be used to manipulate icons/actions that are in the edit
control section of the :guilabel:`Media` module files and folders listing.

..  versionchanged:: 14.0
    Actions are button components instead of HTML strings, and
    primary and secondary actions are set by the
    :php-short:`\TYPO3\CMS\Backend\Template\Components\ActionGroup` enum. See
    `Breaking: #107884 - Rework actions to use Buttons API with Components
    <https://docs.typo3.org/permalink/changelog:breaking-107884-1730135000>`_.

..  _process-file-list-actions-event-example:

Example
=======

..  literalinclude:: _ProcessFileListActionsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/FileList/EventListener/MyEventListener.php

..  _process-file-list-actions-event-api:

API
===

..  include:: /CodeSnippets/Events/Filelist/ProcessFileListActionsEvent.rst.txt
