..  include:: /Includes.rst.txt
..  index::
    ! EventDispatcher
    Events; PSR-14
..  _EventDispatcher:

================================
Event dispatcher (PSR-14 events)
================================

The event dispatcher system was added to extend TYPO3's Core behaviour in
TYPO3 v10.0. In the past, this was done via Extbase's signal/slot and TYPO3's
custom hook system. The event dispatcher system is a fully-capable replacement
for new code in TYPO3, as well as a possibility to migrate away from previous
TYPO3 solutions.

    Don't get hooked, listen to events! PSR-14 within TYPO3 v10.

    -- Benni Mack @ TYPO3 Developer Days 2019

For a basic example on listening to an event, see the chapter
:ref:`Listen to an event <extension-development-event-listener>` in the
extension development how-to section.

..  youtube:: ElUDMXmV3Ng

..  hint::
    Additional background information on the implementation can be found at
    https://usetypo3.com/psr-14-events.html

..  contents:: **Table of Contents**
    :local:

..  _EventDispatcherQuickStart:

Quick start
===========

..  _EventDispatcherQuickStartDispatching:

Dispatching an event
--------------------

This quick start section shows how to create your own event class and dispatch it.
If you just want to listen on an existing event, see section
:ref:`EventDispatcherImplementation`.

..  rst-class:: bignums

#.  Create an event class.

    An event class is basically a plain PHP object with getters for immutable
    properties and setters for mutable properties. It contains a constructor
    for all properties:

    ..  literalinclude:: _DoingThisAndThatEvent.php
        :language: php
        :caption: EXT:my_extension/Classes/Event/DoingThisAndThatEvent.php

    Read more about :ref:`implementing event classes <EventDispatcherEvents>`.

#.  Inject the event dispatcher

    If you are in a controller, the event dispatcher has already been injected,
    and in this case you can omit this step.

    If the event dispatcher is not yet available, you need to inject it:

    ..  literalinclude:: _SomeClass.php
        :language: php
        :caption: EXT:my_extension/Classes/SomeClass.php

#.  Dispatch the event

    Create an event object with the data that should be passed to the listeners.
    Use the data of mutable properties as it suits your business logic:

    ..  literalinclude:: _SomeClass2.php
        :language: php
        :caption: EXT:my_extension/Classes/SomeClass.php

..  index:: ! PSR-14
..  _EventDispatcherDescription:

Description of PSR-14 in the context of TYPO3
=============================================

`PSR-14`_ is a lean solution that builds upon wide-spread solutions for hooking
into existing PHP code (Frameworks, CMS, and the like).

..  _PSR-14: https://www.php-fig.org/psr/psr-14/

PSR-14 consists of the following four components:


..  _EventDispatcherObject:

The event dispatcher object
---------------------------

The :php:`EventDispatcher` object is used to trigger an event. TYPO3 has a
custom event dispatcher implementation. In PSR-14 all event dispatchers of all
frameworks are implementing
:php:`\Psr\EventDispatcher\EventDispatcherInterface`, thus it is possible to
replace the event dispatcher with another. The :php:`EventDispatcher`'s main
method :php:`dispatch()` is called in TYPO3 Core or extensions. It receives a
PHP object which will then be handed to all available listeners.


..  index:: EventDispatcher; ListenerProvider
..  _EventDispatcherListenerProvider:

The listener provider
---------------------

A :php:`ListenerProvider` object that contains all listeners which have been
registered for all events. TYPO3 has a custom listener provider that collects
all listeners during compile time. This component is only used internally inside of
TYPO3's Core Framework.


..  index:: EventDispatcher; Event
..  _EventDispatcherEvents:

The events
----------

An :php:`Event` object can be any PHP object and is called from TYPO3 Core or
an extension ("emitter") containing all information to be transported to the
listeners. By default, all registered listeners get triggered by an event,
however, if an event has the interface
:php:`\Psr\EventDispatcher\StoppableEventInterface` implemented, a listener can
stop further execution of other event listeners. This is especially useful, if
the listeners are candidates to provide information to the emitter. This allows
to finish event dispatching, once this information has been acquired.

If an event allows modifications, appropriate methods should be available, although
due to PHP's nature of handling objects and the PSR-14 listener signature, it
cannot be guaranteed to be immutable.

..  seealso::
    :ref:`List of all events provided by TYPO3 <eventlist>`


..  index::
    EventDispatcher; Listener
    Event listener
..  _EventDispatcherListeners:

The listeners
-------------

Extensions and PHP packages can add listeners that are registered via YAML. They
are usually associated to :php:`Event` objects by the fully-qualified class name
of the event to be listened on. It is the task of the listener provider to
provide configuration mechanisms to represent this relationship.

If multiple event listeners for a specific event are registered, their order can
be configured or an existing event listener can also be overridden with a different one.

The :guilabel:`System > Configuration > Event Listeners (PSR-14)` backend module (requires
the system extension :doc:`lowlevel <ext_lowlevel:Index>`) reveals an overview of all registered
event listeners, see :ref:`EventDebugging`.


