.. include:: /Includes.rst.txt
.. index::
   !Dependency injection
   pair: Dependency injection; Extensions
   pair: Dependency injection; Services
   File; EXT:{extkey}/Configuration/Services.yaml

.. _DependencyInjection:
.. _Dependency-Injection:

====================
Dependency injection
====================


.. rst-class:: compact-list
.. contents:: This page
   :local:


Abstract
========

This chapter explains "Dependency Injection (DI)" *as used in TYPO3.* Readers
interested in the general concepts and principles may want to look at, for
example, `Dependency Injection
<https://phptherightway.com/#dependency_injection>`__ in "PHP The Right Way" or
`What is dependency injection?
<http://fabien.potencier.org/what-is-dependency-injection.html>`__ by Fabien
Potencier. Whenever a class has a *service dependency* to another class the
technique of *dependency injection* should be used to satisfy that need. TYPO3
uses a Symfony component for dependency injection. The component is `PSR-11
<https://www.php-fig.org/psr/psr-11/>`_ compliant, and it is used throughout
Core and extensions to standardize object initialization. By default all API
services shipped with the TYPO3 Core system extensions offer dependency
injection. The recommended usage is :ref:`constructor injection
<Constructor-injection>`. Available as well are :ref:`method injection
<Method-injection>` and :ref:`interface injection <Interface-injection>`.
To activate the Symfony component for dependency injection a few lines of
:ref:`configuration <Configuration>` are necessary.


Introduction
============

The title of this chapter is "dependency injection" (DI), but the scope is a bit
broader: In general, this chapter is about *TYPO3 object lifecycle management* and
*how to obtain objects*, with one sub-part of it being dependency injection.

The underlying interfaces are based on the PHP-FIG (PHP Framework Interop Group) standard
`PSR-11 Container interface <https://www.php-fig.org/psr/psr-11/>`_, and the
implementation is based on `Symfony service container <https://symfony.com/doc/current/service_container.html>`_
and `Symfony dependency injection <https://symfony.com/doc/current/components/dependency_injection.html>`_ components,
plus some TYPO3 specific sugar.

This chapter not only talks about Symfony DI and its configuration via :file:`Services.yaml`,
but also a bit about services in general, about :php:`GeneralUtility::makeInstance()` and the
:php:`SingletonInterface`. And since the TYPO3 core already had an object lifecycle management
solution with the extbase :php:`ObjectManager` before Symfony services were implemented, we'll
also talk about how to transition away from it towards the core-wide Symfony solution.


Background and history
======================

Obtaining object instances in TYPO3 has always been straightforward: Call
:php:`GeneralUtility::makeInstance(\MyVendor\MyExtension\Some\Class::class)` and hand over
mandatory and optional :php:`__construct()` arguments as additional arguments.

There are two quirks to that:

* First, a class instantiated through makeInstance() can implement :php:`SingletonInterface`.
  This empty interface definition tells makeInstance() to instantiate the object exactly once
  for this request, and if another makeInstance() call asks for it, *the same object instance*
  is returned - otherwise makeInstance() always creates a new object instance and returns it.

* Second, :php:`makeInstance()` allows :ref:`"XCLASSing" <xclasses>`. This is a - rather dirty -
  way to substitute a class with a custom implementation. XCLASS'ing in general is
  brittle and seen as a last resort hack if no better solution is available. In connection
  with Symfony containers, XCLASSing services should be avoided in general and service
  overrides should be used instead. Replacing the XCLASS functionality in TYPO3 is still work in progress.
  In contrast, XCLASSing is still useful for data objects, and there is no good other solution yet.

Using :php:`makeInstance()` worked very well for a long time. It however lacked a feature
that has been added to the PHP world after :php:`makeInstance()` had been invented: Dependency injection.
There are lots of articles about dependency injection on the net, so we won't go too deep
here but rather explain the main idea: The general issue appears when classes follow the
`separation of concerns <https://en.wikipedia.org/wiki/Separation_of_concerns>`_
principle.

