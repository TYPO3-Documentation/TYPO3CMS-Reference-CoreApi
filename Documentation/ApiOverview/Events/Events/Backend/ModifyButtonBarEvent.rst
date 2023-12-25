..  include:: /Includes.rst.txt
..  index:: Events; ModifyButtonBarEvent
..  _ModifyButtonBarEvent:

====================
ModifyButtonBarEvent
====================

..  versionadded:: 12.0
    This event serves as a direct replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend\Template\Components\ButtonBar']['getButtonsHook']`.

The PSR-14 event :php:`\TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent`
can be used to modify the button bar in the TYPO3 backend module
:ref:`docheader <backend-modules-template-without-extbase-docheader>`.

..  seealso::
    *   :ref:`button-components`

Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyButtonBarEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _ModifyButtonBarEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Backend/ModifyButtonBarEvent.rst.txt
