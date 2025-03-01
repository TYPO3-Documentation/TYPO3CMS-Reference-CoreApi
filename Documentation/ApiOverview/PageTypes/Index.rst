..  include:: /Includes.rst.txt
..  index:: Page types
..  _page-types:
..  _page-types-intro:

==========
Page types
==========

TYPO3 organizes content using different **page types**, each serving a specific
purpose. See also  `Types of pages <https://docs.typo3.org/permalink/t3coreapi:list-of-page-types>`_.

Each page type serves a different function in TYPO3’s content hierarchy, making
it easier to manage complex websites.

..  figure:: /Images/ManualScreenshots/PageTypes/Overview.png
    :alt: Screenshot of the page properties form with highlighted page type (field `doktype`) and the page tree with the page type icons

    When creating a page, different page types are available at the top of the page tree. The page type can be edited in the page properties for existing pages.

The predefined page types are defined as constants in
:php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository`.

Additional page types can be registered in the
:php:`\TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry`, see also
`Create new Page Type <https://docs.typo3.org/permalink/t3coreapi:page-types-example>`_.

..  toctree::
    :caption: Topics
    :maxdepth: 1

    TypesOfPages
    RedirectHeaders
    CreateNewPageType
