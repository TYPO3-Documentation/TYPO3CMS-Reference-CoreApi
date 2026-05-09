..  include:: /Includes.rst.txt
..  index:: Events; ModifyTypoScriptConfigEvent
..  _ModifyTypoScriptConfigEvent:

===========================
ModifyTypoScriptConfigEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\ModifyTypoScriptConfigEvent`
allows listeners to adjust and react on TypoScript :ref:`config <t3tsref:config>`.

This event is dispatched *before* final TypoScript :typoscript:`config` is
written to the cache, and *not* when a page can be successfully retrieved from
the cache, which is typically the case in "page is fully cached" scenarios.

This incoming :php:`$configTree` has already been merged with the determined
PAGE :typoscript:`page.config` TypoScript of the requested :typoscript:`type` /
:typoscript:`typeNum` and the global TypoScript setup :typoscript:`config`.

The result of this event is available as a
:ref:`request attribute <typo3-request-attribute-frontend-typoscript>`:

..  code-block:: php

    $configArray = $request->getAttribute('frontend.typoscript')->getConfigArray();
    $configTree = $request->getAttribute('frontend.typoscript')->getConfigTree();


Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/ModifyTypoScriptConfigEvent.rst.txt
