..  include:: /Includes.rst.txt
..  index::
    Events; ProvideStaticVariablesToComponentEvent
..  _ProvideStaticVariablesToComponentEvent:

======================================
ProvideStaticVariablesToComponentEvent
======================================

..  versionadded:: 14.1

The :php-short:`\TYPO3\CMS\Fluid\Event\ProvideStaticVariablesToComponentEvent` can
be used to inject additional static variables into component templates
(see `Fluid components <https://docs.typo3.org/permalink/t3coreapi:using-fluid-components>`_).
As with the :ref:`ModifyComponentDefinitionEvent <ModifyComponentDefinitionEvent>`
(:php-short:`\TYPO3\CMS\Fluid\Event\ModifyComponentDefinitionEvent`), these variables
must not have any dependencies on runtime information, as they might be used for
static analysis or IDE auto-completion. The :ref:`RenderComponentEvent <RenderComponentEvent>`
(:php-short:`\TYPO3\CMS\Fluid\Event\RenderComponentEvent`) can be used to add variables
with runtime dependencies.

Valid use cases for this event might be:

*   providing **static** design tokens (colors, icons, ...) to all components in a collection
*   generating prefix strings based on the component's name

Example
=======

..  literalinclude:: _ProvideStaticVariablesToComponentEvent/_ProvideStaticVariablesToComponentListener.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/ProvideStaticVariablesToComponentListener.php

API
===

..  include:: /CodeSnippets/Events/Fluid/ProvideStaticVariablesToComponentEvent.rst.txt
