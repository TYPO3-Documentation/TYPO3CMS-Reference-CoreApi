:navigation-title: Page tree
..  include:: /Includes.rst.txt
..  _page-tree:

==================================
The page tree in the TYPO3 backend
==================================

The **page tree** is a hierarchical structure that represents pages and their
subpages on a website, allowing editors and integrators to easily organize and
manage content and navigation.

It is displayed on the left of backend modules with
:ref:`navigationComponent <t3coreapi:confval-backend-module-navigationcomponent>`
set to `'@typo3/backend/tree/page-tree-element'`.

Usage of the page tree is described in
`Getting Started Tutorial, Page tree <https://docs.typo3.org/permalink/t3start:page-tree>`_.

The page tree can also be navigated via `Keyboard commands (Tutorial for
Editors) <https://docs.typo3.org/permalink/t3editors:keyboard-commands>`_.

..  contents::

..  _page-tree-events:

PSR-14 events to influence the functionality of the page tree
=============================================================

:ref:`AfterPageTreeItemsPreparedEvent`
    Allows prepared page tree items to be modified.
:ref:`AfterRawPageRowPreparedEvent`
    Allows to modify the populated properties of a page and children records
    before the page is displayed in a page tree.

..  _page-tree-tsconfig:

TsConfig settings to influence the page tree
============================================

The rendering of the page tree can be influenced via user TsConfig
:ref:`options.pageTree <t3tsref:confval-useroptions-pagetree>`.
