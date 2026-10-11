..  include:: /Includes.rst.txt
..  index:: Events; AfterFormDefinitionValidationConfigurationIsBuiltEvent

..  _AfterFormDefinitionValidationConfigurationIsBuiltEvent:

========================================================
`AfterFormDefinitionValidationConfigurationIsBuiltEvent`
========================================================

..  versionadded:: 15.0
    :changelog: feature-109849-1716115200

    The event replaces the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['buildFormDefinitionValidationConfiguration']`.

The event
:php:`\TYPO3\CMS\Form\Event\AfterFormDefinitionValidationConfigurationIsBuiltEvent`
is dispatched after the validation configuration of the form editor has
been built for a prototype. The form editor only saves the properties that
this configuration allows. A listener can add property paths for a custom
inspector editor that does not declare its paths in the YAML configuration,
for example with `propertyPath`.

..  _AfterFormDefinitionValidationConfigurationIsBuiltEvent-example:

Example: Allow the form editor to save a custom property
========================================================

The following listener allows the form editor to save the property
`properties.my.custom.property` of the custom form element
`MyCustomElement`. A custom inspector editor sets this property without a
`propertyPath` in the YAML configuration:

..  literalinclude:: _AfterFormDefinitionValidationConfigurationIsBuiltEvent/_CustomPropertyPathListener.php
    :caption: EXT:my_extension/Classes/EventListener/CustomPropertyPathListener.php

..  _AfterFormDefinitionValidationConfigurationIsBuiltEvent-api:

API
===

..  include:: /CodeSnippets/Events/Form/AfterFormDefinitionValidationConfigurationIsBuiltEvent.rst.txt