Advantages of the event dispatcher over hooks
=============================================

The main benefits of the event dispatcher approach over hooks is an
implementation which helps extension authors to better understand the
possibilities by having a strongly typed system based on PHP. In addition, it
serves as a bridge to also incorporate other events provided by frameworks that
support PSR-14.

..  _EventDispatcherImpact:

Impact on TYPO3 Core development in the future
==============================================

TYPO3's event dispatcher serves as the basis to replace all
:ref:`hooks <hooks-general>` in the future. However, for the time being, hooks
work the same way as before, unless migrated to an event dispatcher-like code,
whereas a PHP :php:`E_USER_DEPRECATED` error can be triggered.

Some hooks might not be replaced 1:1 to event dispatcher, but rather superseded
with a more robust or future-proof API.


..  index:: Event listener; Implementation
..  _EventDispatcherImplementation:

Implementing an event listener in your extension
================================================

..  hint::
    For a basic example on listening to an event, see the chapter
    :ref:`Listen to an event <extension-development-event-listener>` in the
    extension development how-to section.

..  versionadded:: 13.0
    A `PHP attribute`_ :php:`\TYPO3\CMS\Core\Attribute\AsEventListener` is
    available to autoconfigure a class as an event listener. If the PHP
    attribute is used, the :ref:`configuration of the event listener
    <EventDispatcherRegistration>` via the :file:`Configuration/Services.yaml`
    file is not necessary anymore.

..  _PHP attribute: https://www.php.net/manual/en/language.attributes.overview.php

..  index:: Event listener; Implementation
..  _EventDispatcherEventListenerClass:

The event listener class
------------------------

An example listener, which hooks into the :ref:`Mailer API <mail>` to modify
mailer settings to not send any emails, could look like this:

..  literalinclude:: _NullMailer.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/NullMailer.php

An extension can define multiple listeners. The attribute can be used on class
and method level. The PHP attribute is repeatable, which allows to register the
same class to listen for different events.

Once the emitter is triggering an event, this listener is called automatically.
Be sure to inspect the event's PHP class to fully understand the capabilities
provided by an event.

The PHP attribute :php:`\TYPO3\CMS\Core\Attribute\AsEventListener` supports the
following properties (which are all optional):

:php:`identifier`
    A unique identifier should be declared which identifies the event listener,
    and orderings can be build upon the identifier. If this property is not
    explicitly defined, the service name is automatically used instead.

:php:`before`
    This property allows a custom sorting of registered listeners. The listener
    is then dispatched before the given listener. The value is the identifier of
    another event listener. Also, multiple event identifiers can be entered here,
    separated by a comma.

:php:`after`
    This property allows a custom sorting of registered listeners. The listener
    is then dispatched after the given listener. The value is the identifier of
    another event listener. Also, multiple event identifiers can be entered here,
    separated by a comma.

:php:`event`
    The fully-qualified class name (FQCN) of the dispatched event, that the
    listener wants to react to. It is recommended to not specify this property,
    but to use the FQCN as type declaration of the argument within the dispatched method
    (usually :php:`__invoke(EventName $event)`).

:php:`method`
    The method to be called. If this property is not given, the listener class
    is treated as invokable, thus its :php:`__invoke()` method is called.

The PHP attribute is repeatable, which allows to register the same class
to listen for different events, for example:

..  literalinclude:: _NullMailerRepeatable.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/NullMailer.php

The PHP attribute can also be used on a method level. The above example can also
be written as:

..  literalinclude:: _NullMailerRepeatable2.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/NullMailer.php


..  index::
    Event Listener; Registration
    YAML; event.listener
    File; EXT:{extkey}/Configuration/Services.yaml
..  _EventDispatcherRegistration:

Registering the event listener via :file:`Services.yaml`
--------------------------------------------------------

..  versionadded:: 13.0
    If using the PHP attribute :php:`\TYPO3\CMS\Core\Attribute\AsEventListener`
    to configure an event listener, the registration in the
    :file:`Configuration/Services.yaml` file is not necessary anymore.

If an extension author wants to provide a custom event listener, an according
entry with the tag :yaml:`event.listener` can be added to the
:file:`Configuration/Services.yaml` file of that extension.

..  literalinclude:: _ServicesWithMethod.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The tag name :yaml:`event.listener` identifies that a listener should be registered.

The custom PHP class :php:`\MyVendor\MyExtension\EventListener\NullMailer`
serves as the listener whose :php:`handleEvent()` method is called, once the
:yaml:`event` is dispatched. The name of the listened event is specified as
a typed argument to that dispatch method.
:php:`handleEvent(\TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent $event)` will
for example listen on the event `AfterMailerInitializationEvent`.

The :yaml:`identifier` is a common name, so
orderings can be built upon the identifier, the optional :yaml:`before` and
:yaml:`after` attributes allow for custom sorting against the :yaml:`identifier`
of other listeners. If no :yaml:`identifier` is specified, the service name (usually
the fully-qualified class name of the listener) is automatically used.