One of the standard examples is logging. Let's say a class's responsibility is the
creation of users - it checks everything and finally writes a row to database. Now, since
this is an important operation, the class wants to log an information like "I just created user 'foo'".
And this is where dependency injection enters the game: Logging is a huge topic, there are
various levels of error, information can be written to various destinations and so on. The
little class does not want to deal with all those details, but just wants to tell the framework: "Please
give me some logger I can use and that takes care of all details, I don't want to know about details". This
separation is the heart of *single responsibility* and *separation of concerns*.

Dependency injection does two things for us here: First, it allows separating concerns, and second,
it hands the task of finding an appropriate implementation of a dependency over to the framework,
so the framework decides - based on configuration - which specific instance is given to the
consumer. Note in our example, the logging instance itself may have dependencies again - the process
of object creation and preparation may be further nested.

In more abstract software engineering terms: `Dependency injection <https://en.wikipedia.org/wiki/Dependency_injection>`_
is a pattern used to delegate the task of resolving class dependencies away from a consumer
towards the underlying framework.

Back to history: After :php:`makeInstance()` has been around for quite a while and lacked an
implementation of dependency injection, Extbase appeared in 2009. Extbase brought a first container
and dependency injection solution, it's main interface being the Extbase :php:`ObjectManager`.
The Extbase object manager has been widely used for a long time, but suffered from some
issues younger approaches don't face. One of the main drawbacks of Extbase object manager
is the fact that it's based on runtime reflection: Whenever an object is to be instantiated,
the object manager scans the class for needed injections and prepares dependencies to be
injected. This process is quite slow though mitigated by various caches. And these also
come with costs. In the end, these issues have been the main reason the object manager
was never established as a main core concept but only lived in Extbase scope.

The object lifecycle and dependency injection solution based on Symfony DI has been
added in TYPO3v10 and is a general core concept: Next to the native
dependency injection, it is also wired into :php:`makeInstance()` as a long living
backwards compatibility solution, and it fully substitutes the Extbase object manager. In
contrast to the Extbase solution, Symfony based object management does *not* have the
overhead of
expensive runtime calculations. Instead it is an instance wide build-time solution: When
TYPO3 bootstraps, all object creation details of all classes are read from
a single cache file just once, and afterwards no expensive calculation is required
for actual creation.

Symfony based DI was implemented in TYPO3 v10 and usage of the Extbase
ObjectManager was discouraged. With TYPO3 v11 the core doesn't use the
ObjectManager any more. It is actively deprecated in v11 and thus leads to
'deprecation' level log entries.

With TYPO3 v12 the Extbase ObjectManager is actually gone. Making use of
Symfony DI integration still continues. There
are still various places in the core to be improved. Further streamlining will
be done over time. For instance, the final fate of :php:`makeInstance()`
and the :php:`SingletonInterface` has not fully been decided on yet. Various
tasks remain to be solved in younger TYPO3 developments to further improve the
*object lifecycle management* provided by the core.


Build-time caches
=================

To get a basic understanding of the core's lifecycle management it is helpful to
get a rough insight on the main construct. As already mentioned, *object lifecycle
management* is conceptualized as steps to take place at *build-time*.
It is done very early and only once during the TYPO3
bootstrap process. All calculated
information is written to a special cache that can not be reconfigured and is available
early. On subsequent requests the cache file is loaded.
Extensions can not mess with the construct if they adhere to the core API.

Besides being created early, the state of the container is independent and
exactly the same in *frontend*, *backend* and *CLI scope*. The same container instance may
even be used for multiple requests. This is becoming more and more important nowadays with the
core being able to execute sub requests. The only exception to this is the
*Install Tool*: It uses a more basic container that "cannot fail". This difference
is not important for extension developers however since they can't hook into the Install Tool
at those places anyways.

