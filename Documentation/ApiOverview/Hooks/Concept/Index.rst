.. include:: ../../../Includes.txt



.. _hooks-concept:

========================
Extending the TYPO3 Core
========================

Events, Hooks and Signals provide an easy way to extend the functionality of the TYPO3 Core and
its extensions without blocking others to do the same.

:ref:`Events <EventDispatcherEvents>` are being emitted by the TYPO3 Core or an Extension via the
:ref:`EventDispatcher <EventDispatcher>. The Event
will be received by all implemented Event Listeners for the Event in question. Events are strongly
typed. Events only allow changes to variables that are intended to be changed by the Event.

:ref:`Hooks <hooks-general>` are basically places in the source code where a user function will be called for processing
if such has been configured.

Signals roughly follow the observer pattern.
:ref:`Signals and Slots <signals-slots>` decouple the sender (sending a signal) and the receiver(s)
(called slots). The sender sends a signal - like "database updated" - and all
receivers listening to that signal will be executed.


.. _hooks-video:

TYPO3 Extending Mechanisms Video
================================

Lina Wolf: Extending Extensions @ TYPO3 Developer Days 2019

.. youtube:: HFO2d2QzTek


.. _hooks-xclass:

Events, Signals and Hooks vs. XCLASS Extensions
===============================================

Events, Signals and Hooks are the recommended way of extending TYPO3 compared to
extending PHP classes with a child class (see :ref:`XCLASS extensions <xclasses>`). Because
only one extension of a PHP class can exist at a time while hooks and signals
may allow many different user-designed processor functions to be executed.
With TYPO3 10 the EventDispatcher was introduced. It is a strongly typed method of
extending TYPO3 and therefore recommended to use wherever available.

However, Events have to be emitted, Hooks and Signals have to be implemented,
in the TYPO3 core or an Extension before you can use them, while extending a
PHP class via the XCLASS method allows you to extend any class you like.


.. _hooks-proposing:

Proposing Events, Hooks or Signals
==================================

If you need to extend something which has no event, hook or signal yet, then you
should suggest emitting or implementing one. Normally that is rather easily done by the
author of the source you want to extend.

