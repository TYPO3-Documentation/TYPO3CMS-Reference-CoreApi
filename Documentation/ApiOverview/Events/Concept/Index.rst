.. include:: /Includes.rst.txt
.. index:: Core; Extend
.. _hooks-concept:

========================
Extending the TYPO3 Core
========================

Events and Hooks provide an easy way to extend the functionality of the TYPO3 Core and
its extensions without blocking others to do the same.

:ref:`Events <EventDispatcherEvents>` are being emitted by the TYPO3 Core or an extension via the
:ref:`EventDispatcher <EventDispatcher>`. The Event
will be received by all implemented Event Listeners for the Event in question. Events are strongly
typed. Events only allow changes to variables that are intended to be changed by the Event.

:ref:`Hooks <hooks-general>` are basically places in the source code where a user function will be called for processing
if such has been configured.

.. versionchanged:: 12.0
   Signals and slots and all related classes have been removed from the
   Core. Use :ref:`PSR-14 events <EventDispatcher>` instead.


.. _hooks-video:

TYPO3 Extending Mechanisms Video
================================

Lina Wolf: Extending Extensions @ TYPO3 Developer Days 2019

.. youtube:: HFO2d2QzTek


.. index:: Events; vs. XCLASS
.. _hooks-xclass:

Events and Hooks vs. XCLASS Extensions
======================================

Events and Hooks are the recommended way of extending TYPO3 compared to
extending PHP classes with a child class (see :ref:`XCLASS extensions <xclasses>`). Because
only one extension of a PHP class can exist at a time while hooks and events
may allow many different user-designed processor functions to be executed.
With TYPO3 v10 the EventDispatcher was introduced. It is a strongly typed method of
extending TYPO3 and therefore recommended to use wherever available.

However, Events have to be emitted and Hooks have to be implemented,
in the TYPO3 Core or an extension before you can use them, while extending a
PHP class via the XCLASS method allows you to extend any class you like.


.. index:: Events; Proposing
.. _hooks-proposing:
.. _events-proposing:

Proposing Events
================

If you need to extend something which has no event or hook yet, then you
should suggest emitting an event. Normally that is rather easily done by the
author of the source you want to extend.

