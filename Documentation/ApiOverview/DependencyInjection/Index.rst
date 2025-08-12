.. include:: /Includes.rst.txt
.. index::
   !Dependency injection
   pair: Dependency injection; Extensions
   pair: Dependency injection; Services
   File; EXT:{extkey}/Configuration/Services.yaml
   File; EXT:{extkey}/Configuration/Services.php
   File; config/system/services.yaml
   File; config/system/services.php

.. _DependencyInjection:
.. _Dependency-Injection:

====================
Dependency injection
====================


.. rst-class:: compact-list
.. contents:: Overview of page contents
   :local:


Abstract
========

This chapter explains "Dependency Injection (DI)" *as used in TYPO3.* Readers
interested in the general concepts and principles may want to look at, for
example, `Dependency Injection
<https://phptherightway.com/#dependency_injection>`__ in "PHP The Right Way" and
`What is dependency injection?
<http://fabien.potencier.org/what-is-dependency-injection.html>`__ by Fabien
Potencier. Whenever a :ref:`service <cgl-services>` has a *service dependency* to another
class, the technique of *dependency injection* should be used to satisfy that need. TYPO3
uses a Symfony component for dependency injection. The component is `PSR-11
<https://www.php-fig.org/psr/psr-11/>`_ compliant, and is used throughout
core and extensions to standardize the process of obtaining service dependencies.

By default all API services shipped with the TYPO3 Core system extensions offer dependency
injection. The recommended usage is :ref:`constructor injection
<Constructor-injection>`. Available as well are :ref:`method injection
<Method-injection>` and :ref:`interface injection <Interface-injection>`.
To activate the Symfony component for dependency injection a few lines of
:ref:`configuration <Configuration>` are necessary.


Introduction
============

The title of this chapter is "dependency injection" (DI), but the scope is a bit
broader: In general, this chapter is about *TYPO3 object lifecycle management* and
*how to obtain services*, with one sub-part of it being dependency injection.

The underlying interfaces are based on the PHP-FIG (PHP Framework Interop Group) standard
`PSR-11 Container interface <https://www.php-fig.org/psr/psr-11/>`_, and the
implementation is based on `Symfony service container <https://symfony.com/doc/current/service_container.html>`_
and `Symfony dependency injection <https://symfony.com/doc/current/components/dependency_injection.html>`_ components,
plus some TYPO3 specific sugar.


Background and history
======================

Obtaining object instances in TYPO3 has always been straightforward: Call
:php:`GeneralUtility::makeInstance(\MyVendor\MyExtension\Some\Class::class)` and hand over
mandatory and optional :php:`__construct()` arguments as additional arguments.

There are two quirks to that:

* First, a class instantiated through :php:`GeneralUtility::makeInstance()` can implement
  :php:`SingletonInterface`. This empty interface definition tells makeInstance() to instantiate
  the object exactly once for this request, and if another makeInstance() call asks for it,
  *the same object instance* is returned - otherwise makeInstance() always creates a new object
  instance and returns it. Implementing :ref:`SingletonInterface <cgl-singletons>` is nowadays
  considered old-fashioned, its usage should be reduced over time.

* Second, :php:`GeneralUtility::makeInstance()` allows :ref:`"XCLASSing" <xclasses>`. This is a - rather dirty -
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
this is an important operation, the class wants to log an information like "I just created a user".
And this is where dependency injection enters the game: Logging is a huge topic, there are
various error levels, information can be written to various destinations and so on. The
little class does not want to deal with all those details, it just wants to tell the framework: "Please
give me some logger I can use and that takes care of all details, I don't want to know about them". This
separation is the heart of *single responsibility* and *separation of concerns*.

Dependency injection does two things for us here: First, it allows separating concerns, and second,
it hands the task of finding an appropriate implementation of a dependency over to the framework,
so the framework decides - based on configuration - which specific instance is given to the
consumer. Note in our example, the logging instance itself may have dependencies again - the process
of object creation and preparation may be nested.

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
ObjectManager was discouraged.

The Extbase ObjectManager has been removed with TYPO3 v12. Making use of
Symfony DI integration continues. There
are still various places in the core to be improved. Further streamlining is
done over time. For instance, the final fate of :php:`makeInstance()`
and the :php:`SingletonInterface` has not fully been decided on. Various
tasks remain to be solved in younger TYPO3 development to further improve the
*object lifecycle management* provided by the core.


