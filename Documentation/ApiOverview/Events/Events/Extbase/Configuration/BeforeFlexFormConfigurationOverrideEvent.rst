..  include:: /Includes.rst.txt
..  index:: Events; BeforeFlexFormConfigurationOverrideEvent
..  _BeforeFlexFormConfigurationOverrideEvent:


========================================
BeforeFlexFormConfigurationOverrideEvent
========================================

..  versionadded:: 12.3

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Configuration\BeforeFlexFormConfigurationOverrideEvent`
can be used to implement a custom :ref:`FlexForm <flexforms>` override process
based on the original FlexForm configuration and the framework configuration.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _BeforeFlexFormConfigurationOverrideEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _BeforeFlexFormConfigurationOverrideEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Extbase/EventListener/MyEventListener.php

API
===

.. include:: /CodeSnippets/Events/Extbase/BeforeFlexFormConfigurationOverrideEvent.rst.txt
