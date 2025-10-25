..  include:: /Includes.rst.txt
..  index:: Events; ModifyEditFileFormDataEvent
..  _ModifyEditFileFormDataEvent:

===========================
ModifyEditFileFormDataEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Filelist\Event\ModifyEditFileFormDataEvent`
allows to modify the form data, used to render the file edit form in the
:guilabel:`Media > Filelist` module using
:ref:`FormEngine data compiling <FormEngine-DataCompiling>`.


Example
=======

..  literalinclude:: _ModifyEditFileFormDataEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/FileList/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Filelist/ModifyEditFileFormDataEvent.rst.txt