The Symfony container implementation is usually configured to actively scan the
extension classes for needed injections. All it takes are just a couple
of lines within the :file:`Services.yaml` file. This should be done within all extensions that
contain PHP classes and it is the fundamental setup we will outline in the following sections.

For developers, it is important to understand that dealing with Symfony DI is
an *early core bootstrap and cached* thing. The system will fail upon misconfiguration, leading
to unreachable frontend and backend.

.. attention::

   Errors in the DI configuration may block frontend and backend!

   The DI cache does not heal by itself but needs to be cleared manually!

With the container cache entry being a low level early bootstrap thing that is expensive
to calculate when it has to be rebuild, there is a limited list of options to flush
this cache:

*   The container cache entry is *not deleted* when a backend user clicks "Flush all caches"
    in the backend top toolbar if the instance is configured as :ref:`production <Environment-context>`
    application. For developer convenience, the container cache *is* flushed in development
    context, though.

*   The container cache *is* flushed using "Admin tools" -> "Maintenance" -> "Flush Caches"
    of the Install Tool.

*   The container cache *is* flushed using the CLI command :shell:`vendor/bin/typo3 cache:flush`. Using
    :shell:`vendor/bin/typo3 cache:warmup` afterwards will rebuild and cache the container.

*   The container cache is automatically flushed when using the Extension Manager to load
    or unload extensions in (non-Composer) classic mode.

*   Another way to quickly drop this cache during development is to remove all
    :file:`var/cache/code/di/*` files, which reside in :file:`typo3temp/` in classic mode
    instances or elsewhere in composer mode instances (see :ref:`Environment`).

The main takeaway is: When a developer fiddles with container configuration,
the cache needs to be manually cleared. And if some configuration issue slipped in,
which made the container or DI calculation fail, the system does *not* heal itself and
needs both a fix of the `Dependency injection <https://docs.typo3.org/permalink/t3coreapi:dependency-injection>`_ configuration plus probably a cache removal. The standalone Install
Tool however should *always* work, even if the backend breaks down, so the "Flush caches"
button is always reachable. Note that *if* the container calculation fails, the
:file:`var/log/typo3_*` files contain the exception with backtrace!


Important terms
===============

We will continue to use a couple of technical terms in this chapter, so let's quickly
define them to align. Some of them are not precisely used in our world, for
instance some Java devs may stumble upon "our" understanding of a prototype.

Prototype
   The broad understanding of a *prototype* within the TYPO3 community is
   that it's simply an object that is created anew every time. Basically the direct
   opposite of a *singleton*. In fact, the prototype pattern describes a base object that
   is created once, so :php:`__construct()` is called to set it up, after that it is
   cloned each time one wants to have a new instance of it. The community isn't well aware
   of that, and the core provides no "correct" prototype API, so the word *prototype* is
   often misused for an object that is always created anew when the framework is
   asked to create one.

Singleton
   A *singleton* is an object that is instantiated
   exactly once within one request. If an instance is requested and the object has been
   created once already, the same instance is returned. Codewise, this is sometimes done by
   implementing a static :php:`getInstance()` method that parks the instance in a property.
   In TYPO3, this can also be achieved by implementing the :php:`SingletonInterface`,
   where :php:`makeInstance()` then stores the object internally. Within containers, this can be done
   by declaring the object as shared (:yaml:`shared: true`), which is the default. We'll come back to
   details later. Singletons *must not* have state - they must act the same way each time
   they're used, no matter where, how often or when they've been used before. Otherwise the behavior of a singleton
   object is undefined and will lead to obscure errors.

Service
   This is another "not by the book" definition. We use the understanding
   "What is a service?" from Symfony: In Symfony, everything that is instantiated through
   the service container (both directly via :php:`$container->get()` and indirectly via DI)
   *is a service*. These are many things - for instance controllers are services, as well as
   - non static - utilities, repositories and obvious classes like mailers and similar. To emphasize:
   Not only classes named with a :php:`*Service` suffix are services but basically anything. It
   does not matter much if those services are stateless or not. Controllers, for instance,
   are usually *not* stateless. (This is just a configuration detail from this point of view.)
   Note: The TYPO3 Core does not strictly follow this behavior in all cases yet, but it strives
   to get this more clean over time.

