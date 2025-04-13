:navigation-title: Model

..  include:: /Includes.rst.txt
..  index:: Extbase; Model
..  _extbase-model:

========================================
Extbase model - extending AbstractEntity
========================================

All classes of the domain model should inherit from the class
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`.

An entity is an object fundamentally defined not by its attributes, but by a
thread of continuity and identity, for example, a person or a blog post.

Objects stored in the database are usually entities as they can be identified
by the :sql:`uid` and are persisted, therefore have continuity.

In the TYPO3 backend models are displayed as :ref:`database-records`.

**Example:**

..  include:: /CodeSnippets/Extbase/Domain/AbstractEntity.rst.txt

..  warning::
    Extbase does not call the constructor when thawing objects. Therefore you
    cannot set default values or initialize properties in the constructor.
    This includes properties that are defined via constructor parameter
    promotion. See also `Default values for model properties <https://docs.typo3.org/permalink/t3coreapi:extbase-model-properties-default-values>`_.

..  contents:: Table of content
    :local:

..  _extbase-model-persistence:

Persistence: Connecting the model to the database
=================================================

It is possible to define models that are not persisted to the database. However in
the most common use cases you want to save your model to the database and load
it from there. See :ref:`extbase-Persistence`.

..  _extbase-model-properties:

Properties of an Extbase model
==============================

The properties of a model can be defined either as public
class properties:

..  include:: /CodeSnippets/Extbase/Domain/ModelWithPublicProperty.rst.txt

Or public getters:

..  include:: /CodeSnippets/Extbase/Domain/ModelWithPublicGetters.rst.txt

A public getter takes precedence over a public property. Getters have the
advantage that you can make the properties themselves protected and decide
which ones should be mutable.

..  note::
    Making model's properties :php:`private` does not work in Extbase models: The parent
    classes need to access the models properties directly. If your model must
    not be extended you can mark it as :php:`final` and thereby prevent
    other developers from extending your model.

It is also possible to have getters for
properties that are not persisted and get created on the fly:

..  include:: /CodeSnippets/Extbase/Domain/ModelWithAdditionalGetters.rst.txt

One disadvantage of using additional getters is that properties that are only
defined as getters do not get displayed in the debug output in Fluid, they do
however get displayed when explicitly called:

..  code-block:: html
    :caption: Debugging different kind of properties

    Does not display "combinedString":
    <f:debug>{post.info}</f:debug>

    But it is there:
    <f:debug>{post.info.combinedString}</f:debug>

..  _extbase-model-properties-default-values:

Default values for model properties
-----------------------------------

When Extbase loads an object from the database, it does **not** call the
constructor.

This is explained in more detail in the section
`thawing objects of Extbase models <https://docs.typo3.org/permalink/t3coreapi:extbase-model-hydrating>`_.

This means:

-   Property promotion in the constructor (for example
    :php:`__construct(public string $title = '')`) **does not work**
-   Properties must be initialized in a different way to avoid runtime errors

..  _extbase-model-properties-default-values-directly:

Good: Set default values directly
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can assign default values when defining the property. This works for simple
types such as strings, integers, booleans or nullable properties:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

    class Blog extends AbstractEntity
    {
        protected string $title = '';
        protected ?\DateTime $modified = null;
    }

..  _extbase-model-properties-default-values-initialize:

Good: Use ``initializeObject()`` for setup
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If a property needs special setup (for example, using `new ObjectStorage()`),
you can put that logic into a method called `initializeObject()`. Extbase
calls this method automatically after loading the object:

..  literalinclude:: _Hydrating/_Blog3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

..  _extbase-model-properties-default-values-cpp:

Avoid: Constructor property promotion
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This will **not** work when the object comes from the database:

..  code-block:: php

    public function __construct(protected string $title = '') {}

Since the constructor is never called during hydration, such properties remain
uninitialized and can cause errors like:

    Error: Typed property MyVendor\MyExtension\Domain\Model\Blog::$title
    must not be accessed before initialization

To prevent this, always initialize properties either where they are defined or
inside the `initializeObject()` method.

..  _extbase-model-properties-default-values-tca:

TCA default values
~~~~~~~~~~~~~~~~~~

If the TCA configuration of a field defines a
:ref:`default value <t3tca:confval-input-default>`, that value is applied **after**
`initializeObject()` has been called, and **before** data from the database is
mapped to the object.

..  _extbase-model-properties-union-types:

Union types of Extbase model properties
---------------------------------------

..  versionadded:: 12.3
    Previously, whenever a union type was needed, union type declarations led
    Extbase not detecting any type at all, resulting in the property not being
    mapped. However, union types could be resolved via docblocks. Since TYPO3
    v12.3 native PHP union types can be used.

Union types can be used in properties of an entity, for example:

..  literalinclude:: _Model/_UnionType1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