..  _dependency-injection-caches:

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
at those places.

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
needs both a fix of the `Dependency injection <https://docs.typo3.org/permalink/t3coreapi:dependency-injection>`_
configuration plus probably a cache removal. The standalone Install
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
   A *singleton* is an object that is instantiated exactly once within one request, with
   the same instance being re-used when a class instance is requested. Symfony understands
   such class instances as being "shared". TYPO3 can also declare a class as "shared" using the
   :php-short:`\TYPO3\CMS\Core\SingletonInterface`, but this is considered
   :ref:`old-fashioned <cgl-singletons>`. Services are usually declared shared by default.
   This implies such classes should be stateless and there is trouble ahead when they are not.

Service
   We use the understanding "What is a :ref:`service? <cgl-services>`" from Symfony: In Symfony, everything
   that is instantiated through the service container *is a service*. These are many things - for instance
   controllers are services, as well as - non static - utilities, repositories and classes like mailers
   and similar. To emphasize: Not only classes named with a :php:`*Service` suffix are services but basically
   anything as long as it is not a data object. A class should represent either-or: A class is either
   a service that manipulates or does something with given data and does not hold it, or is a class that
   holds data. Sadly, this distinction is not always the case within TYPO3 core (yet), and there are
   many classes that blend service functionality and data characteristics.

Data object
  Data objects are the opposite of services. They are *not* available
  through service containers. Calling :php:`$container->has()` returns :php:`false` and they can not be
  injected. They should be instantiated using :php:`new()`. Domain models and DTOs are a typical example
  of data objects. *Data objects* are *not* "service container aware" and do not support DI. Although the
  TYPO3 core does not strictly follow this rule in all cases until now, the ambition is to get this done
  over time.


.. _supported-ways-of-dependency-injection:
.. _Using-DI:

Using DI
========

The general idea is: Whenever your service class has a service dependency to another class,
dependency injection should be used.

In some TYPO3 APIs dependency injection cannot be used yet. This applies to classes that need
specific data in their constructors or classes that are serialized and deserialized as, for
example, scheduler tasks. The TYPO3 core tries to refactor these cases over time. Such classes
need to fall back to old-school :php:`GeneralUtility::makeInstance()`

There are two ways proclaimed and natively supported by TYPO3 to obtain service dependencies:
Constructor injection using :php:`__construct()` and method injection using
:php:`inject*()` methods. Constructor injection is the way to go as long as a class
is not dealing with complex abstract inheritance chains. The symfony service container
can inject specific classes as well as instances of interfaces.

.. _Constructor-injection:

Constructor injection
---------------------

Lets say we're writing a controller that renders a list of users. Those users are
found using a :php:`UserRepository` service, making the user repository service a
direct dependency of the controller service. A typical constructor dependency injection
to resolve the dependency by the framework looks like this:

..  literalinclude:: _ConstructorInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

The symfony container setup process will now see :php:`UserRepository` as a dependency
of :php:`UserController` when scanning its :php:`__construct()` method. Since autowiring
is enabled by default (more on that below), an instance of the :php:`UserRepository` is
created and provided to :php:`__construct()` when the controller is created. The instance
is set as a class property using `constructor
property promotion <https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion>`__
and the property is declared :php:`readonly`.


.. _Method-injection:

Method injection
----------------

A second way to get services injected is by using :php:`inject*()` methods:

..  literalinclude:: _MethodInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

This ends up with basically the same result as above: The controller instance retrieves
an object of type :php:`UserRepository` in class property :php:`$userRepository`. The service
container calls such :php:`inject*()` methods directly after class instantiation, so *after*
:php:`__construct()` has been executed, and before anything else.
The injection via methods was introduced by Extbase. TYPO3 core implemented it in addition to
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
own dependencies to the constructor, and then call :php:`parent::__construct($logger)` to
satisfy the abstracts dependency. This would hardcode all dependencies
of the abstract into extending classes. If later the abstract is changed and
another dependency is added to the constructor, this would break consuming
classes.

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

.. _interface-injection:

Interface injection
-------------------

