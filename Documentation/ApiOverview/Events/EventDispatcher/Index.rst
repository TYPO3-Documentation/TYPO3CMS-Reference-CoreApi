.. include:: /Includes.rst.txt
.. index::
   ! EventDispatcher
   Events; PSR-14
.. _EventDispatcher:

===============================
EventDispatcher (PSR-14 Events)
===============================

The EventDispatcher system was added to extend TYPO3's Core behaviour in TYPO3 v10.0 via PHP code. In the past,
this was done via Extbase's SignalSlot and TYPO3's custom hook system. The EventDispatcher
system is a fully capable replacement for new code in TYPO3, as well as a possibility to
migrate away from previous TYPO3 solutions.

Benni Mack: "Don't get hooked, listen to events! PSR-14 within TYPO3 v10" @ TYPO3 Developer Days 2019

..  hint::
    For a basic example on listening to an event see chapter
    :ref:`Listen to an event <extension-development-event-listener>` in the
    extension development how-to section.

.. youtube:: ElUDMXmV3Ng

.. hint::

  Additional background on the implementation can be found at https://usetypo3.com/psr-14-events.html


.. _EventDispatcherQuickStart:

Quick start
===========

.. _EventDispatcherQuickStartDispatching:

Dispatching an event
--------------------

#. Create an event class.

   An event class is basically a plain PHP object with getters for immutable
   properties and setters for mutable properties. It contains a constructor
   for all properties:

   .. code-block:: php
      :caption: EXT:some_extension/Classes/Events/DoingThisAndThatEvent.php

      final class DoingThisAndThatEvent {
         private string $mutableProperty;
         private int $immutableProperty;

         public function __construct(string $mutableProperty, int $immutableProperty) {
            // ...
         }

         // Getter for both properties, setters only for $mutableProperty;
      }

   Read more about :ref:`implementing event classes <EventDispatcherEvents>`.

#. Inject the EventDispatcher

   If you are in a controller the `EventDispatcher` already got injected
   and in this case you can omit this step.

   If the EventDispatcher is not yet available, you need have it injected:

   .. code-block:: php
      :caption: EXT:some_extension/Classes/SomeClass.php

      use Psr\EventDispatcher\EventDispatcherInterface;

      final class SomeClass {
          private EventDispatcherInterface $eventDispatcher;

          public function injectEventDispatcher(EventDispatcherInterface $eventDispatcher): void
          {
              $this->eventDispatcher = $eventDispatcher;
          }
      }

#. Dispatch the event

   Create an event object with the data that should be passed to the listeners. Use the data
   of mutable properties however it suits your business logic:

   .. code-block:: php
      :caption: EXT:some_extension/Classes/SomeClass.php

      public function doSomething() {
          // ..
          /** @var DoingThisAndThatEvent $event */
          $event = $this->eventDispatcher->dispatch(
              new DoingThisAndThatEvent("foo", 2)
          );
          $someChangedValue = $event->getMutableProperty();
          // ...
      }

.. index:: ! PSR-14
.. _EventDispatcherDescription:

Description of PSR-14 in the context of TYPO3
=============================================