This is especially useful for lazy-loaded relations where the property type is
:php:`ChildEntity|\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy`.

There is something important to understand about how Extbase detects union
types when it comes to property mapping, that means when a database row is
:ref:`mapped onto an object <extbase-model-hydrating>`. In this case, Extbase
needs to know the desired target type - no union, no intersection, just one
type. In order to achieve this, Extbase uses the first declared type as a
so-called primary type.

..  literalinclude:: _Model/_UnionType2.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

In this case, :php:`string` is the primary type. :php:`int|string` would result
in :php:`int` as primary type.

There is one important thing to note and one exception to this rule. First of
all, :php:`null` is not considered a type. :php:`null|string` results in the
primary type :php:`string` which is :ref:`nullable <extbase-model-nullable-relations>`.
:php:`null|string|int` also results in the primary type :php:`string`. In fact,
:php:`null` means that all other types are nullable. :php:`null|string|int`
boils down to :php:`?string` or :php:`?int`.

Secondly, :php:`LazyLoadingProxy` is never detected as a primary type because it
is just a proxy and not the actual target type, once loaded.

..  literalinclude:: _Model/_UnionType3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

Extbase supports this and detects :php:`ChildEntity` as the primary type,
although :php:`LazyLoadingProxy` is the first item in the list. However, it is
recommended to place the actual type first, for consistency reasons:
:php:`ChildEntity|LazyLoadingProxy`.

A final word on :php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage`:
it is a subclass of :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`,
therefore the following code works and has always worked:

..  literalinclude:: _Model/_ObjectStorage.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

..  _extbase-model-enumerations:

Enumerations as Extbase model property
--------------------------------------

..  versionadded:: 13.0
    Native support for
    `backed enumerations <https://www.php.net/manual/language.enumerations.backed.php>`__
    has been introduced. It is no longer necessary to extend the now deprecated
    TYPO3 Core class :ref:`\\TYPO3\\CMS\\Core\\Type\\Enumeration <Enumerations-How-to-use>`.

Native PHP enumerations can be used for properties, if a database field has a
specific set of values which can be represented by a backed enum:

..  literalinclude:: _Model/_Level.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/Enum/Level.php

The enum can then be used for a property in the model:

..  literalinclude:: _Model/_LogEntry.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/LogEntry.php

..  _extbase-model-relations:

Relations between Extbase models
================================

Extbase supports different types of hierarchical relationships
between domain objects.
All relationships can be defined unidirectional or multidimensional in the model.

On the side of the relationship that can only have one counterpart, you must
decide whether it is possible to have no relationship (allow null) or not.


..  _extbase-model-nullable-relations:

Nullable relations
------------------

There are two ways to allow :php:`null` for a property in PHP:

*   Mark the type declaration as nullable by prefixing the type name with a
    question mark:

    ..  code-block:: php
        :caption: Example for a nullable property

        protected ?Person $secondAuthor = null;

*   Use a union type:

    ..  code-block:: php
        :caption: Example for a union type of null and Person

        protected Person|null $secondAuthor = null;

Both declarations have the same meaning.

..  _extbase-model-relations-one-one:

1:1-relationship
----------------

A blog post can have, in our case, exactly one additional info attached to it.
The info always belongs to exactly one blog post. If the blog post gets deleted,
the info does get related.

..  include:: /CodeSnippets/Extbase/Domain/Optional1on1.rst.txt

..  _extbase-model-relations-one-many:

1:n-relationship
----------------

A blog can have multiple posts in it. If a blog is deleted all of its posts
should be deleted. However a blog might get displayed without displaying the
posts therefore we load the posts of a blog lazily:

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onN2.rst.txt

..  note::
    Note the subtle differences here. The methods :php:`setPosts()` and
    :php:`getPosts()` refer simultaneously to all blog posts.
    They expect and hence provide an :php:`ObjectStorage` object.

    The methods :php:`addPost()` and :php:`removePost()` refer to a single
    post object that is added to the list or removed from.

..  attention::
    It is possible to get an array of objects from an :php:`ObjectStorage`
    by calling :php:`$this->posts->toArray()`. However doing so and looping
    the resulting array might cause performance problems.

Each post belongs to exactly one blog, of course a blog does not get deleted
when one of its posts gets deleted.

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onN1.rst.txt

A post can also have multiple comments and each comment belongs to exactly
one blog. However we never display a comment without its post therefore we do
not need to store information about the post in the comment's model: The
relationship is unidirectional.

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onNUni.rst.txt

The model of the comment has no property to get the blog post in this case.

..  _extbase-model-relations-many-one:

n:1-relationships
-----------------

n:1-relationships are the same like 1:n-relationsships but from the
perspective of the object:

Each post has exactly one main author but an author can write several blog
posts or none at all. He can also be a second author and no main author.

