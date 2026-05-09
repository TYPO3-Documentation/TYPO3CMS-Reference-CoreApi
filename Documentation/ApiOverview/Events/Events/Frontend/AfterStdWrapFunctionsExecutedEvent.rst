..  include:: /Includes.rst.txt
..  index:: Events; AfterStdWrapFunctionsExecutedEvent
..  _AfterStdWrapFunctionsExecutedEvent:

==================================
AfterStdWrapFunctionsExecutedEvent
==================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsExecutedEvent`
is called after the content has been modified by the rest of the
:ref:`stdWrap <t3tsref:stdwrap>` functions.

Calling order of similar events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent`
*   :ref:`AfterStdWrapFunctionsInitializedEvent`
*   :ref:`BeforeStdWrapFunctionsExecutedEvent`
*   AfterStdWrapFunctionsExecutedEvent

..  seealso::
    :ref:`EnhanceStdWrapEvent`


Example
=======

Have a look into the
:ref:`example of EnhanceStdWrapEvent <EnhanceStdWrapEvent-example>`.


API
===

..  include:: /CodeSnippets/Events/Frontend/AfterStdWrapFunctionsExecutedEvent.rst.txt
