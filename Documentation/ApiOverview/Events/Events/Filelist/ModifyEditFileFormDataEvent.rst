..  include:: /Includes.rst.txt
..  index:: Events; ModifyEditFileFormDataEvent
..  _ModifyEditFileFormDataEvent:

===========================
ModifyEditFileFormDataEvent
===========================

..  versionadded:: 12.1
    This event can be used as an improved alternative for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/file_edit.php']['preOutputProcessingHook']`
    hook.

The PSR-14 event :php:`\TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent`
allows to modify the form data, used to render the file edit form in the
:guilabel:`File > Filelist` module using
:ref:`FormEngine data compiling <FormEngine-DataCompiling>`.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _Snippets/_ModifyEditFileFormDataEvent.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _Snippets/_ModifyEditFileFormDataEventListener.php
    :caption: EXT:my_extension/Classes/FileList/ModifyEditFileFormDataEventListener.php

API
===

..  include:: /CodeSnippets/Events/Filelist/ModifyEditFileFormDataEvent.rst.txt
