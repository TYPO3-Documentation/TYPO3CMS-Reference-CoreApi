.. include:: /Includes.rst.txt
.. index:: pair: Coding guidelines; Services
.. _cgl-services:

========
Services
========


Characteristica
===============

* Services MUST be used as objects, they are never static.

* A single service MUST consist of one class only.

* Services MUST be located in a :file:`Service/` directory and the class and file name MUST end
  with :code:`Service`, eg. :file:`Service/FoobarService.php`.

* Service instances MAY hold a state, but they SHOULD be stateless.

* Services MAY use their own configuration, but they SHOULD not.

* Services MAY have multiple entry points, but they SHOULD have only one.

* Services SHOULD NOT be singletons


Rationale
=========

A “service” in this context is meant as the relatively short-sighted
process of putting a class into a :file:`Service/` subfolder and calling
it a :code:`WhateverService`. It does not have too much to do with the
DDD Service context, which is broader. This section is just about which
scope can be expected for classes residing in a Service folder within
Core extensions.

From this point of view, a service in the TYPO3 world is a relatively slim
class construct that encapsulates a specific concern. It is too big for
a small static method, it may hold a state, but it is still just a
relatively small scope. Each service consists typically of only a single
class. A bigger construct with interfaces, multiple sub classes is not
called a service anymore.

The above characteristica MAY and SHOULD mean that a single service MAY do a single one
or two of them, but if for instance a service would become relatively big, 
if it would have many entry points, if it would keep states and depend on configuration, 
this would be too much. This would be a sign that it should be modeled in a different and more
dedicated and more disjoint way.

The main risk with service classes is that they pile up to a
conglomeration of helper stuff classes that are hanging around without
good motivation. It is important that a service class should not be a
bin for something that just does not fit to a different better place
within the scope of a specific extension.


Good Examples
=============

* :php:`\TYPO3\CMS\Extbase\Service\CacheService`

  * Small and straight scope with useful helpers

  * It is a singleton, but that is feasible in this case


Bad Examples
============

* :php:`\TYPO3\CMS\Core\Service\AbstractService`,

  * Not modeled in a sane way, this should be within :file:`Core/Authentication`

  * Far too complex, class abstraction and extending classes


Further Reading
===============

See http://gorodinski.com/blog/2012/04/14/services-in-domain-driven-design-ddd/.
