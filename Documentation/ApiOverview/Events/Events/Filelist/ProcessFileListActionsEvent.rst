..  include:: /Includes.rst.txt
..  index:: Events; ProcessFileListActionsEvent
..  _ProcessFileListActionsEvent:

===========================
ProcessFileListActionsEvent
===========================

..  versionadded:: 11.4

The PSR-14 event :php:`\TYPO3\CMS\Core\Configuration\Event\ProcessFileListActionsEvent`
is fired after generating the actions for the files and folders listing in the
:guilabel:`File > Filelist` module.

This event can be used to manipulate the icons/actions, used for the edit control
section in the files and folders listing within the :guilabel:`File > Filelist`
module.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _Snippets/_ProcessFileListActionsEvent.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _Snippets/_ProcessFileListActionsEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/FileList/ProcessFileListActionsEventListener.php

API
===

.. include:: /CodeSnippets/Events/Filelist/ProcessFileListActionsEvent.rst.txt
