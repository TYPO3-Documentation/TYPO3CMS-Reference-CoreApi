.. include:: /Includes.rst.txt
.. index:: Events; EvaluateModifierFunctionEvent
.. _EvaluateModifierFunctionEvent:


=============================
EvaluateModifierFunctionEvent
=============================

.. versionadded:: 12.0
   This event is a substitution of the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc']`
   hook.

The PSR-14 event :php:`\TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent`
allows custom TypoScript functions using the :typoscript:`:=` operator.


Example
=======

A simple TypoScript example looks like this:

.. code-block:: typoscript
   :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

   someIdentifier = originalValue
   someIdentifier := myModifierFunction(myFunctionArgument)

To implement :typoscript:`myModifierFunction`, an extension needs to register
an event listener in an extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\EventListener\MyTypoScriptModifierFunction:
     tags:
       - name: event.listener
         identifier: 'my-extension/typoscript/evaluate-modifier-function'

The corresponding event listener class could look like this:

.. code-block:: php
   :caption: EXT:my_extension/Classes/EventListener/MyTypoScriptModifierFunction.php

   use TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent;

   final class MyTypoScriptModifierFunction
   {
       public function __invoke(EvaluateModifierFunctionEvent $event): void
       {
           if ($event->getFunctionName() === 'myModifierFunction') {
               $originalValue = $event->getOriginalValue();
               $functionArgument = $event->getFunctionArgument();
               // Manipulate values and set new value
               $event->setValue($originalValue . ' example ' . $functionArgument);
           }
       }
   }


API
===

.. include:: /CodeSnippets/Events/Core/EvaluateModifierFunctionEvent.rst.txt