..  literalinclude:: _InterfaceInjection.php
    :language: php
    :caption: EXT:my_extension/Controller/UserController.php

Notice the difference? The code requests the injection of an interface and not a class!
This is permissible with both constructor and method injection. It compels the
service container to determine which specific class is configured as the
implementation of the interface and inject an instance of that class. A class
can declare itself as the default implementation of such an interface. This is
the essence of dependency injection: a consuming class no longer relies on a
specific implementation but on an interface's signature.

The framework ensures that something fulfilling the interface is injected. The
consuming class remains unaware of the specific implementation, focusing solely
on the interface methods. An instance administrator can configure the framework
to inject a different implementation, either globally or for specific classes.
The consumer remains unconcerned, interacting only with the interface methods.

The example below has a couple of controller classes as service consumers. There
is a service interface with a default implementation. The default implementation
uses the symfony PHP attribute :php:`AsAlias` to register itself as default.
A :file:`Services.yaml` file configures different service implementation for
some service consumers:

..  literalinclude:: _MyFirstController.php
    :language: php
    :caption: EXT:my_extension/Controller/MyFirstController.php

..  literalinclude:: _MySecondController.php
    :language: php
    :caption: EXT:my_extension/Controller/MySecondController.php

..  literalinclude:: _MyThirdController.php
    :language: php
    :caption: EXT:my_extension/Controller/MyThirdController.php

..  literalinclude:: _MyServiceInterface.php
    :language: php
    :caption: EXT:my_extension/Service/MyServiceInterface.php

..  literalinclude:: _MyDefaultServiceImplementation.php
    :language: php
    :caption: EXT:my_extension/Service/MyDefaultServiceImplementation.php

..  literalinclude:: _MyOtherServiceImplementation.php
    :language: php
    :caption: EXT:my_extension/Service/MyOtherServiceImplementation.php

..  literalinclude:: _ServicesYamlUsingInterfaceInjection.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml


.. _configure-dependency-injection-in-extensions:
.. _dependency-injection-Configuration:

Configuration
=============

..  _dependency-injection-in-extensions:

:file:`Services.yaml` declaring service defaults
------------------------------------------------

Extensions have to configure their classes to make use of
dependency injection. This can be done in :file:`Configuration/Services.yaml`.
Alternatively, :file:`Configuration/Services.php` can also be used, if
PHP syntax is required to apply conditional logic to definitions.
A basic :file:`Services.yaml` file of an extension looks like the following.

..  note::
    Whenever the service configuration or class dependencies change, the Core
    cache must be flushed, see :ref:`above <dependency-injection-caches>` for details.

..  literalinclude:: _ServicesYamlDefaults.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml


autowire
    :yaml:`autowire: true` instructs the dependency injection component to
    calculate the required dependencies from type declarations. The calculation
    generates service initialization code.

    An extension is not required to use autowiring. It can manually wire
    dependencies. However, opting out of autowiring is less convenient and is not
    further documented in this guide.

autoconfigure
    This directive instructs the dependency injection component to automatically add
    Symfony service tags based on implemented interfaces and base classes. For instance,
    autoconfiguration ensures that classes implementing
    :php-short:`\TYPO3\CMS\Core\SingletonInterface` are publicly available from
    the Symfony container and marked as shared (:yaml:`shared: true`).

    TYPO3 dependency injection relies on this this for various default configurations.
    It is recommended to set :yaml:`autoconfigure: true`.

public
    :yaml:`public: false` is a performance optimization and should therefore be set
    in extensions. This settings controls which services are available through the
    dependency injection container used internally by :php:`GeneralUtility::makeInstance()`.
    See :ref:`"What to make public?" <What-to-make-public>` for more information.

Model exclusion
    The path exclusion :yaml:`exclude: '../Classes/Domain/Model/*'` excludes
    your models from the dependency injection container: You cannot inject them
    nor inject dependencies into them. Models are not services but data objects
    and therefore should not require dependency injection. Also, these objects are
    usually created by the Extbase persistence layer, which does not support the
    DI container.

.. _dependency-injection-autoconfigure:

Autoconfiguration using attributes and :file:`Services.yaml`
------------------------------------------------------------

