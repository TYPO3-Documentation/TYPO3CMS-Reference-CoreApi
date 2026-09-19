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

..  _DocHeaderComponent-layout:

Layout of the backend module header
===================================

..  versionchanged:: 14.0
    See `Feature: #107875 - Improved DocHeader layout and unified language
    selector
    <https://docs.typo3.org/permalink/changelog:feature-107875-1762212144>`_.

The module header consists of two rows:

*   The top row shows the breadcrumb on the left and, if the module provides
    one, the language selector on the right.
*   The second row is the button bar. On the left, it starts with the
    dropdown of the module actions in button group 0, followed by the
    buttons of the module. On the right, it holds functional buttons such as
    :guilabel:`Reload` or :guilabel:`Bookmark`.

..  _DocHeaderComponent-language-selector:

Adding module actions and a language selector to the module header
==================================================================

:php:`makeDocHeaderModuleMenu()` of the
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` adds a dropdown with
the submodules of the current module. It is hidden if there is only one.

:php:`setLanguageSelector()` of the
:php-short:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent`
places a dropdown in the top right corner. With
:php:`setShowActiveLabelText(true)`, the dropdown shows the selected item,
for example "English", as its text, and screen readers announce the label
and the selected item, "Language: English":

..  literalinclude:: _DocHeaderLanguageSelector.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

..  _DocHeaderComponent-example:

Example: build a module header with buttons and a menu
======================================================

..  include:: _AboutBlogExample.rst.txt

We use the DocHeaderComponent to register buttons and a menu to the module
header.

..  literalinclude:: /ApiOverview/Backend/BackendModules/_ModifyDocHeaderComponent.php
    :caption: Class T3docs\\BlogExample\\Controller\\BackendController
