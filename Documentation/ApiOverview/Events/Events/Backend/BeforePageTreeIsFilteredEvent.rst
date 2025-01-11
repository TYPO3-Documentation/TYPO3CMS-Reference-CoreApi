..  include:: /Includes.rst.txt
..  index:: Events; BeforePageTreeIsFilteredEvent
..  _BeforePageTreeIsFilteredEvent:

=============================
BeforePageTreeIsFilteredEvent
=============================

..  versionadded:: 14.0
    This PSR-14 event was introduced to add custom functionality and advanced
    evaluations to the the page tree filter.

The PSR-14 :php:`\TYPO3\CMS\Backend\Tree\Repository\BeforePageTreeIsFilteredEvent`
allows developers to extend the page trees filter's functionality and process the
given search phrase in more advanced ways.

The page tree is one of the central components in the TYPO3 backend,
particularly for editors. However, in large installations, the page tree can
quickly become overwhelming and difficult to navigate. To maintain a clear
overview, the page tree can be filtered using basic terms, such as the page
title or ID.

..  _BeforePageTreeIsFilteredEvent-example:

Example: Add evaluation of document types to the page tree search filter
========================================================================

The event listener class, using the PHP attribute :php:`#[AsEventListener]` for
registration, adds additional conditions to the filter.

..  literalinclude:: _BeforePageTreeIsFilteredEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _BeforePageTreeIsFilteredEvent-api:

BeforePageTreeIsFilteredEvent API
=================================

The event provides the following member properties:

`$searchParts`:
    The search parts to be used for filtering
`$searchUids`:
    The uids to be used for filtering by a special search part, which
    is added by Core always after listener evaluation
`$searchPhrase`
    The complete search phrase, as entered by the user
`$queryBuilder`:
    The current :php-short:`\TYPO3\CMS\Core\Database\Query\QueryBuilder`

..  important::

    The :php-short:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` instance is provided solely
    for context and to simplify the creation of
    search parts by using the :php-short:`\TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder`
    via :php:`QueryBuilder->expr()`. The instance itself **must not** be modified by listeners and
    is not considered part of the public API. TYPO3 reserves the right to change the instance at
    any time without prior notice.

..  include:: /CodeSnippets/Events/Backend/BeforePageTreeIsFilteredEvent.rst.txt
