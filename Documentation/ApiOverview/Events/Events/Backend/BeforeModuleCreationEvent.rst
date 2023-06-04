..  include:: /Includes.rst.txt
..  index:: Events; BeforeModuleCreationEvent
..  _BeforeModuleCreationEvent:

=========================
BeforeModuleCreationEvent
=========================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent`
allows extension authors to manipulate the :ref:`module configuration
<backend-modules-configuration>`, before it is used to create and register the
module.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _BeforeModuleCreationEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _BeforeModuleCreationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeModuleCreationEvent.rst.txt