PSR-14 [https://www.php-fig.org/psr/psr-14/] is a lean solution that builds upon wide-spread
solutions for hooking into existing PHP code (Frameworks, CMS and the like).

PSR-14 consists of the following four components:


.. _EventDispatcherObject:

The EventDispatcher object
--------------------------

The `EventDispatcher` object is used to trigger an Event. TYPO3 has a custom EventDispatcher
implementation. In PSR-14 all EventDispatchers of all frameworks are implementing
:php:`Psr\EventDispatcher\EventDispatcherInterface` thus it is possible to replace the event
dispatcher with another. The EventDispatcher's main method :php:`dispatch()` is called in TYPO3 Core
or extensions, that receives a PHP object and will then be handed to all available listeners.


.. index:: EventDispatcher; ListenerProvider
.. _EventDispatcherListenerProvider:

The ListenerProvider
--------------------

A :php:`ListenerProvider` object that contains all listeners which have been registered for all events.
TYPO3 has a custom ListenerProvider that collects all listeners during compile time. This component
is not exposed outside of TYPO3's Core Framework.


.. index:: EventDispatcher; Event
.. _EventDispatcherEvents:

The events
----------

An :php:`Event` object can be any PHP object and is called from TYPO3 Core or
an extension ("Emitter") containing all information to be transported to the listeners. By default,
all registered listeners get triggered by an Event, however, if an Event has the interface
:php:`Psr\EventDispatcher\StoppableEventInterface` implemented, a listener can stop further execution
of other event listeners. This is especially useful if the listeners are candidates to provide information
to the emitter. This allows to finish event dispatching, once this information has been acquired.

If an event can be modified, appropriate methods should be available, although due to PHP's
nature of handling objects and the PSR-14 Listener signature, it cannot be guaranteed to be immutable.


.. index::
   EventDispatcher; Listener
   Event listener
.. _EventDispatcherListeners:

The listeners
-------------

Extensions and PHP packages can add listeners that are registered via YAML. They are usually
associated to Event objects by the fully qualified name of the event to be listened on. It is the task of
the :php:`ListenerProvider` to provide configuration mechanisms to represent this relationship.


Advantages of the EventDispatcher over hooks
============================================

The main benefits of the EventDispatcher approach over hooks
is an implementation which helps extension authors to better understand the possibilities
by having a strongly typed system based on PHP. In addition, it serves as a bridge to also
incorporate other events provided by frameworks that support PSR-14.

.. _EventDispatcherImpact:

Impact on TYPO3 Core development in the future
==============================================

TYPO3's EventDispatcher serves as the basis to replace all hooks in the future,
however for the time being, hooks work the same way as before, unless migrated
to an EventDispatcher-like code, whereas a PHP :php:`E_USER_DEPRECATED` error can be triggered.

Some hooks might not be replaced 1:1 to EventDispatcher, but rather superseded with
a more robust or future-proof API.


.. index:: Event listener; Implementation
.. _EventDispatcherImplementation:

Implementing an event listener in your extension
================================================

..  hint::
    For a basic example on listening to an event see chapter
    :ref:`Listen to an event <extension-development-event-listener>` in the
    extension development how-to section.

.. index::
   Event Listener; Registration
   YAML; event.listener
   File; EXT:{extkey}/Configuration/Services.yaml
.. _EventDispatcherRegistration:

Registering the event listener
------------------------------

If an extension author wants to provide a custom Event Listener, an according entry with the tag
:yaml:`event.listener` can be added to the :file:`Configuration/Services.yaml` file of that extension.

.. code-block:: yaml
   :caption: EXT:some_extension/Configuration/Services.yaml

   services:
     Vendor\MyExtension\EventListener\NullMailer:
       tags:
         - name: event.listener
           method: handleEvent
           identifier: 'myListener'
           before: 'redirects, anotherIdentifier'
           event: TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent


The tag name :yaml:`event.listener` identifies that a listener should be registered.

The custom PHP class :php:`Vendor\MyExtension\EventListener\NullMailer` serves as the listener
whose :php:`handleEvent` method is called once the :yaml:`event` is dispatched.
The :yaml:`identifier` is a common name so orderings can be built upon the identifier,
the optional :yaml:`before` and :yaml:`after` attributes allow for custom sorting against the
:yaml:`identifier` of other listeners.

If no attribute :yaml:`method` is given, the class is treated as invokable, thus its :php:`__invoke` method will be called:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   services:
     Vendor\MyExtension\EventListener\NullMailer:
       tags:
         - name: event.listener
           identifier: 'myListener'
           before: 'redirects, anotherIdentifier'
           event: TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent

.. versionchanged:: 11.3
   The :yaml:`event` tag can be omitted if the listener implementation has a corresponding
   event type in the method signature. In that case the event class it is automatically derived
   from the method signature of the listener implementation.


.. index:: Event listener; Implementation
.. _EventDispatcherEventListenerClass:

The event listener class
------------------------

An example listener, which hooks into the Mailer API to modify Mailer settings to not send any emails,
could look like this:

.. code-block:: php
   :caption: EXT:some_extension/Classes/EventListener/NullMailer.php

   namespace Vendor\SomeExtension\EventListener;
   use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;

   class NullMailer
   {
       public function __invoke(AfterMailerInitializationEvent $event): void
       {
           $event->getMailer()->injectMailSettings(['transport' => 'null']);
       }
   }

An extension can define multiple listeners.

Once the emitter is triggering an Event, this listener is called automatically. Be sure
to inspect the Event PHP class to fully understand the capabilities provided by an Event.


.. index:: Event listener; Best practices
.. _EventDispatcherBestPractises:

Best practices
--------------

1. When configuring listeners, it is recommended to add one listener class per
   event type, and have it called via :php:`__invoke()`.

2. When creating a new event PHP class, it is recommended to add a :php:`Event` suffix to the PHP class,
   and to move it into an appropriate folder like :php:`Classes/Database/Event` to easily discover
   events provided by a package. Be careful about the context that should be exposed.

3. Emitters (TYPO3 Core or Extension authors) should always use *Dependency Injection* to receive the
   EventDispatcher object as a constructor argument, where possible, by adding a type declaration
   for :php:`Psr\EventDispatcher\EventDispatcherInterface`.

Any kind of event provided by TYPO3 Core falls under TYPO3's Core API deprecation policy, except
for its constructor arguments, which may vary. Events that should only be used within TYPO3 Core,
are marked as :php:`@internal`, just like other non-API parts of TYPO3. :php:`@internal` events should be
avoided whenever technically possible.


.. index:: Event listener; Best practices
.. _EventDebugging:

Debugging event handling
========================

A complete list of all registered event listeners can be viewed in the the module
:guilabel:`System > Configuration > Event Listeners (PSR-14)`. The system extension
`lowlevel` has to be installed for this module to be available.

.. TODO: add screenshot

To debug all events that are actually dispatched during a frontend request you can use the
admin panel:

Go to :guilabel:`Admin Panel > Debug > Events` and see all dispatched events.
The system extension `adminpanel` has to be installed for this module to be available.

.. TODO: add screenshot
