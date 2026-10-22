..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapFunctionsExecutedEvent
..  _BeforeStdWrapFunctionsExecutedEvent:

=====================================
`BeforeStdWrapFunctionsExecutedEvent`
=====================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapFunctionsExecutedEvent`
is called directly after the recursive :ref:`stdWrap <t3tsref:stdwrap>` function
call, but still before the content gets modified.

Calling order of similar events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent <BeforeStdWrapFunctionsInitializedEvent>`
*   :ref:`AfterStdWrapFunctionsInitializedEvent <AfterStdWrapFunctionsInitializedEvent>`
*   BeforeStdWrapFunctionsExecutedEvent
*   :ref:`AfterStdWrapFunctionsExecutedEvent <AfterStdWrapFunctionsExecutedEvent>`

..  seealso::
    :ref:`EnhanceStdWrapEvent <EnhanceStdWrapEvent>`


..  _before-std-wrap-functions-executed-event-example:

Example: Listen to one, several, or all stdWrap events
======================================================

Have a look into the
:ref:`example of EnhanceStdWrapEvent <EnhanceStdWrapEvent-example>`.


..  _before-std-wrap-functions-executed-event-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapFunctionsExecutedEvent
