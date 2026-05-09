..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapFunctionsInitializedEvent
..  _BeforeStdWrapFunctionsInitializedEvent:

======================================
BeforeStdWrapFunctionsInitializedEvent
======================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapFunctionsInitializedEvent`
is dispatched before any :ref:`stdWrap <t3tsref:stdwrap>` function is initialized/called.

Calling order of similar events:

*   BeforeStdWrapFunctionsInitializedEvent
*   :ref:`AfterStdWrapFunctionsInitializedEvent`
*   :ref:`BeforeStdWrapFunctionsExecutedEvent`
*   :ref:`AfterStdWrapFunctionsExecutedEvent`

..  seealso::
    :ref:`EnhanceStdWrapEvent`


Example
=======

Have a look into the
:ref:`example of EnhanceStdWrapEvent <EnhanceStdWrapEvent-example>`.


API
===

..  include:: /CodeSnippets/Events/Frontend/BeforeStdWrapFunctionsInitializedEvent.rst.txt
