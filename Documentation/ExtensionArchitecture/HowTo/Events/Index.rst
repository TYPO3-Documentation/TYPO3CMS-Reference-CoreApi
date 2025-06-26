:navigation-title: Events

.. include:: /Includes.rst.txt
.. index:: pair: Extension development; Events
.. _extension-development-events:

==========================================
Using and dispatching events in extensions
==========================================

:ref:`PSR-14 events <EventDispatcher>` can be used to extend the TYPO3 Core
or third-party extensions.

You can find a complete list of events provided by the TYPO3 Core in the
following chapter: :ref:`eventlist`.

Events provided by third-party extensions should be described in the extension's
manual. You can also search for events by looking for classes that inject the
:ref:`Psr\\EventDispatcher\\EventDispatcherInterface <EventDispatcherObject>`.

.. _extension-development-event-listener:

Listen to an event
==================

If you want to use an event provided by the Core or a third-party extension,
create a PHP class with a method :php:`__invoke(SomeCoolEvent $event)`
that accepts an object of the event class as
argument. It is possible to use another method name but you have to configure
the name in the :file:`Configuration/Services.yaml` or it is not found.

It is best practice to use a descriptive class name and to put it in the
namespace :php:`MyVendor\MyExtension\EventListener`.

.. literalinclude:: _Joh316PasswordInvalidator.php
   :language: php

Then register the event in your extension's :file:`Configuration/Services.yaml`:

.. literalinclude:: _EventServices.yaml
   :language: yaml

Additionally, the :file:`Configuration/Services.yaml` file allows to define a different
method name for the event listener class and to influence the order in which
events are loaded. See :ref:`EventDispatcherRegistration` for details.

Dispatch an event
=================

You can dispatch events in your own extension's code to enable other extensions
to extend your code. Events are the preferred method of making code in TYPO3
extensions extendable.

See :ref:`Event Dispatcher, Quickstart <EventDispatcherQuickStart>` on how
to create a custom event and dispatch it.