Single service classes may need to change auto configuration
to be different than above declared defaults. This can be done using PHP attributes.
The most common use case is :php:`public: true`:

..  literalinclude:: _MyServiceUsingAutoconfigurePublicTrue.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceUsingAutoconfigurePublicTrue.php

The above usage of the :php:`Autoconfigure` attribute declares this service as
:php:`public: true` which overrides a :yaml:`public: false` default from a
:php:`Services.yaml` file for this specific class.

Similar with :php:`shared: false`:

..  literalinclude:: _MyServiceUsingAutoconfigureSharedFalse.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceUsingAutoconfigureSharedFalse.php

It is possible to set both using :php:`#[Autoconfigure(public: true, shared: false)]`.

The :php:`Autoconfigure` attribute is beneficial when an extension includes a
service class that is either stateful or instantiated using
:php:`GeneralUtility::makeInstance()`. This attribute embeds the configuration
directly within the class file, eliminating the need for additional entries in
:file:`Services.yaml` - the configuration is "in place".

To reconfigure "foreign" services - those not provided by the extension itself
but by another extension (such as a service class from ext:core) -  the
:file:`Services.yaml` file can be utilized. A common scenario is when a core
service is not declared public because all core extensions retrieve instances
via constructor or method injection, rather than
:php:`GeneralUtility::makeInstance()`. If an extension must use
:php:`GeneralUtility::makeInstance()` for a specific reason, it can declare
the "foreign" service as "public" in :file:`Services.yaml`:

..  literalinclude:: _ServicesYamlDeclaringForeignServicePublicTrue.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml


.. _dependency-injection-autowire:
.. _DependencyInjectionArguments:

Autowiring using attributes
---------------------------

Autowiring, particularly the :php:`Autowire` PHP attribute, is a powerful tool
for making dependency injection more convenient and transparent. TYPO3 core
includes default configurations that facilitate its use. Let’s explore some
examples.

Consider a service performing an expensive operation that caches the result
within the TYPO3 runtime cache to avoid repeating the operation within the same
request. The runtime cache, being a dependent service, should be injected. A
naive approach is to inject the core :php:`CacheManager` and retrieve the
runtime cache instance:

..  literalinclude:: _MyServiceUsingCacheManager.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceUsingCacheManager.php

This can be simplified, resulting in more streamlined code:

..  literalinclude:: _MyServiceGettingRuntimeCacheInjected.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceGettingRuntimeCacheInjected.php

The "cache.runtime" service alias, configured by the TYPO3 core extension,
performs the :php:`CacheManager->getCache()` operation behind the scenes.
Utilizing such shortcuts simplifies the consumers.

The autowire attribute also enables the execution of expressions and injection
of the results, which is useful for "compile-time" state that remains constant
during requests. For example, to inject a feature toggle status:

..  literalinclude:: _MyServiceGettingFeatureToggleResultInjected.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceGettingFeatureToggleResultInjected.php

Another example, including alias definition, is new in TYPO3 v13. It enables
injecting values from :file:`ext_conf_templates.txt` files using the
:php:`ExtensionConfiguration` API.

..  literalinclude:: _CoreExtensionConfiguration.php
    :language: php
    :caption: EXT:core/Configuration/ExtensionConfiguration.php

..  literalinclude:: _MyServiceGettingExtensionConfigurationValueInjected.php
    :language: php
    :caption: EXT:my_extension/Services/MyServiceGettingExtensionConfigurationValueInjected.php

This example demonstrates the combination of a service class with an alias and
a consumer utilizing this alias in an :php:`Autowire` attribute.

The TYPO3 core provides a couple such service aliases, with the above ones being
the most important ones for extension developers. TYPO3 core does
:ref:`not arbitrarily add <service-aliases>` aliases.


.. _dependency-injection-installation-wide:

Installation-wide configuration
-------------------------------

A global service configuration for a project can be set up to be utilized across
multiple project-specific extensions. This allows, for example, the aliasing of
an interface with a concrete implementation that can be used in several
extensions. Additionally, project-specific :ref:`CLI commands
<symfony-console-commands>` can be registered without the need for a
project-specific extension.

However, this is only possible - due to security restrictions - if TYPO3 is
configured such that the project root is outside the document root, which is
typically the case in Composer-based installations.

