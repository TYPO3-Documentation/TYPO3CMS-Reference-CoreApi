..  include:: /Includes.rst.txt
..  _cgl-traits:

======
Traits
======


Characteristica
===============

* A trait MAY access properties or methods of the class it is
  embedded in.

* A trait MUST be combined with an interface. Classes using a trait
  must implement at least this interface.

* A trait interface MUST have a default implementation trait.


Rationale
=========

There is one specific feature that traits provide other abstraction
solutions like services or static extraction do not: A trait is
embedded within the class that consumes it and as such can directly
access methods and properties of this class. A trait typically holds
state in a property of the class. If this feature is not needed, traits
should not be used. Thus, the trait itself may even have a dependency
to the class it is embedded in, even if this is rather discouraged.

A simple way to look at this is to see the interface as the main
feature with the trait providing a single or maybe two default
implementations of the interface for a specific class.

One usage of traits is the removal of boilerplate code. While object
creation and dependency injection is still a not resolved issue in the
Core, this area is probably a good example where a couple of traits
would be really useful to autowire default functionality like logging
into classes with very little developer effort and in a simple and
understandable way. It should however be kept in mind that traits must
always be used with care and should stay as a relatively seldom used
solution. This is one reason why the current :php:`getLanguageService()`
and similar boilerplate methods are kept within classes directly for
now and is not extracted to traits: Both container system and global
scope objects are currently not finally decided and we don’t want to
have relatively hard to deprecate and remove traits at this point.


Good Examples
=============

* :php:`\Symfony\Component\DependencyInjection\ContainerAwareInterface` with
  :php:`\Symfony\Component\DependencyInjection\ContainerAwareTrait` as default
  implementation

  * The :php:`ContainerAwareInterface` is tested to within the
    dependency injection system of symfony and the trait is a simple
    default implementation that easily adds the interface functionality
    to a given class.

  * Good naming.

  * Clear scope.

* :php:`LoggerAwareInterface` with a default trait.


Bad Examples
============

* Old :php:`\TYPO3\CMS\FluidStyledContent\ViewHelpers\Menu\MenuViewHelperTrait` (available in previous TYPO3 versions)

  * Contains only protected methods, can not be combined with interface.

  * Contains :php:`getTypoScriptFrontendController()`, hides this
    dependency in the consuming class.

  * No interface.

  * It would have probably been better to add the trait code to a full
    class and just use it in the according view helpers (composition) or
    implement it as abstract.

For these reasons the trait has been dissolved into an `AbstractMenuViewHelper`.

Further Reading
===============

See https://www.rosstuck.com/how-i-use-traits.
