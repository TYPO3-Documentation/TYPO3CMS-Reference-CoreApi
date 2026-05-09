..  include:: /Includes.rst.txt
..  index::
    Events; ModifyComponentDefinitionEvent
..  _ModifyComponentDefinitionEvent:

==============================
ModifyComponentDefinitionEvent
==============================

..  versionadded:: 14.1

The :php-short:`\TYPO3\CMS\Fluid\Event\ModifyComponentDefinitionEvent` can be
used to modify the definition of a `Fluid component <https://docs.typo3.org/permalink/t3coreapi:using-fluid-components>`_
before it's written to the cache.
Component definitions must not have any dependencies on runtime information, as
they might be used for static analysis or IDE auto-completion. Due
to the component definitions cache, this is already enforced, as the registered
events are only executed once and not on every request.

Example
=======

..  literalinclude:: _ModifyComponentDefinitionEvent/_ModifyComponentDefinitionListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/ModifyComponentDefinitionListener.php

API
===

..  include:: /CodeSnippets/Events/Fluid/ModifyComponentDefinitionEvent.rst.txt
