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

    PropertyTypes/Index
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

..  _extbase-model-properties-untyped:

Typed vs. untyped properties in Extbase models
==============================================

In Extbase, you can define model properties using either PHP native type
declarations or traditional `@var` annotations. Typed properties are
preferred, untyped properties are still supported for backward compatibility.

The example below demonstrates a basic model with both a typed and an untyped
property:

..  literalinclude:: _codesnippets/_untypedProperties.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

-   `$title` is a *typed property*, using PHP’s type declaration. This is the
    recommended approach as it enforces type safety and improves code
    readability.

-   `$published` is an *untyped property*, defined only with a docblock. This
    remains valid and is often used in older codebases.

For persisted properties (those stored in the database), ensure that the
property type matches the corresponding
`TCA Field type <https://docs.typo3.org/permalink/t3tca:columns-types>`_
to avoid data mapping errors.

Nullable and `Union types <https://docs.typo3.org/permalink/t3coreapi:extbase-model-properties-union-types>`_
are also supported.

..  note:: Typed properties are strongly encouraged in all new TYPO3 extensions.

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


..  _extbase-extending:

Extending existing models
=========================

It is possible, with some limitations, to extend existing Extbase models in
another extension. See also :ref:`Tutorial: Extending an Extbase model
<extending-extbase-model>`.
