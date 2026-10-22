..  include:: /Includes.rst.txt
..  index:: Events; AfterStdWrapFunctionsExecutedEvent
..  _AfterStdWrapFunctionsExecutedEvent:

====================================
`AfterStdWrapFunctionsExecutedEvent`
====================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsExecutedEvent`
is called after the content has been modified by the rest of the
:ref:`stdWrap <t3tsref:stdwrap>` functions.

Calling order of similar events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent <BeforeStdWrapFunctionsInitializedEvent>`
*   :ref:`AfterStdWrapFunctionsInitializedEvent <AfterStdWrapFunctionsInitializedEvent>`
*   :ref:`BeforeStdWrapFunctionsExecutedEvent <BeforeStdWrapFunctionsExecutedEvent>`
*   AfterStdWrapFunctionsExecutedEvent

..  seealso::
    :ref:`EnhanceStdWrapEvent <EnhanceStdWrapEvent>`


..  _after-std-wrap-functions-executed-event-example:

Example: Listen to one, several, or all stdWrap events
======================================================

Have a look into the
:ref:`example of EnhanceStdWrapEvent <EnhanceStdWrapEvent-example>`.


..  _after-std-wrap-functions-executed-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsExecutedEvent
