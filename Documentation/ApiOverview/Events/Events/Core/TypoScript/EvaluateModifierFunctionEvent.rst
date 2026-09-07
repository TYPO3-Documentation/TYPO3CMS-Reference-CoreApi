..  include:: /Includes.rst.txt
..  index:: Events; EvaluateModifierFunctionEvent
..  _EvaluateModifierFunctionEvent:

===============================
`EvaluateModifierFunctionEvent`
===============================

The PSR-14 event
:php:`\TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent`
allows custom TypoScript functions using the :typoscript:`:=` operator.


..  _evaluate-modifier-function-event-example:

Example
=======

A simple TypoScript example looks like this:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    someIdentifier = originalValue
    someIdentifier := myModifierFunction(myFunctionArgument)

The corresponding event listener class could look like this:

..  literalinclude:: _EvaluateModifierFunctionEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/TypoScript/EventListener/MyEventListener.php

..  _evaluate-modifier-function-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/EvaluateModifierFunctionEvent.rst.txt
