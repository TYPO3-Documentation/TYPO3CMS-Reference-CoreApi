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

..  toctree::
    :caption: Subpages
    :glob:
    :titlesonly:

    Persistence/Index
    Relations/Index
    Hydrating/Index
    Relations/Index
    */Index

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

..  literalinclude:: Hydrating/_codesnippets/_Blog3.php
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

..  literalinclude:: _codesnippets/_UnionType1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

This is especially useful for lazy-loaded relations where the property type is
:php:`ChildEntity|\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy`.

There is something important to understand about how Extbase detects union
types when it comes to property mapping, that means when a database row is
:ref:`mapped onto an object <extbase-model-hydrating>`. In this case, Extbase
needs to know the desired target type - no union, no intersection, just one
type. In order to achieve this, Extbase uses the first declared type as a
so-called primary type.

..  literalinclude:: _codesnippets/_UnionType2.php
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

..  literalinclude:: _codesnippets/_UnionType3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

Extbase supports this and detects :php:`ChildEntity` as the primary type,
although :php:`LazyLoadingProxy` is the first item in the list. However, it is
recommended to place the actual type first, for consistency reasons:
:php:`ChildEntity|LazyLoadingProxy`.

A final word on :php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage`:
it is a subclass of :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`,
therefore the following code works and has always worked:

..  literalinclude:: _codesnippets/_ObjectStorage.php
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

..  literalinclude:: _codesnippets/_Level.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/Enum/Level.php

The enum can then be used for a property in the model:

..  literalinclude:: _codesnippets/_LogEntry.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/LogEntry.php


..  _extbase-extending:

Extending existing models
=========================

It is possible, with some limitations, to extend existing Extbase models in
another extension. See also :ref:`Tutorial: Extending an Extbase model
<extending-extbase-model>`.
