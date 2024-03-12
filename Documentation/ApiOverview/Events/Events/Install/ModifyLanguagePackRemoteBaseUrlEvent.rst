.. include:: /Includes.rst.txt
.. index:: Events; ModifyLanguagePackRemoteBaseUrlEvent
.. _ModifyLanguagePackRemoteBaseUrlEvent:


====================================
ModifyLanguagePackRemoteBaseUrlEvent
====================================

The PSR-14 event
:php:`\TYPO3\CMS\Install\Service\Event\ModifyLanguagePackRemoteBaseUrlEvent`
allows to modify the main URL of a language pack.

..  seealso::
    :ref:`custom-translation-server`

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyLanguagePackRemoteBaseUrlEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <configure-dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _ModifyLanguagePackRemoteBaseUrlEvent/_CustomMirror.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/CustomMirror.php

API
---

.. include:: /CodeSnippets/Events/Install/ModifyLanguagePackRemoteBaseUrlEvent.rst.txt
