..  include:: /Includes.rst.txt
..  index:: Events; EnhanceStdWrapEvent
..  _EnhanceStdWrapEvent:

===================
EnhanceStdWrapEvent
===================

..  versionadded:: 13.0
    This event is one of the more powerful replacements for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']`.

Listeners to the PSR-14 event
:php:`\TYPO3\CMS\Frontend\ContentObject\Event\EnhanceStdWrapEvent` are able to
modify the :ref:`stdWrap <t3tsref:stdwrap>` processing, enhancing the
functionality and manipulating the final result/content. This is the parent
event, which allows the corresponding listeners to be called on each step.

Child events:

*   :ref:`BeforeStdWrapFunctionsInitializedEvent`
*   :ref:`AfterStdWrapFunctionsInitializedEvent`
*   :ref:`BeforeStdWrapFunctionsExecutedEvent`
*   :ref:`AfterStdWrapFunctionsExecutedEvent`

All events provide the same functionality. The difference is only the execution
order in which they are called in the :typoscript:`stdWrap` processing chain.


..  _EnhanceStdWrapEvent-example:

Example
=======

..  literalinclude:: _EnhanceStdWrapEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Frontend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAddedNew.rst.txt


API
===

..  include:: /CodeSnippets/Events/Frontend/EnhanceStdWrapEvent.rst.txt
