..  include:: /Includes.rst.txt
..  index:: Events; ProcessFileListActionsEvent
..  _ProcessFileListActionsEvent:

=============================
`ProcessFileListActionsEvent`
=============================

The PSR-14 event :php:`\TYPO3\CMS\Core\Configuration\Event\ProcessFileListActionsEvent`
is fired after generating the actions for the files and folders listing in the
:guilabel:`Media` module.

This event can be used to manipulate the icons/actions, used for the edit control
section in the files and folders listing within the :guilabel:`Media`
module.

..  _process-file-list-actions-event-example:

Example
=======

..  literalinclude:: _ProcessFileListActionsEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/FileList/EventListener/MyEventListener.php

..  _process-file-list-actions-event-api:

API
===

..  include:: /CodeSnippets/Events/Filelist/ProcessFileListActionsEvent.rst.txt