In Composer-based installations, the global service configuration files
:file:`services.yaml` and :file:`services.php` are located within the
:file:`config/system/` directory of a TYPO3 project.

Consider the following scenario: You want to use the PSR-20 clock interface as
a type hint for dependency injection in the service classes of your project's
various extensions. This setup allows the concrete implementation to change
without altering your code. In this example, we use `lcobucci/clock` as the
concrete implementation.

The global files :file:`services.yaml` and :file:`services.php` are read *before*
files from extensions. The global files can provide defaults but can not override
service definitions from service configuration files loaded afterwards.

..  literalinclude:: _ServicesYamlInstallationWide.yaml
    :language: yaml
    :caption: config/system/services.yaml

The concrete clock implementation is now injected when a type hint to the
interface is given:

..  literalinclude:: _MyServiceUsingClockInterface.php
    :language: php
    :caption: EXT:my_extension/Classes/MyServiceUsingClockInterface.php


FAQ
===

.. _knowing-what-to-make-public:
.. _What-to-make-public:
.. _errors-resulting-from-wrong-configuration:

What to make public?
--------------------

..  attention::
    **In short**: "Manually" instantiated services using
    :php:`GeneralUtility::makeInstance(MyService::class)` must be made
    public.

The basic difference between public and private is well explained in the
`symfony documentation <https://symfony.com/doc/current/service_container/alias_private.html>`_:

    When defining a service, it can be made to be public or private. If a service is
    public, it means that you can access it directly from the container at runtime.
    For example, the doctrine service is a public service:

    .. code-block:: php

        // only public services can be accessed in this way
        $doctrine = $container->get('doctrine');

    But typically, services are accessed using dependency injection. And in this case,
    those services do not need to be public.

    So unless you specifically need to access a service directly from the container
    via :php:`$container->get()`, the best-practice is to make your services private.

The implementation of :php:`GeneralUtility::makeInstance()` utilizes :php:`$container->get()`.
As a result, services instantiated using :php:`makeInstance()`
:ref:`must be declared public <dependency-injection-autoconfigure>` if they have
dependencies that need to be injected.

Services without dependencies can be instantiated using :php:`makeInstance()` without
the service made public, as they are instantiated using :php:`new` without constructor
arguments.

Some services are automatically declared public by basic TYPO3 dependency injection
configuration since they are instantiated using :php:`makeInstance()` by the core
framework. The most common ones are:

