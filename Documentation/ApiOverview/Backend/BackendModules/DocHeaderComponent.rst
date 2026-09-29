..  include:: /Includes.rst.txt
..  index:: Backend modules; DocHeaderComponent
..  _docheadercomponent:

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

..  _docheadercomponent-api:

`DocHeaderComponent` API
========================

It has the following methods:

..  include:: _DocHeaderComponent.rst.txt

..  _docheadercomponent-breadcrumb:

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

..  _docheadercomponent-layout:

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

..  _docheadercomponent-automatic-buttons:

Adding reload and bookmark buttons with `setShortcutContext()`
==============================================================

..  versionadded:: 14.0
    :changelog: feature-108008-1762896168

The :php-short:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent`
adds the :guilabel:`Reload` button to every module, and the
:guilabel:`Bookmark` button to every module that names its context. Both
come last in the button bar, so they keep the same position in every
module.

:php-short:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent::setShortcutContext()`
names what the bookmark points to. The display name appears in the bookmark
list, so it should name the record or the page the user works on:

..  literalinclude:: _DocHeaderShortcutContext.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :visible-lines: 26-31

A module that brings its own reload button, or that must not be
bookmarked, switches the automatic button off:

..  literalinclude:: _DocHeaderShortcutContext.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :visible-lines: 41-46

Both buttons are in the button bar before the
:ref:`ModifyButtonBarEvent <ModifyButtonBarEvent>` is dispatched, so a
listener can change or remove them.

..  _docheadercomponent-language-selector:

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

..  _docheadercomponent-example:

Example: build a module header with buttons and a menu
======================================================

We use the DocHeaderComponent to register buttons and a menu to the module
header.

..  literalinclude:: /ApiOverview/Backend/BackendModules/_ModifyDocHeaderComponent.php
    :caption: Class MyVendor\\MyExtension\\Controller\\BackendController