Data object
  Data objects are the opposite of services. They are *not* available
  through service containers. Here calling :php:`$container->has()` returns :php:`false` and they can not be
  injected. They are instantiated either with :php:`new()` or :php:`GeneralUtility::makeInstance()`.
  Domain models or DTO are a typical example of data objects.

  *Note:* *Data objects* are *not* "service container aware"
  and do not support DI. Although the TYPO3 core does not strictly follow this rule in all cases
  until now the ambition is to get this done over time.


.. _supported-ways-of-dependency-injection:
.. _Using-DI:

Using DI
========

Now that we have a general understanding of what a service and what a data
object is, let's turn to usages of services. We will mostly use examples for
this.

*The general rule is:* Whenever your class has a service dependency to another class,
one of the following solutions should be used.


When to use Dependency Injection in TYPO3
-----------------------------------------

Class dependencies to services should be injected via constructor injection or
setter methods. Where possible, Symfony dependency injection should be used for
all cases where DI is required.
Non-service "data objects" like Extbase domain model instances or DTOs should
be instantiated via :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`
if they are non-final and support XCLASSing. For final classes without
dependencies plain instantiation via the `new` keyword must be used.

In some APIs dependency injection cannot be used yet. This applies to classes that need
specific data in their constructors or classes that are serialized and deserialized as, for
example, scheduler tasks.

When dependency injection cannot be used directly yet, create a service class and make it public
in the  :file:`Configuration/Services.yaml`. Create an instance of the service class via
:php:`GeneralUtility::makeInstance(...)` you can then use dependency injection in the service class.


.. _Constructor-injection:

Constructor injection
---------------------

Assume we're writing a controller that renders a list of users. Those users are
found using a custom :php:`UserRepository`, so the repository service is a direct dependency of the
controller service. A typical constructor dependency injection to resolve the
dependency by the framework looks like this:

..  literalinclude:: _ConstructorInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

Here the Symfony container sees a dependency to :php:`UserRepository` when scanning :php:`__construct()`
of the :php:`UserController`. Since autowiring is enabled by default (more on that below), an instance of the
:php:`UserRepository` is created and provided when the controller is created. The example uses `constructor
property promotion <https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion>`__
and sets the property :php:`readonly`, so it can not be written a second time.


.. _Method-injection:

Method injection
----------------

A second way to get services injected is by using :php:`inject*()` methods:

..  literalinclude:: _MethodInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

This ends up with the basically the same result as above: The controller instance has
an object of type :php:`UserRepository` in class property :php:`$userRepository`.
The injection via methods was introduced by Extbase and TYPO3 core implemented it in addition to
the default Symfony constructor injection. Why did we do that, you may ask? Both
strategies have subtle differences: First, when using :php:`inject*()` methods, the type
hinted class property needs to be nullable, otherwise PHP >= 7.4 throws a warning
since the instance is not set during :php:`__construct()`. But that's just an
implementation detail. More important is an abstraction scenario. Consider this case:

..  literalinclude:: _MethodInjectionWithAbstract.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

We have an abstract controller service with a dependency plus a controller service that extends
the abstract and has further dependencies.

Now assume the abstract class is provided by TYPO3 core and the consuming class
is provided by an extension. If the abstract class would use constructor injection,
the consuming class would need to know the dependencies of the abstract, add its
own dependency to the constructor, and then call :php:`parent::__construct($logger)` to
satisfy the dependency of the abstract. This would hardcode all dependencies
of the abstract into extending classes. If later the abstract is changed and
another dependency is added to the constructor, this would break consuming
classes since they did not know that.

*Differently put:* When core classes "pollute" :php:`__construct()` with dependencies,
the core can not add dependencies without being breaking. This is the reason why
for example the extbase :php:`AbstractController` uses :php:`inject*()` methods for its
dependencies: Extending classes can then use constructor injection, do not need
to call :php:`parent::__construct()`, and the core is free to change dependencies of
the abstract.

In general, when the core provides abstract classes that are expected to be
extended by extensions, the abstract class should use :php:`inject*()` methods instead of
constructor injection. Extensions of course can follow this idea in similar
scenarios.

This construct has some further implications: Abstract classes should
think about making their dependency properties :php:`private`, so extending classes
can not rely on them. Furthermore, classes that should *not* be extended by extensions
are free to use constructor injection and *should* be marked :php:`final`, making
sure they can't be extended to allow internal changes.

As a last note on method injection, there is another way to do it: It is possible
to use a :php:`setFooDependency()` method if it has the annotation :php:`@required`.
This second way of method injection however is not used within the TYPO3
framework, should be avoided in general, and is just mentioned here for completeness.


.. _interface-injection:

Interface injection
-------------------

Apart from constructor injection and :php:`inject*()` method injection, there is another
useful dependency injection scenario. Look at this example:

..  literalinclude:: _InterfaceInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

See the difference? We're requesting the injection of an interface and not a class!
It works for both constructor and method injection. It forces the service container
to look up which specific class is configured as implementation of the interface and
inject an instance of it. This is the true heart of dependency injection: A consuming
class no longer codes on a specific implementation, but on the signature of the interface.
The framework makes sure something is injected that satisfies the interface,
the consuming class does not care, it just knows about the interface methods. An
instance administrator can decide to configure the framework to inject some
different implementation than the default, and that's fully transparent
for consuming classes.

Here's an example scenario that demonstrates how you can define the specific
implementations that shall be used for an interface type hint:

..  literalinclude:: _MyController.php
    :language: php
    :caption: EXT:my_extension/Controller/MyController.php

..  literalinclude:: _MySecondController.php
    :language: php
    :caption: EXT:my_extension/Controller/MySecondController.php

..  literalinclude:: _MyThirdController.php
    :language: php
    :caption: EXT:my_extension/Controller/MyThirdController.php

..  literalinclude:: _ServicesWithInterfaceInjection.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml


Using container->get()
======================

[WIP] Service containers provide two methods to obtain objects, first via :php:`$container->get()`,
and via DI. This is only available for services itself: Classes that are registered
as a service via configuration can use injection or :php:`$container->get()`. DI is
supported in two ways: As constructor injection, and as :php:`inject*()` method injection.
They lead to the same result, but have subtle differences. More on that later.

In general, services should use DI (constructor or method injection) to obtain dependencies.
This is what you'll most often find when looking at core implementations. However, it
is also possible to *get the container injected* and then use :php:`$container->get()`
to instantiate services. This is useful for factory-like services where the exact name of classes is determined at runtime.


.. _configure-dependency-injection-in-extensions:
.. _dependency-injection-Configuration:

Configuration
=============

..  _dependency-injection-in-extensions:

Configure dependency injection in extensions
--------------------------------------------

Extensions have to configure their classes to make use of the
dependency injection. This can be done in :file:`Configuration/Services.yaml`.
Alternatively, :file:`Configuration/Services.php` can also be used.
A basic :file:`Services.yaml` file of an extension looks like the following.

..  note::
    Whenever the service configuration or class dependencies change, the Core
    cache must be flushed in the :guilabel:`Admin Tools > Maintenance` or via the :ref:`CLI <cli-mode>`
    command `cache:flush` to rebuild the compiled Symfony container. Flushing
    all caches from the :guilabel:`Clear cache` menu does not flush the compiled Symfony
    container.

..  literalinclude:: _Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml


.. _dependency-injection-autowire:

autowire
    :yaml:`autowire: true` instructs the dependency injection component to
    calculate the required dependencies from type declarations. This works for
    constructor injection and :php:`inject*()` methods. The calculation
    generates a service initialization code which is cached in the TYPO3 Core
    cache.

    ..  attention::
        An extension does not have to use autowiring, but can wire
        dependencies manually in the service configuration file.

.. _dependency-injection-autoconfigure:

autoconfigure
    It is suggested to enable :yaml:`autoconfigure: true` as this
    automatically adds Symfony service tags based on implemented interfaces or
    base classes. For example, autoconfiguration ensures that classes
    implementing :php:`\TYPO3\CMS\Core\SingletonInterface` are publicly
    available from the Symfony container and marked as shared
    (:yaml:`shared: true`).

Model exclusion
    The path exclusion :yaml:`exclude: '../Classes/Domain/Model/*'` excludes
    your models from the dependency injection container, which means you cannot inject them
    nor inject dependencies into them. Models are not services and therefore
    should not require dependency injection. Also, these objects are created by
    the Extbase persistence layer, which does not support the DI container.


.. _DependencyInjectionArguments:

Arguments
---------

In case you turned off :yaml:`autowire` or need special arguments, you can
configure those as well. This means that you can set :yaml:`autowire: false` for
an extension, but provide the required arguments via config specifically for
the desired classes. This can be done in chronological order or by naming.

..  literalinclude:: _ServicesWithoutAutowire.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

This allows you to inject concrete objects like the :ref:`Connection
<database-connection>`:

..  literalinclude:: _ServicesWithConnection.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Now you can access the :php:`Connection` instance within :php:`ClassA`. This
allows you to execute your queries without further instantiation. For example,
this method of injecting objects also works with extension configurations and
with TypoScript settings.


Public
------

:yaml:`public: false` is a performance optimization and should therefore be set
in extensions. This settings controls which services are available through the
dependency injection container used internally by
:php:`GeneralUtility::makeInstance()`. However, some classes that need to be
public are automatically marked as public due to :yaml:`autoconfigure: true`
being set. These classes include singletons, as they must be shared with code
that uses :php:`GeneralUtility::makeInstance()` and :ref:`Extbase controllers
<extbase-controller>`.


.. index:: Dependency injection; Public
.. _knowing-what-to-make-public:
.. _What-to-make-public:

What to make public
-------------------

Every class that is instantiated using :php:`GeneralUtility::makeInstance()`
**and** requires dependency injection must be marked as public. The same goes
for instantiation via :php:`GeneralUtility::makeInstance()` using constructor
arguments.

Any other class which requires dependency injection and is retrieved by
dependency injection itself can be private.

Instances of :php:`\TYPO3\CMS\Core\SingletonInterface` and Extbase controllers
are automatically marked as public. This allows them to be retrieved using
:php:`GeneralUtility::makeInstance()` as done by TYPO3 internally.

More examples of classes that must be marked as public:

*   :ref:`User functions <t3tsref:cobj-user-int>`
*   Non-Extbase controllers
*   Classes registered in :ref:`hooks <hooks-general>`
*   :ref:`Authentication services <authentication>`
*   :ref:`Fluid data processors <content-elements-custom-data-processor>`
    (only necessary if not tagged as
    :ref:`data.processor <content-elements-custom-data-processor_alias>`).

For such classes, an extension can override the global configuration
:yaml:`public: false` in :file:`Configuration/Services.yaml` for each affected
class:

..  literalinclude:: _ServicesWithPublic.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

With this configuration, you can use dependency injection in
:php:`\MyVendor\MyExtension\UserFunction\ClassA` when it is created, for example
in the context of a :typoscript:`USER` TypoScript object, which would not be
possible if this class were private.

..  seealso::
    Symfony: `How to Create Service Aliases and Mark Services as Private <https://symfony.com/doc/current/service_container/alias_private.html>`_