*   Extbase controllers implementing :php-short:`TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface`,
    usually by inheriting :php-short:`TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. They are
    additionally declared :php:`shared: false`.

*   Backend controllers with :php-short:`TYPO3\CMS\Backend\Attribute\AsController` class attribute.
    They are additionally declared :php:`shared: false`:

    .. code-block:: php

        use TYPO3\CMS\Backend\Attribute\AsController;

        #[AsController]
        final readonly class MyBackendController
        {
            // implementation
        }

*   Classes implementing :php-short:`TYPO3\CMS\Core\SingletonInterface`

*   Fluid view helpers implementing :php-short:`TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInterface`.
    They are additionally declared :php:`shared: false`.

*   :ref:`Fluid data processors <content-elements-custom-data-processor>`
    tagged with :ref:`data.processor <content-elements-custom-data-processor_alias>`.

Examples of classes that must be made public:

*   :ref:`User functions <t3tsref:cobj-user-int>`
*   :ref:`Hooks <hooks-general>`
*   :ref:`Authentication services <authentication>`


Services that use dependency injection and are not declared public typically error
out with typical messages when instantiated using :php:`makeInstance()` They should
be declared public:

..  code-block:: text
    :caption: Unsatisfied constructor injection

    (1/1) ArgumentCountError

    Too few arguments to function MyVendor\MyExtension\Namespace\Class::__construct(),
    0 passed in typo3/sysext/core/Classes/Utility/GeneralUtility.php on line 3461 and exactly 1 expected

..  code-block:: text
    :caption: Unsatisfied method injection

    (1/1) Error

    Call to a member function methodName() on null

..  dependency-injection-override-service-arguments:

How to override service arguments?
----------------------------------

Some services in the TYPO3 core use service arguments, which can be overridden by third-party extensions.
For example, the :php:`$rateLimiterFactory` argument in the :php-short:`\TYPO3\CMS\FrontendLogin\ControllerPasswordRecoveryController` of the
:composer:`typo3/cms-felogin` extension  uses a service with the ID :yaml:`feloginPasswordRecovery.rateLimiterFactory`.
This service is defined in the :php:`Services.yaml` file of :php:`ext:felogin` and includes a service
argument named :php:`$config`, which specifies the configuration for the Symfony Rate Limiter used in
the class.

A third-party extension can override the :php:`feloginPasswordRecovery.rateLimiterFactory` service in
its own :file:`Services.yaml` file, as shown in the example below:

..  code-block:: yaml
    :caption: packages/my-extension/Configuration/Services.yaml

    feloginPasswordRecovery.rateLimiterFactory:
      class: Symfony\Component\RateLimiter\RateLimiterFactory
      arguments:
        $config:
          id: 'felogin-password-recovery'
          policy: 'sliding_window'
          limit: 10
          interval: '30 minutes'
        $storage: '@storage.cachingFramework'

It is important that the 3rd party extension is loaded **after** the extension whose service it overrides.
This can be achieved by requiring the original extension as a dependency in the :file:`packages/my-extension/composer.json` file
of the 3rd party extension.


What do declare :php:`shared: false`?
-------------------------------------

..  attention::
    **In short**: Declare a service :php:`shared: false` if it is stateful.

A service declared :php:`shared: false` is not a singleton. Instead, a new instance
is created each time the consuming service is instantiated. This approach makes the
consuming service stateful as well, but declaring :php:`shared: false` can help
mitigate side effects between different services. It is often preferable to create
stateful services using :php:`GeneralUtility::makeInstance()` when needed, rather
than within :php:`__construct()`.

.. _when-to-use-php-generalutility-makeinstance:
When to use :php:`GeneralUtility::makeInstance()`?
--------------------------------------------------

..  attention::
    **In short**: Use :php:`GeneralUtility::makeInstance()` to obtain instances of stateful
    services within otherwise stateless services.

Ideally, all :ref:`services <cgl-services>` in a framework are stateless: They depend
on other stateless services and are always retrieved using dependency injection.

TYPO3 core development is gradually transitioning more services to be stateless.
However, many historically stateful services still exist. The critical point is that
injecting a stateful service into a stateless service makes the consumer stateful as
well. This can create a chain of coupled stateful services, leading to unexpected
results when these services are reused multiple times within a single request. While
declaring a service :php:`shared: false` can mitigate the issue, it doesn't solve the
underlying problem. This scenario is a primary use case for
:php:`GeneralUtility::makeInstance()`. Instead of injecting a stateful service at
service build time and reusing it frequently, the service can use
:php:`makeInstance()` at runtime when it needs a service instance.

For instance, the :php-short:`TYPO3\CMS\Core\DataHandling\DataHandler` class should
create new instances for each use, as it becomes "tainted" after use and cannot reset
its state properly. Such "dirty-after-use" services should be instantiated anew with
:php:`makeInstance()` when needed.

Some services are stateful but provide workarounds to be injectable. A good example
is the Extbase :php-short:`TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder`. It is
stateful due to its use of the method chaining pattern but includes a :php:`reset()`
method to reset its state. When used correctly, this service can be injected and
reused. Additionally, :php:`UriBuilder` is declared :php:`shared: false`, so
consumers receive distinct instances, reducing the risk of bugs from improper use of
:php:`reset()`.

Various solutions exist to make existing services stateless. For instance, the extbase
:php:`UriBuilder` could deprecate its :php:`setX()` chaining methods and introduce a
:php:`UriParameterBag` data object, which would be passed to the service worker methods.
Implementing such changes in the TYPO3 core codebase is an ongoing process that requires
careful consideration.

Deciding whether to use :php:`makeInstance()` instead of dependency injection
requires examining the dependency's behavior. Consider these factors:

*   The service class is declared :php:`readonly` and only declares stateless
    dependencies in :php:`__construct()`.
*   The service has no class properties.
*   All :php:`__construct()` arguments are services and declared :php:`readonly`.
*   :php:`__construct()` requires no manual non-service arguments.

The last point is particularly relevant: Some TYPO3 core services expect state to be
passed to :php:`__construct()`, making them stateful and unsuitable for injection,
as dependency injection cannot handle consumer state. These services *must* be
instantiated using :php:`makeInstance()` until their constructors are updated to be
compatible with dependency injection.

.. _dependency-injection-new:

When to use :php:`new`?
-----------------------

..  attention::
    **In short**: Use :php:`new` to instantiate data objects, not services.

Services should be always retrieved using dependency injection. If that is not
feasible because the dependent service is stateful or because the class is created
using a "polluted" constructor with manual arguments, it should be created using
:php:`makeInstance()`. While services without dependencies *could* be instantiated
with :php:`new`, this approach has drawbacks: It introduces risks if the service
is later modified to include dependencies and bypasses the XCLASS mechanism and
potential service overrides by configuration.

Only data objects - preferably using
:ref:`public constructor property promotion <cgl-named-arguments-pcpp-value-objects>` -
should be instantiated using the PHP keyword :php:`new`.


Mix manual constructor arguments and service dependencies?
----------------------------------------------------------

..  attention::
    **In short**: No. For good reason.

A service can not mix manual constructor arguments with service dependencies
handled by dependency injection. Manual constructor arguments make services stateful.
When a service is instantiated with manual arguments, such as
:php:`$myService = GeneralUtility::makeInstance(MyService::class, $myState)`,
dependency injection is bypassed, and any other service dependencies in the
constructor are ignored. Mixing both blends the roles of services and data objects,
which is poor PHP architecture.

The extbase-based dependency injection solution using :php:`ObjectManager`
allowed such mixtures, but this has been replaced by the Symfony-based
dependency injection solution, which does not support this practice.


What about user functions?
--------------------------

It is possible to use dependency injection when calling custom user functions,
for example :ref:`.userFunc within TypoScript <t3tsref:cobj-user-properties>` or
:ref:`in (legacy) hooks <hooks-general>`, usually via
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`.

