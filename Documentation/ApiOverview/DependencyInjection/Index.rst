.. include:: ../../Includes.txt

.. _DependencyInjection:

====================
Dependency Injection
====================

Since TYPO3 10.0, Symfony dependency injection is supported
(see :doc:`Changelog/10.0/Feature-84112-SymfonyDependencyInjectionForCoreAndExtbase`).

This page handles dependency injection in TYPO3 version 9.5.

Dependency injection is not a specific TYPO3 concept. It is a

   one form of the broader technique of inversion of control. A client who
   wants to call some services should not have to know how to construct
   those services. Instead, the client delegates the responsibility of
   providing its services to external code (the injector).

- `Wikipedia: Dependency injection <https://en.wikipedia.org/wiki/Dependency_injection>`__

For more information about the general (not TYPO3 specific) concepts, see

* `Thorben Janssen: "Design Patterns Explained - Dependency Injection with
  Code Examples" <https://stackify.com/dependency-injection/>`__
* `Martin Fowler: Inversion of Control Containers and the Dependency
  Injection pattern <https://martinfowler.com/articles/injection.html>`__

Methods of dependency injection
===============================

Constructor injection
---------------------

`Constructor injection <https://en.wikipedia.org/wiki/Dependency_injection#Constructor_injection>`__
is a method of passing an object in the constructor.

Example::

   use Vendor\Foo\Service\MyServiceInterface;

   class MySomething
   {

      /**
       * @var MyServiceInterface
       */
      protected $myService;

      /**
       * @param $myService
       */
       public function __construct(MyService $myService)
       {
           $this->myService = $myService;
       }


It is now possible to pass any service object implementing the
:php:`MyServiceInterface` in the constructor of the class :php:`MySomething`.

This method can be used in TYPO3 and is recommended.

Setter injection
----------------

Setter injection supplies a method to pass the object to be injected.

Example::

   use Vendor\Foo\Service\MyServiceInterface;

   class MySomething
   {

       /**
        * @var MyService
        */
       protected $myService;

       /**
        * @param FooRepository
        */
        public function setMyService(MyServiceInterface $myServiceInterface)
        {
            $this->myServiceInterface = $myServiceInterface;
        }

Using objects without dependency injection
------------------------------------------

Similar to the constructor injection, you could also do::


    use Vendor\Foo\Service\MyService;

    class MyController
    {

        /**
        * @var MyService
        */
        protected $myService;

        public function __construct()
        {
            $this->myService = GeneralUtility::makeInstance(MyService::class);
        }

This would hardwire usage of the :php:`MyService` in the controller class.
Even if this class is intended to always use :php:`MyService`, it will
be more difficult to write tests for it (because it is for example not
possible to pass a different mockup object to be used as service object).


Not recommended methods
=======================

`@inject` annotations
---------------------

.. important::

   This method is not recommended!

Since TYPO3 4.7, it is possible to use the `@inject` annotation.

Example::

   /**
    * @var \Vendor\Foo\Domain\Repository\FooRepository
    * @inject
    */
    protected $fooRepository;

Mostly for performance reasons, it is no longer recommended to use `@inject`.


.. seealso::

   * `Why you should never use @inject in TYPO3 Extbase <https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837>`__
