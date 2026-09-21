..  include:: /Includes.rst.txt
..  index:: Backend modules; DocHeaderComponent
..  _DocHeaderComponent:

====================
`DocHeaderComponent`
====================

The :php:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent` can be
used to display a standardized header section in a backend module with buttons,
menus etc. It can also be used to hide the header section in case it is
not desired to display it.

..  figure:: /Images/ManualScreenshots/Backend/DocHeaderComponent.png
    :class: with-shadow

    The module header displayed by the DocHeaderComponent

You can get the :php:`DocHeaderComponent` with
:php:method:`\TYPO3\CMS\Backend\Template\ModuleTemplate::getDocHeaderComponent`
from your module template.

..  contents:: Table of contents

..  _DocHeaderComponent-api:

`DocHeaderComponent` API
========================

It has the following methods:

..  include:: _DocHeaderComponent.rst.txt

..  _DocHeaderComponent-breadcrumb:

Setting the breadcrumb of a backend module
==========================================

..  versionadded:: 14.0
    See `Feature: #107794 - Improved breadcrumb navigation in backend
    <https://docs.typo3.org/permalink/changelog:feature-107794-1730000000>`_.

The breadcrumb shows where the user is, and each of its nodes links back to
that level. A module tells the
:php-short:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent`
what the user is working on:

:php:`setPageBreadcrumb(array $pageRecord)`
    The page of the given page record, with the path through the page tree.

:php:`setRecordBreadcrumb(string $table, int $uid)`
    A record of any table, on the page it belongs to.

:php:`setResourceBreadcrumb(ResourceInterface $resource)`
    A file or folder, with the path through its file storage.

:php:`addBreadcrumbSuffixNode(BreadcrumbNode $node)`
    An additional node at the end, for example for the current action. A
    node without a URL is not clickable, which suits the current item.

The nodes are built from the current request, so they keep the module and
its current action.

..  _DocHeaderComponent-layout:

Layout of the backend module header
===================================

..  versionchanged:: 14.0
    See `Feature: #107875 - Improved DocHeader layout and unified language
    selector
    <https://docs.typo3.org/permalink/changelog:feature-107875-1762212144>`_.

The module header consists of two rows:

*   The top row has the breadcrumb on the left and, if the module provides
    one, a language selector on the right.
*   The second row is the button bar. On the left, it starts with the
    dropdown of the module actions from button group 0, followed by the
    module buttons. The functional buttons are on the right, such as
    :guilabel:`Reload` or :guilabel:`Bookmark`.

    ..  figure:: /Images/ManualScreenshots/Backend/DocHeaderComponent.png
        :class: with-shadow

        The module header displayed by the DocHeaderComponent

..  _DocHeaderComponent-language-selector:

Adding module actions and a language selector to the module header
==================================================================

:php:`makeDocHeaderModuleMenu()` of
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` adds a dropdown
consisting of the submodules of the current module. If there is only one, it is
hidden.

:php:`setLanguageSelector()` of
:php-short:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent`
places a dropdown in the top right corner. If
:php:`setShowActiveLabelText(true)`, the dropdown shows the selected item,
for example "English", as its text, and screen readers announce the label
and the selected item, "Language: English":

..  literalinclude:: _DocHeaderLanguageSelector.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :emphasize-lines: 34,53,76

..  _DocHeaderComponent-example:

Example: build a module header with buttons and a menu
======================================================

..  include:: _AboutBlogExample.rst.txt

We use the DocHeaderComponent to register buttons and a menu to the module
header.

..  literalinclude:: /ApiOverview/Backend/BackendModules/_ModifyDocHeaderComponent.php
    :caption: Class T3docs\\BlogExample\\Controller\\BackendController
