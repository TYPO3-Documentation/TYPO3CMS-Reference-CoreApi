..  include:: /Includes.rst.txt
..  index:: Events; ModifyComponentDefinitionEvent
..  _ModifyComponentDefinitionEvent:

==============================
ModifyComponentDefinitionEvent
==============================

As the name says, the :php-short:`\TYPO3\CMS\Fluid\Event\ModifyComponentDefinitionEvent`
can be used to modify the definition of a Fluid component before it is written to the cache. 

..  _ModifyComponentDefinitionEvent-example:

Example
=======

..  literalinclude:: _ModifyComponentDefinitionEvent/_ModifyComponentDefinitionEvent.php
    :language: php
    :caption: EXT:my_extension/Classes/Fluid/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

..  _ModifyComponentDefinitionEvent-api:

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyComponentDefinitionEvent.rst.txt