If no attribute :yaml:`method` is given, the class is treated as invokable, thus
its :php:`__invoke()` method will be called:

..  literalinclude:: _ServicesWithoutMethod.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

..  index:: Override Event Listener; Event override
..  _EventListenerOverride:

Overriding event listeners
--------------------------

Existing event listeners can be overridden by custom implementations. This can be
performed with both methods, either by using the PHP :php:`#[AsEventListener]`
attribute, or via :file:`EXT:my_extension/Configuration/Services.yaml`.

For example, a third-party extension listens on the event
:php:`\TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent` via the PHP attribute:

..  literalinclude:: _ServicesOverrideBase.php
    :language: php
    :caption: EXT:some_extension/Classes/EventListener/SeoEvent.php
    :emphasize-lines: 12

or via :file:`Services.yaml` declaration:

..  literalinclude:: _ServicesOverrideBase.yaml
    :language: yaml
    :caption: EXT:some_extension/Configuration/Services.yaml
    :emphasize-lines: 5

If you want to replace this event listener with your custom implementation, your extension can
achieve this by specifying the overridden identifier via the PHP attribute:

..  literalinclude:: _ServicesOverrideCustom.php
    :language: php
    :caption: EXT:my_extension/Configuration/Classes/EventListener/MySeoEvent.php
    :emphasize-lines: 12

or via :file:`Services.yaml` declaration:

..  literalinclude:: _ServicesOverrideCustom.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml
    :emphasize-lines: 6

..  note::

    When overriding an event listener, be sure to check whatever the
    listener provided as changes to an event. Your own event listener
    implementation is now responsible for any functionality, because
    the original listener will no longer be executed.

Make sure that you set the `identifier` property to exactly
the string which the original implementation uses. If the identifier is not mentioned specifically
in the original implementation, the service name (when unspecified, the fully-qualified name of the event
listener class) is used. You can inspect that identifier in the
:guilabel:`System > Configuration > Event Listeners (PSR-14)` backend module (requires the system extension
:doc:`lowlevel <ext_lowlevel:Index>`), see :ref:`EventDebugging`. In this example,
if :yaml:`identifier: 'ext-some-extension/modify-hreflang'` is not defined, the identifier
will be set to :yaml:`identifier: 'SomeVendor\SomeExtension\Seo\HrefLangEventListener'` and you could
use that identifier in your implementation.

..  note::

   Overriding listeners requires your extension to declare a dependency on the
    :php:`EXT:some_extension` extension (through :file:`composer.json`, or for non-Composer
    mode :file:`ext_emconf.php`).
    This ensures a proper loading order, so your extension is processed after the extension you want
    to override.

..  index:: Event listener; Best practices
..  _EventDispatcherBestPractises:

Best practices
--------------

*   When configuring listeners, it is recommended to add one listener class per
    event type, and have it called via :php:`__invoke()`.

*   When creating a new event PHP class, it is recommended to add an
    :php:`Event` suffix to the PHP class, and to move it into an appropriate
    folder like :file:`Classes/Event/` to easily discover events provided by a
    package. Be careful about the context that should be exposed.

*   The same applies to creating a new event listener PHP class: Add
    an :php:`Listener` suffix to the PHP class, and move it to a folder
    :file:`Classes/EventListener/`.

*   Emitters (TYPO3 Core or extension authors) should always use
    :ref:`Dependency Injection <DependencyInjection>` to receive the event
    dispatcher object as a constructor argument, where possible, by adding a
    type declaration for :php:`\Psr\EventDispatcher\EventDispatcherInterface`.

*   A unique and descriptive :yaml:`identifier` should be used for event listeners.

Any kind of event provided by TYPO3 Core falls under TYPO3's Core API
deprecation policy, except for its constructor arguments, which may vary. Events
that should only be used within TYPO3 Core, are marked as :php:`@internal`, just
like other non-API parts of TYPO3. Events marked as :php:`@internal` should be
avoided whenever technically possible.


..  index:: Event listener; Best practices
..  _EventDebugging:

Debugging event handling
========================

A complete list of all registered event listeners can be viewed in the the
module :guilabel:`System > Configuration > Event Listeners (PSR-14)`. The
:doc:`lowlevel <ext_lowlevel:Index>` system extension has to be installed for
this module to be available.

..  figure:: /Images/ManualScreenshots/Events/ConfigurationEventListeners.png
    :alt: List of event listeners in the Configuration module
    :class: with-border

    List of event listeners in the :guilabel:`Configuration` module

To debug all events that are actually dispatched during a frontend request you
can use the admin panel:

Go to :guilabel:`Admin Panel > Debug > Events` and see all dispatched events.
The :doc:`adminpanel <ext_adminpanel:Index>` system extension has to be
installed for this module to be available.

..  figure:: /Images/ManualScreenshots/Events/AdminPanelEvents.png
    :alt: List of dispatched events in the Admin Panel
    :class: with-border

    List of dispatched events in the Admin Panel