.. index:: Dependency injection; Errors
.. _errors-resulting-from-wrong-configuration:

Errors resulting from wrong configuration
-----------------------------------------

If objects that use dependency injection are not configured properly, one or
more of the following issues may result. In such a case, check whether the
class has to be configured as :yaml:`public: true`.

:php:`ArgumentCountError` is raised on missing dependency injection for
:ref:`constructor-injection`:

..  code-block:: text

    (1/1) ArgumentCountError

    Too few arguments to function MyVendor\MyExtension\Namespace\Class::__construct(),
    0 passed in typo3/sysext/core/Classes/Utility/GeneralUtility.php on line 3461 and exactly 1 expected

An :php:`Error` is thrown on missing dependency injection for
:ref:`method-injection`, once the dependency is used within the code:

..  code-block:: text

    (1/1) Error

    Call to a member function methodName() on null

.. index:: Dependency injection; Installation-wide configuration
.. _dependency-injection-installation-wide:

Installation-wide configuration
-------------------------------

One can set up a global service configuration for a project that can be used in
multiple project-specific extensions. For example, this way you can alias an
interface with a concrete implementation that can be used in several extensions.
It is also possible to register project-specific :ref:`CLI commands
<symfony-console-commands>` without requiring a project-specific extension.

However, this only works - due to security restrictions - if TYPO3 is configured
in a way that the project root is outside the document root, which is usually
the case in Composer-based installations.

