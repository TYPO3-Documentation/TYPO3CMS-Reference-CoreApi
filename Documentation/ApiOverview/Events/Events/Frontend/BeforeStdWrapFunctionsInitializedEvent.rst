..  include:: /Includes.rst.txt
..  index:: Events; BeforeStdWrapFunctionsInitializedEvent
..  _BeforeStdWrapFunctionsInitializedEvent:

======================================
BeforeStdWrapFunctionsInitializedEvent
======================================

..  versionadded:: 13.0
    This event is one of the more powerful replacements for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']`.

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
