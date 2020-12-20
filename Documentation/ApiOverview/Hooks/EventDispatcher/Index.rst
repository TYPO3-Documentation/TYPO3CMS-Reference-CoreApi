.. include:: /Includes.rst.txt
.. index::
   ! EventDispatcher
   Events; PSR-14
.. _EventDispatcher:

===============================
EventDispatcher (PSR-14 Events)
===============================

.. versionadded:: 10.0

   :doc:`t3core:Changelog/10.0/Feature-88770-PSR-14BasedEventDispatcher`

The EventDispatcher system was added to extend TYPO3's Core behaviour in TYPO3 10.0 via PHP code. In the past,
this was done via Extbase's SignalSlot and TYPO3's custom hook system. The new EventDispatcher
system is a fully capable replacement for new code in TYPO3, as well as a possibility to
migrate away from previous TYPO3 solutions.

Benni Mack: "Don't get hooked, listen to events! PSR-14 within TYPO3 v10" @ TYPO3 Developer Days 2019

.. youtube:: ElUDMXmV3Ng

.. hint::

  Additional background on the implementation can be found at https://usetypo3.com/psr-14-events.html


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


Advantages of the EventDispatcher over hooks and signals and slots
==================================================================

The main benefits of the EventDispatcher approach over Hooks and Extbase's SignalSlot dispatcher
is an implementation which helps extension authors to better understand the possibilities
by having a strongly typed system based on PHP. In addition, it serves as a bridge to also
incorporate other events provided by frameworks that support PSR-14.

.. _EventDispatcherImpact:

Impact on TYPO3 Core development in the future
==============================================

TYPO3's EventDispatcher serves as the basis to replace all Signal/Slots and hooks in the future,
however for the time being, hooks and registered Slots work the same way as before, unless migrated
to an EventDispatcher-like code, whereas a PHP :php:`E_USER_DEPRECATED` error can be triggered.

Some hooks / signal/slots might not be replaced 1:1 to EventDispatcher, but rather superseded with
a more robust or future-proof API.


.. index:: Event listener; Implementation
.. _EventDispatcherImplementation:

Implementing an event listener in your extension
================================================


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

   services:
     MyCompany\MyPackage\EventListener\NullMailer:
       tags:
         - name: event.listener
           identifier: 'myListener'
           event: TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent
           before: 'redirects, anotherIdentifier'


The tag name :yaml:`event.listener` identifies that a listener should be registered.

The custom PHP class :php:`MyCompany\MyPackage\EventListener\NullMailer` serves as the listener,
whereas the :yaml:`identifier` is a common name so orderings can be built upon the identifier,
the optional :yaml:`before` and :yaml:`after` attributes allow for custom sorting against :yaml:`identifier`.

The :yaml:`event` attribute is the Fully Qualified Name of the Event object.

If no attribute :yaml:`method` is given, the class is treated as Invokable, thus :php:`__invoke` method is called.


.. index:: Event listener; Implementation
.. _EventDispatcherEventListenerClass:

The event listener class
------------------------

An example listener, which hooks into the Mailer API to modify Mailer settings to not send any emails,
could look like this:

.. code-block:: php

   namespace MyCompany\MyPackage\EventListener;
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
are marked as :php:`@internal`, just like other non-API parts of TYPO3, but :php:`@internal` events will be
avoided whenever technically possible.


