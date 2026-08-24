..  include:: /Includes.rst.txt
..  index:: Events; BeforeFlexFormConfigurationOverrideEvent
..  _BeforeFlexFormConfigurationOverrideEvent:


==========================================
`BeforeFlexFormConfigurationOverrideEvent`
==========================================

The PSR-14 event
:php:`\TYPO3\CMS\Extbase\Event\Configuration\BeforeFlexFormConfigurationOverrideEvent`
can be used to implement a custom :ref:`FlexForm <flexforms>` override process
based on the original FlexForm configuration and the framework configuration.


..  _before-flex-form-configuration-override-event-example:

Example
=======

..  literalinclude:: _BeforeFlexFormConfigurationOverrideEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Extbase/EventListener/MyEventListener.php

..  _before-flex-form-configuration-override-event-api:

API
===

..  include:: /CodeSnippets/Events/Extbase/BeforeFlexFormConfigurationOverrideEvent.rst.txt
