..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapFunctionsExecutedEvent
..  _BeforeStdWrapFunctionsExecutedEvent:

===================================
BeforeStdWrapFunctionsExecutedEvent
===================================

..  versionadded:: 13.0
    This event is one of the more powerful replacements for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']`.

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