The global service configuration files :file:`services.yaml` and
:file:`services.php` are now read within the :file:`config/system/` path
of a TYPO3 project in Composer-based installations.

**Example:**

You want to use the PSR-20 clock interface as a type hint for dependency
injection in the service classes of your project's various extensions. Then the
concrete implementation may change without touching your code. In this example,
we use `lcobucci/clock` for the concrete implementation.

..  literalinclude:: _servicesInstallationWide.php
    :language: php
    :caption: config/system/services.php

The concrete clock implementation is now injected when a type hint to the
interface is given:

..  literalinclude:: _MyClass.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php


User functions and their restrictions
-------------------------------------

It is possible to use dependency injection when calling custom user functions,
for example :ref:`.userFunc within TypoScript <t3tsref:cobj-user-properties>` or
:ref:`in (legacy) hooks <hooks-general>`, usually via
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`.

This method :php:`callUserFunction()` internally uses the dependency-injection-aware
helper :php:`GeneralUtility::makeInstance()`, which can recognize and inject
classes/services that are marked public.

..  attention::

    The backend module :guilabel:`Admin Tools > Extensions > Configuration` is also
    able to specify user functions for input options provided via an
    :file:`ext_conf_template.txt` (see :ref:`extension-configuration`).

    However, this backend module is executed in a special low-level context
    that disables some functionality for failsafe-reasons. Specifically,
    this prevents dependency injection from being used in this scenario.

    If you need to utilize services and other classes inside user functions
    that are called there, you need to perform custom :php:`GeneralUtility::makeInstance()`
    calls inside your own user function method to initialize those needed classes/services.

Dependency injection in a XCLASSed class
----------------------------------------

When extending an existing class (for example, an Extbase controller) using
:ref:`XCLASS <xclasses>` and injecting additional dependencies using constructor
injection, ensure that a reference to the extended class is added in the
:file:`Configuration/Services.yaml` file of the extending extension, as shown in
the example below:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    TYPO3\CMS\Belog\Controller\BackendLogController: '@MyVendor\MyExtension\Controller\ExtendedBackendLogController'


Further information
-------------------

.. rst-class:: compact-list

*  `Symfony dependency injection component <https://symfony.com/doc/current/components/dependency_injection.html>`_

*  `Symfony service container <https://symfony.com/doc/current/service_container.html>`_

*  `Dependency Injection in TYPO3 - Blog Article by Daniel Goerz <https://usetypo3.com/dependency-injection.html>`_

*  `Dependency Injection <https://phptherightway.com/#dependency_injection>`__ in "PHP The Right Way"

*  `What is dependency injection?
   <http://fabien.potencier.org/what-is-dependency-injection.html>`__
   by Fabien Potencier
