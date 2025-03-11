..  include:: /Includes.rst.txt
..  index:: Events; FilterMenuItemsEvent
..  _FilterMenuItemsEvent:

====================
FilterMenuItemsEvent
====================

..  versionadded:: 12.0
    This event has been introduced to serve as a more powerful and flexible
    alternative for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/tslib/class.tslib_menu.php']['filterMenuPages']`.

The PSR-14 event :php:`\TYPO3\CMS\Frontend\Event\FilterMenuItemsEvent` has
a variety of properties and getters, along with
:php:func:`TYPO3\CMS\Frontend\Event\FilterMenuItemsEvent::getFilteredMenuItems()`
and
:php:func:`TYPO3\CMS\Frontend\Event\FilterMenuItemsEvent::setFilteredMenuItems()`.
Those methods can be used to change the items of a menu, which has been generated
with :ref:`a TypoScript HMENU <t3tsref:cobj-hmenu>` or
a :ref:`MenuProcessor <t3tsref:MenuProcessor>`.

This event is fired after TYPO3 has filtered all menu items. The menu can then
be adjusted by adding, removing or modifying the menu items. Also changing the
order is possible.

Additionally, more information about the currently rendered menu, such as
the menu items which were filtered out, is available.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Frontend/FilterMenuItemsEvent.rst.txt
