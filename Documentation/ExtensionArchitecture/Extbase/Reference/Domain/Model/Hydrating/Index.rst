:navigation-title: Hydrating

..  include:: /Includes.rst.txt
..  _extbase-model-hydrating:

=============================================
Hydrating / Thawing objects of Extbase models
=============================================

Hydrating (the term originates from `doctrine/orm`_), or in Extbase terms thawing,
is the act of creating an object from a given database row. The responsible
class involved is the :php:`\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper`.
During the process of hydrating, the :php:`DataMapper` creates objects to map
the raw database data onto.

Before diving into the framework internals, let us take a look at models from
the user's perspective.

..  _doctrine/orm: https://github.com/doctrine/orm

..  _extbase-model-constructor:

Creating model objects with constructor arguments
=================================================

Imagine you have a table :sql:`tx_extension_domain_codesnippets_blog` and a
corresponding model or entity (entity is used as a synonym here)
:php:`\MyVendor\MyExtension\Domain\Model\Blog`.

Now, also imagine there is a domain rule which states, that all blogs must have
a title. This rule can easily be followed by letting the blog class have a
constructor with a required argument :php:`string $title`.

..  literalinclude:: _codesnippets/_Blog1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example also shows how the `posts` property is initialized. It is done in
the constructor because PHP does not allow setting a default value that is of
type object.

..  _extbase-model-constructor-hydration:

Hydrating objects with constructor arguments
============================================

Whenever the user creates new blog objects in extension code, the aforementioned
domain rule is followed. It is also possible to work on the :php:`posts`
:php:`ObjectStorage` without further initialization. :php:`new Blog('title')` is
all one need to create a blog object with a valid state.

What happens in the :php:`DataMapper` however, is a totally different thing.
When hydrating an object, the :php:`DataMapper` cannot follow any domain rules.
Its only job is to map the raw database values onto a :php:`Blog` instance. The
:php:`DataMapper` could of course detect constructor arguments and try to guess
which argument corresponds to what property, but only if there is an easy
mapping, that means, if the constructor takes the argument :php:`string $title`
and updates the property `title` with it.

To avoid possible errors due to guessing, the :php:`DataMapper` simply ignores
the constructor at all. It does so with the help of the library
`doctrine/instantiator`_.

But there is more to all this.

..  _doctrine/instantiator: https://github.com/doctrine/instantiator

..  _extbase-model-initializing:

Initializing objects
====================

Have a look at the :php:`$posts` property in the example above. If the
:php:`DataMapper` ignores the constructor, that property is in an invalid state,
that means, uninitialized.

To address this problem and possible others, the :php:`DataMapper` will call the
method :php:`initializeObject(): void` on models, if it exists.

Here is an updated version of the model:

..  literalinclude:: _codesnippets/_Blog2.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example demonstrates how Extbase expects the user to set up their models.
If the method :php:`initializeObject()` is used for initialization logic that
needs to be triggered on initial creation **and** on hydration. Please mind
that :php:`__construct()` **should** call :php:`initializeObject()`.

If there are no domain rules to follow, the recommended way to set up a model
would then still be to define a :php:`__construct()` and
:php:`initializeObject()` method like this:

..  literalinclude:: _codesnippets/_Blog3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

..  _extbase-model-mutation:

Mutating objects
================

Some few more words on mutators (setter, adder, etc.). One might think that
:php:`DataMapper` uses mutators during object hydration but it **does not**.
Mutators are the only way for the user (developer) to implement business rules
besides using the constructor.

The :php:`DataMapper` uses the internal method
:php:`AbstractDomainObject::_setProperty()` to update object properties. This
looks a bit dirty and is a way around all business rules but that is what the
:php:`DataMapper` needs in order to leave the mutators to the users.

..  warning::
    While the :php:`DataMapper` does not use any mutators, other parts of
    Extbase do. Both, :ref:`validation <extbase_domain_validator>` and property
    mapping, either use existing mutators or gather type information from them.

..  _extbase-model-visibility:

Property visibility
===================

One important thing to know is that Extbase needs entity properties to be
protected or public. As written in the former paragraph,
:php:`AbstractDomainObject::_setProperty()` is used to bypass setters.
However, :php:`AbstractDomainObject` is not able to access private properties of
child classes, hence the need to have protected or public properties.

..  _extbase-model-dependency-injection:

Dependency injection
====================

Without digging too deep into :ref:`dependency injection <DependencyInjection>`
the following statements have to be made:

*   Extbase expects entities to be so-called prototypes, that means classes that
    do have a different state per instance.
*   :php:`DataMapper` **does not** use dependency injection for the creation of
    entities, that means it does not query the object container. This also
    means, that dependency injection is not possible in entities.

If you think that your entities need to use/access services, you need to find
other ways to implement it.

..  _extbase-model-event:

Using an event when a object is thawed
======================================

The PSR-14 event :ref:`AfterObjectThawedEvent` is available to modify values
when creating domain objects.
