..  include:: /Includes.rst.txt
..  index:: Events; ModifyPageLayoutContentEvent
..  _ModifyPageLayoutContentEvent:

============================
ModifyPageLayoutContentEvent
============================

..  versionadded:: 12.0
    This event serves as a replacement for the removed hooks:

    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook']`
    *   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawFooterHook']`

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent`
allows to modify page module content.

It is possible to add additional content, overwrite existing
content or reorder the content.

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyPageLayoutContentEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _ModifyPageLayoutContentEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyPageLayoutContentEvent.rst.txt
