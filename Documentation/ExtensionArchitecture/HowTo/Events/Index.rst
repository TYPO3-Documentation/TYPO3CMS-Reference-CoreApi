.. include:: /Includes.rst.txt
.. index:: pair: Extension development; Events
.. _extension-development-events:

======
Events
======

:ref:`PSR-14 events <EventDispatcher>` can be used to extend the TYPO3 Core
or third-party extensions.

You can find a complete list of events provided by the TYPO3 Core in the
following chapter: :ref:`eventlist`.

Events provided by third-party extensions should be described in the extensions
manual. You can also search for events by searching for classes that inject the
:ref:`EventDispatcherInterface`


.. _extension-development-event-listener:

Listen to an event
==================

If you want to use an event provided by the Core or a third party extension,
create a PHP class with a method `public __invoke(SomeCoolEvent $event)`
that accepts an object of the event class as
argument. It is possible use another method name but you have to configure
the name in the :file:`Configuration/Services.yaml` or it is not found.

It is best practice to use a descriptive class name that ends on
:file:`EventListener` and to put it in the namespace
:php:`MyVendor\MyExtension\EventListener`.

.. literalinclude:: _Joh316PasswordInvalidEventListener.php
   :language: php

Then register the event in your extension's :file:`Configuration/Services.yaml`:

.. literalinclude:: _EventServices.yaml
   :language: yaml

The file:`Configuration/Services.yaml` also allows to define a different
method name for the EventListener class and to influence the order in which
events are loaded. See :ref:`EventDispatcherRegistration` for details.

Dispatch an event
=================

You can dispatch events in your own extension`s code to enable other extensions
to extend your code. Events are the preferred method of making code in TYPO3
extensions extendable.

See :ref:`Event Dispatcher, Quickstart <EventDispatcherQuickStart>` on how
to create a custom event and dispatch it.
