..  include:: /Includes.rst.txt
..  index:: Events; AfterRawPageRowPreparedEvent
..  _AfterRawPageRowPreparedEvent:

============================
AfterRawPageRowPreparedEvent
============================

..  versionadded:: 13.3
    This event was introduced to replace the hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/tree/pagetree/class.t3lib_tree_pagetree_dataprovider.php']['postProcessCollections']`
    which has already been removed with TYPO3 v9.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Tree\Repository\AfterRawPageRowPreparedEvent`
allows to modify the populated properties of a page and children records before
the page is displayed in a page tree.

This can be used, for example, to change the title of a page or apply a
different sorting to its children.

..  _AfterRawPageRowPreparedEvent-example:

Example: Sort pages by title in the page tree
=============================================

..  literalinclude:: _AfterRawPageRowPreparedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _AfterRawPageRowPreparedEvent-api:

API of AfterRawPageRowPreparedEvent
===================================

..  include:: /CodeSnippets/Events/Backend/AfterRawPageRowPreparedEvent.rst.txt