..  include:: /CodeSnippets/Extbase/Domain/RelationshipNon1Uni.rst.txt

Once more the model of the author does not have a property containing the
authors posts. If you would want to get all posts of an author you would have
to make a query in the PostRepository taking one or both relationships (first
author, second author) into account.

..  _extbase-model-relations-many-many:

m:n-relationship
----------------

A blog post can have multiple categories, each category can belong to
multiple blog posts.

..  include:: /CodeSnippets/Extbase/Domain/RelationshipNonM.rst.txt

..  _extbase-model-hydrating:

Hydrating / thawing objects of Extbase models
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
-------------------------------------------------

Imagine you have a table :sql:`tx_extension_domain_model_blog` and a
corresponding model or entity (entity is used as a synonym here)
:php:`\MyVendor\MyExtension\Domain\Model\Blog`.

Now, also imagine there is a domain rule which states, that all blogs must have
a title. This rule can easily be followed by letting the blog class have a
constructor with a required argument :php:`string $title`.

..  literalinclude:: _Hydrating/_Blog1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example also shows how the `posts` property is initialized. It is done in
the constructor because PHP does not allow setting a default value that is of
type object.

..  _extbase-model-constructor-hydration:

Hydrating objects with constructor arguments
--------------------------------------------

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
--------------------

Have a look at the :php:`$posts` property in the example above. If the
:php:`DataMapper` ignores the constructor, that property is in an invalid state,
that means, uninitialized.

To address this problem and possible others, the :php:`DataMapper` will call the
method :php:`initializeObject(): void` on models, if it exists.

Here is an updated version of the model:

..  literalinclude:: _Hydrating/_Blog2.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example demonstrates how Extbase expects the user to set up their models.
If the method :php:`initializeObject()` is used for initialization logic that
needs to be triggered on initial creation **and** on hydration. Please mind
that :php:`__construct()` **should** call :php:`initializeObject()`.

If there are no domain rules to follow, the recommended way to set up a model
would then still be to define a :php:`__construct()` and
:php:`initializeObject()` method like this:

..  literalinclude:: _Hydrating/_Blog3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

..  _extbase-model-mutation:

Mutating objects
----------------

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
-------------------

One important thing to know is that Extbase needs entity properties to be
protected or public. As written in the former paragraph,
:php:`AbstractDomainObject::_setProperty()` is used to bypass setters.
However, :php:`AbstractDomainObject` is not able to access private properties of
child classes, hence the need to have protected or public properties.

..  _extbase-model-dependency-injection:

Dependency injection
--------------------

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
--------------------------------------

The PSR-14 event :ref:`AfterObjectThawedEvent` is available to modify values
when creating domain objects.

..  _extbase-model-lazy-loading:

Eager loading and lazy loading
==============================

By default, Extbase loads all child objects with the parent object (so for
example, all posts of a blog). This behavior is called eager loading.
The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy` causes Extbase to
load and build the objects only when they
are actually needed (lazy loading). This can lead to a significant
increase in performance.

..  _extbase-model-cascade-remove:

On cascade remove
=================

The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")` has
the effect that, if a blog is deleted, its posts will also be deleted
immediately. Extbase usually leaves all child objects' persistence unchanged.

Besides these two, there are a few more annotations available, which will be used
in other contexts. For the complete list of all Extbase
supported annotations, see the chapter :ref:`extbase-annotations`.

..  _extbase-model-localizedUid:

Identifiers in localized models
===============================

Domain models have a main identifier :php:`uid` and an additional property
:php:`_localizedUid`.

Depending on whether the
:typoscript:`languageOverlayMode` mode is enabled (:typoscript:`true` or
:typoscript:`'hideNonTranslated'`) or disabled (:typoscript:`false`),
the identifier contains different values.

When :typoscript:`languageOverlayMode` is enabled, then the :php:`uid`
property contains the :php:`uid` value of the default language record,
the :php:`uid` of the translated record is kept in the :php:`_localizedUid`.

+----------------------------------------------------------+-------------------------+---------------------------+
| Context                                                  | Record in language 0    | Translated record         |
+==========================================================+=========================+===========================+
| Database                                                 | uid:2                   | uid:11, l10n_parent:2     |
+----------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with `languageOverlayMode` enabled  | uid:2, _localizedUid:2  | uid:2, _localizedUid:11   |
+----------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with `languageOverlayMode` disabled | uid:2, _localizedUid:2  | uid:11, _localizedUid:11  |
+----------------------------------------------------------+-------------------------+---------------------------+

..  hint::
    In case your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

.. TODO: Explain workspaces in Extbase context

..  _extbase-extending:

Extending existing models
=========================

It is possible, with some limitations, to extend existing Extbase models in
another extension. See also :ref:`Tutorial: Extending an Extbase model
<extending-extbase-model>`.
