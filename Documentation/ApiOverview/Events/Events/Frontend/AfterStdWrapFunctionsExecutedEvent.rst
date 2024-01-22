..  include:: /Includes.rst.txt
..  index:: Events; AfterStdWrapFunctionsExecutedEvent
..  _AfterStdWrapFunctionsExecutedEvent:

==================================
AfterStdWrapFunctionsExecutedEvent
==================================

..  versionadded:: 13.0
    This event is one of the more powerful replacements for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']`.

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
