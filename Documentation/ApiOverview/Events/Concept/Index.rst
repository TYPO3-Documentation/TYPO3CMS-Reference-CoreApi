..  include:: /Includes.rst.txt
..  index:: Core; Extend
..  _hooks-concept:

========================
Extending the TYPO3 Core
========================

Events and hooks provide an easy way to extend the functionality of the TYPO3
Core and its extensions without blocking others to do the same.

:ref:`Events <EventDispatcherEvents>` are being emitted by the TYPO3 Core or an
extension via the :ref:`event dispatcher <EventDispatcher>`. The event will be
received by all implemented event listeners for the event in question. Events
are strongly typed. Events only allow changes to variables that are intended to
be changed by the event.

:ref:`Hooks <hooks-general>` are basically places in the source code where a
user function will be called for processing, if such has been configured.

..  _hooks-video:

TYPO3 extending mechanisms video
================================

Lina Wolf: Extending Extensions @ TYPO3 Developer Days 2019

..  youtube:: HFO2d2QzTek


..  index:: Events vs. XCLASS
..  _hooks-xclass:

Events and hooks vs. XCLASS extensions
======================================

Events and hooks are the recommended way of extending TYPO3 compared to
extending PHP classes with a child class (see
:ref:`XCLASS extensions <xclasses>`). Using the XCLASS functionality only one
extension of a PHP class can exist at a time while hooks and events
may allow many different user-designed processor functions to be executed.
With TYPO3 v10 the event dispatcher was introduced. It is a strongly typed
way of extending TYPO3 and therefore recommended to use wherever available.

However, events have to be emitted and hooks have to be implemented in the TYPO3
Core or an extension before they can be used, while extending a PHP class via
the XCLASS method allows you to extend any class you like.


..  index:: Events; Proposing
..  _hooks-proposing:
..  _events-proposing:

Proposing events
================

If you need to extend the functionality of a class which has no event or hook
yet, then you should suggest emitting an event. Normally that is rather easily
done by the author of the source you want to extend:

*   For the TYPO3 Core create an issue on `forge.typo3.org`_.
*   For a third-party extension create an issue in the according issue tracker
    of that extension.

..  _forge.typo3.org: https://forge.typo3.org/projects/typo3cms-core/issues
