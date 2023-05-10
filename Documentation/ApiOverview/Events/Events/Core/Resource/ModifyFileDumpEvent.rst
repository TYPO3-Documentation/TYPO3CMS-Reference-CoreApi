..  include:: /Includes.rst.txt
..  index:: Events; ModifyFileDumpEvent
..  _ModifyFileDumpEvent:

===================
ModifyFileDumpEvent
===================

..  versionadded:: 11.4

The PSR-14 event :php:`\TYPO3\CMS\Core\Resource\Event\ModifyFileDumpEvent` is
fired in the :php:`\TYPO3\CMS\Core\Controller\FileDumpController` and allows
extensions to perform additional access / security checks before dumping a file.
The event does not only contain the file to dump but also the PSR-7 Request.

In case the file dump should be rejected, the event has to set a PSR-7
response, usually with a `403` status code. This will then immediately
stop the propagation.

With the event, it is not only possible to reject the file dump request,
but also to replace the file, which should be dumped.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _AfterFileCommandProcessedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _AfterFileCommandProcessedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Core/Resource/ModifyFileDumpEvent.rst.txt
