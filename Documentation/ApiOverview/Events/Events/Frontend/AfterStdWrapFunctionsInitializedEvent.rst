..  include:: /Includes.rst.txt
..  index:: Events; AfterStdWrapFunctionsInitializedEvent
..  _AfterStdWrapFunctionsInitializedEvent:

=====================================
AfterStdWrapFunctionsInitializedEvent
=====================================

The PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\AfterStdWrapFunctionsInitializedEvent`
is dispatched after any :ref:`stdWrap <t3tsref:stdwrap>` functions have been
initialized, but before any content gets modified or replaced.

Calling order of similar events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent`
*   AfterStdWrapFunctionsInitializedEvent
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

..  include:: /CodeSnippets/Events/Frontend/AfterStdWrapFunctionsInitializedEvent.rst.txt