:php:`callUserFunction()` internally uses the dependency-injection-aware
helper :php:`GeneralUtility::makeInstance()`, which can recognize and inject
services that are marked public.


What about injection in a XCLASS'ed class?
------------------------------------------

When extending an existing class (for example, an Extbase controller) using
:ref:`XCLASS <xclasses>` and injecting additional dependencies using constructor
injection, define the existing class as an alias for the extended class in the
:file:`Configuration/Services.yaml` file of the extending extension, by using the
shortcut notation for an alias as shown in the example below:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    TYPO3\CMS\Belog\Controller\BackendLogController: '@MyVendor\MyExtension\Controller\ExtendedBackendLogController'

If the extended class is instantiated by :php:`GeneralUtility::makeInstance()` and
:ref:`must be declared public <What_to_make_public>`, either use an additional
:ref:`PHP attribute <dependency-injection-autoconfigure>` or the full alias
notation including the `public` argument:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    TYPO3\CMS\Belog\Controller\BackendLogController:
      public: true
      alias: MyVendor\MyExtension\Controller\ExtendedBackendLogController


Not yet exemplified
===================

*   This document does not currently elaborate on Symfony service providers,
    although the TYPO3 core uses them in various places. Use cases for these
    should be outlined.

*   The concept and usage of "lazy" services are not discussed.

*   Solutions to cyclic dependencies should be explored. Cyclic dependencies
    occur when services depend on each other, forming a graph instead of a
    tree, which Symfony's dependency injection cannot resolve. One solution
    is to make one side lazy, although this is not the primary use of
    "lazy." Another approach involves using a factory with an interface,
    as demonstrated in `ext:styleguide`.


Further information
===================

.. rst-class:: compact-list

*  `Symfony dependency injection component <https://symfony.com/doc/current/components/dependency_injection.html>`_

*  `Symfony service container <https://symfony.com/doc/current/service_container.html>`_

*  `Dependency Injection in TYPO3 <https://usetypo3.com/dependency-injection.html>`_ blog article by Daniel Goerz

*  `Dependency Injection <https://phptherightway.com/#dependency_injection>`_ in "PHP The Right Way"

*  `What is dependency injection? <http://fabien.potencier.org/what-is-dependency-injection.html>`_ by Fabien Potencier
