..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapFunctionsExecutedEvent
..  _BeforeStdWrapFunctionsExecutedEvent:

===================================
BeforeStdWrapFunctionsExecutedEvent
===================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\BeforeStdWrapFunctionsExecutedEvent`
is called directly after the recursive :ref:`stdWrap <t3tsref:stdwrap>` function
call, but still before the content gets modified.

Calling order of similar events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent`
*   :ref:`AfterStdWrapFunctionsInitializedEvent`
*   BeforeStdWrapFunctionsExecutedEvent
*   :ref:`AfterStdWrapFunctionsExecutedEvent`

..  seealso::
    :ref:`EnhanceStdWrapEvent`


Example
=======

Have a look into the
:ref:`example of EnhanceStdWrapEvent <EnhanceStdWrapEvent-example>`.


API
===

..  include:: /CodeSnippets/Events/Frontend/BeforeStdWrapFunctionsExecutedEvent.rst.txt
