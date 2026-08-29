:navigation-title: Model

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Model
..  _extbase-domain-model:
..  _extbase-domain-example:
..  _extbase-extending:
..  _extbase-model:

====================
Extbase domain model
====================

A domain model is a PHP class that represents one type of data that your extension
works with, for example, an event, a product, a blog post, or a speaker. Each instance of
the class corresponds to one database record. Extbase maps between the two
automatically.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-model-abstract-entity:

`AbstractEntity` — what you get for free
========================================

Every persisted domain object extends
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {
        // your properties here
    }

You do **not** need to declare :php:`$uid` or :php:`$pid` — they are inherited.
:php:`AbstractEntity` provides:

*   :php:`getUid(): ?int` — returns :php:`null` until the object is persisted
*   :php:`getPid(): ?int` — the page UID the record lives on
*   :php:`setPid(int $pid): void`
*   Dirty-state tracking — Extbase knows which properties have changed since the
    object was loaded and only writes those columns on :php:`update()`

..  note::

    Do not extend :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject`.
    :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
    is the correct base class for objects that have identity (a UID).
    :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject` exists but
    is marked :php:`@internal` — see :ref:`extbase-domain-model-value-objects` below.


..  _extbase-domain-model-properties:
..  _extbase-model-properties:
..  _extbase-model-properties-default-values:
..  _extbase-model-properties-default-values-directly:
..  _extbase-model-properties-untyped:

Defining model properties in Extbase
====================================

Properties should be :php:`protected`, typed, and have a default value:

..  literalinclude:: _snippets/_Conference.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

Key rules:

*   Declare properties as :php:`protected`. Public properties work but bypass
    getters and setters, making lazy loading and dirty-state tracking harder to
    reason about. Private properties are never populated during
    :abbr:`hydration (populating a PHP object with values loaded from the database)`
    — PHP prevents the parent :php:`_setProperty()` method from writing to them
    — and changes to private properties are never persisted for the same reason.
    See :ref:`extbase-appendix-pitfalls-private-properties`.
*   Every property needs a meaningful default so that the object is always in a
    valid state before it is populated by Extbase or your code.
*   Provide getters. Provide setters for properties that should be changeable
    after construction. Read-only properties onyl need a getter.
*   Boolean properties follow the :php:`is*()` / :php:`set*()` convention
    (:php:`isPublished()`, not :php:`getPublished()`).

**Column mapping convention:** Extbase maps camelCase property names to
snake_case database columns automatically. The property :php:`$conferenceDate`
maps to the column :sql:`conference_date`. If your table or column names do not
follow this convention, override the mapping in
:file:`Configuration/Extbase/Persistence/Classes.php`. See
:ref:`extbase-domain-model-mapping` for the full syntax.

..  seealso::

    `Private properties silently ignored <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-private-properties>`_ for why
    private properties are silently ignored, with the full technical
    explanation.

    Field and table mapping overrides are covered in the mapping reference
    (coming soon) and in `storagePid — when findAll() returns nothing <https://docs.typo3.org/permalink/extbase-domain-repository-storagepid>`_.


..  _extbase-domain-model-attributes:

PHP attributes in Extbase domain models
=======================================

Extbase uses native PHP attribute syntax to control persistence behaviour and
validation.

..  versionchanged:: 14.0

    DocBlock annotation support was removed. See
    :ref:`extbase-upgrading-annotations-to-attributes` for the migration table
    and the relevant Rector rule.

The four possible attributes on model properties are:

..  confval-menu::
    :name: extbase-orm-attributes
    :display: table
    :type:
    :default:

    ..  confval:: #[Lazy]
        :name: extbase-attr-lazy
        :type: :php-short:`\TYPO3\CMS\Extbase\Attribute\ORM\Lazy`

        Defers loading of a related object or :php:`ObjectStorage` until the
        getter is first called. Use on relations in list views where you often
        do not need the related data.

    ..  confval:: #[Cascade('remove')]
        :name: extbase-attr-cascade
        :type: :php-short:`\TYPO3\CMS\Extbase\Attribute\ORM\Cascade`

        Deletes related objects automatically when the owning object is
        deleted. Only :php:`'remove'` is supported.

    ..  confval:: #[Transient]
        :name: extbase-attr-transient
        :type: :php-short:`\TYPO3\CMS\Extbase\Attribute\ORM\Transient`

        Excludes a property from persistence. Useful for computed
        values or temporary state that should never reach the database.

    ..  confval:: #[Validate]
        :name: extbase-attr-validate
        :type: :php-short:`\TYPO3\CMS\Extbase\Attribute\ORM\Validate`

        Declares a validation rule on a property. The validator runs when
        the object is submitted via a controller action.
        :php:`#[Validate]` is repeatable — apply multiple validators to one
        property.

Import from the :php:`\TYPO3\CMS\Extbase\Attribute\ORM` namespace:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
    use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
    use TYPO3\CMS\Extbase\Attribute\ORM\Transient;
    use TYPO3\CMS\Extbase\Attribute\ORM\Validate;

    // on model properties:
    #[Validate(validator: 'NotEmpty')]
    protected string $title = '';

    #[Validate(validator: 'StringLength', options: ['minimum' => 3, 'maximum' => 50])]
    protected string $slug = '';

    #[Lazy]
    #[Cascade('remove')]
    protected ObjectStorage $comments;

    #[Transient]
    protected ?string $computedLabel = null;

..  warning::

    If you are migrating from an older extension, replace all DocBlock
    annotations (:php:`@Extbase\ORM\Lazy`, :php:`@Extbase\Validate`, etc.)
    with their attribute equivalents. The old syntax causes a silent failure
    in v14 meaning that Extbase will ignore the annotation without an error.

..  seealso::

    `Extbase PHP attributes <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_ for all Extbase PHP attributes
    with parameters and usage examples


..  _extbase-domain-model-relations:
..  _extbase-model-relations:

Modelling relations in Extbase
==============================

A relation is just a property, and Extbase offers two shapes for it: a property
that holds **one other object**, and a property that holds **many objects** in an
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`. The following example shows both — a relation to one
:php:`Location` and a relation to many :php:`Comment` objects:

..  literalinclude:: _snippets/_ConferenceWithRelations.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php (with relations)

A few things to note in the example above:

*   **A relation to a single other object** is a single typed property, nullable when
    the related object is optional. If :php:`#[Lazy]` is applied, Extbase
    installs a
    :php-short:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy` instead
    of loading the related object immediately. The union type
    :php:`Location|LazyLoadingProxy|null` is required so that Extbase can set the
    proxy. The :php:`instanceof LazyLoadingProxy` check in the getter exists
    solely for static analysis — without it PHPStan cannot narrow the return
    type to :php:`?Location`. If you do not need a precisely typed getter, the
    proxy resolves automatically on any access and the check can be omitted.

*   **A relation to many objects** is an :php:`ObjectStorage`. You read it by
    iterating, and change it through :php:`addComment()` / :php:`removeComment()`
    methods that call :php:`attach()` and :php:`detach()` — never manipulate the
    storage property directly. The :php:`@var ObjectStorage<Comment>` annotation
    is required for IDE autocompletion and static analysis, even though PHP does
    not enforce the generic type.

*   **Each ObjectStorage must be initialised**, otherwise the first access
    to the typed property triggers a fatal error. Do this in
    :php:`initializeObject()` and call that method from the constructor. Extbase
    calls :php:`initializeObject()` itself after mapping a record from the
    database, so the storage is ready on loaded objects; calling it from
    :php:`__construct()` as well covers objects you create with :php:`new`. Both
    code paths then end up with an initialised storage.

*   :php:`#[Lazy]` on an :php:`ObjectStorage` means Extbase loads the related
    records only when you first iterate over the storage or call a method on it.
    This avoids loading potentially hundreds of related records just because the
    parent object is loaded.

*   :php:`#[Cascade('remove')]` on :php:`$comments` means that when this
    :php:`Conference` object is deleted, all related :php:`Comment` objects are also
    deleted. A comment has no life outside its event, so this is the right
    choice. Without this attribute, deleting the event would leave orphaned comment
    records in the database. Use cascade remove only when the related objects
    genuinely belong to the parent and have no independent existence.

..  seealso::

    *   `Object relations in Extbase <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — explains the two relation types, how they are stored, unidirectional and bidirectional relations, lazy loading, and the N+1 query problem.

    *   `Extbase PHP attributes <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_ — all Extbase PHP attributes, with parameters and usage examples.


..  _extbase-domain-model-filereference:

File reference properties
=========================

A model property that maps to a
:abbr:`FAL (File Abstraction Layer)` file uses
:php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference` — Extbase's own
thin wrapper around the :sql:`sys_file_reference` table. A single file becomes
a nullable property. A collection uses
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`:

..  literalinclude:: _FileUpload/_Conference.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

The corresponding TCA column must be of :ref:`type=file <t3tca:columns-file>`.

In a Fluid template, pass the
:php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference` object to
:ref:`f:image <t3viewhelper:typo3-fluid-image>`. This will honour crop
configuration or any additional properties set in the TYPO3 backend for that file reference:

..  literalinclude:: _FileUpload/_Show.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.html

..  seealso::

    :ref:`extbase-domain-fileupload` for handling file uploads submitted through a
    frontend form, including the :php:`#[FileUpload]` attribute, validation,
    and deletion.


..  _extbase-domain-model-enums:

Enum properties in Extbase domain models
========================================

`Backed enums <https://www.php.net/manual/en/language.enumerations.backed.php>`_
— enums with an underlying :php:`string` or :php:`int` value (introduced in
PHP 8.1) — work in Extbase
models without any extra configuration. Extbase's built-in
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\EnumConverter` converts the
stored value to and from the enum instance.

Define the enum as follows:

..  literalinclude:: _snippets/_Salutation.php
    :caption: EXT:my_extension/Classes/Domain/Model/Enum/Salutation.php

Use it as a model property:

..  literalinclude:: _snippets/_ConferenceWithEnum.php
    :caption: EXT:my_extension/Classes/Domain/Model/Speaker.php

The database column stores the raw backing value (:php:`''`, :php:`'mr'`,
:php:`'ms'`, :php:`'mx'`). Extbase converts it to the enum case on read and
back to the string on write.

..  note::

    Pure
    `unit enums <https://www.php.net/manual/en/language.enumerations.basics.php>`_
    (without a backing type) are not supported because there is no stable scalar
    value to store in the database. Always use backed enums for model
    properties.


..  _extbase-domain-model-transient:

Non-persisted (transient) properties in Extbase models
======================================================

Mark a property as :php:`#[Transient]` to exclude it from persistence.
Extbase will never read or write the corresponding column. The property should then be
populated by your own code, which is typically a getter that computes a value using
other properties:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    namespace MyVendor\MyExtension\Domain\Model;

    use TYPO3\CMS\Extbase\Attribute\ORM\Transient;
    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {
        protected string $title = '';

        protected ?\DateTimeImmutable $conferenceDate = null;

        #[Transient]
        protected ?string $displayLabel = null;

        public function getDisplayLabel(): string
        {
            if ($this->displayLabel === null) {
                $this->displayLabel = $this->title . ' (' . $this->conferenceDate?->format('Y') . ')';
            }
            return $this->displayLabel;
        }
    }


..  _extbase-domain-model-mapping:
..  _extbase-model-persistence:
..  _extbase-persistance-record-types:
..  _extbase-persistence:
..  _extbase-persistence-database-connection:
..  _extbase_manual_mapping:

Table and field mapping
=======================

Extbase derives the database table name from the class name, for example, the class
:php:`MyVendor\MyExtension\Domain\Model\Conference` maps to the table
:sql:`tx_myextension_domain_model_conference`. Each
camelCase property maps to a snake_case column inside the table.

If a table or column does not match the convention, for example,
a table like :sql:`fe_users` which already exists in the system, override the mapping
in :file:`Configuration/Extbase/Persistence/Classes.php`:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Extbase/Persistence/Classes.php

    // Configuration/Extbase/Persistence/Classes.php
    return [
        \MyVendor\MyExtension\Domain\Model\FrontendUser::class => [
            'tableName' => 'fe_users',
            'properties' => [
                'firstName' => ['fieldName' => 'first_name'],
            ],
        ],
    ];

..  Full mapping reference including class hierarchy and multi-model tables — placement TBD.


..  _extbase-domain-model-db-columns:
..  _extbase-model-properties-default-values-tca:

Configuring persistence for Extbase models
==========================================

A model class alone is not enough — TYPO3 also needs a
:ref:`TCA <t3tca:start>`
(Table Configuration Array) definition for the corresponding database table. TCA
tells TYPO3 which columns exist, what type they are, and how they behave in the backend. Without
TCA, neither the backend nor the database analyser would know anything about your
table.

The database analyser can create the actual database columns automatically from
TCA definitions. This means you **do not need**
:file:`ext_tables.sql` for standard column types — TYPO3 derives SQL from
the TCA and creates or updates the columns when the database analyser runs
(for example after installing or updating an extension).

You only need :file:`ext_tables.sql` for:

*   Custom column types not covered by TCA (for example :sql:`JSON`, spatial types)
*   Explicit indices beyond the defaults
*   Precise control over column length or collation

..  tip::

    Writing a model class and its TCA by hand is error-prone and
    repetitive. The `TYPO3 Kickstarter
    <https://packagist.org/packages/friendsoftypo3/kickstarter>`_
    (:composer:`friendsoftypo3/kickstarter`) can generate both together via
    :bash:`vendor/bin/typo3 make:*` commands. It is the recommended
    starting point when creating new models from scratch.

..  seealso::

    :ref:`extension-configuration-tca` — the :file:`Configuration/TCA/`
    folder in your extension, where TCA files live.

    `TCA reference — column types
    <https://docs.typo3.org/m/typo3/reference-tca/main/en-us/ColumnsConfig/Index.html>`_
    — full list of column types and their auto-creation support.

    :ref:`extension-files-locations` — complete extension file and folder
    structure reference.


..  _extbase-domain-model-value-objects:

Value objects in Extbase domain models
======================================

In
`Domain-Driven Design <https://en.wikipedia.org/wiki/Domain-driven_design>`_,
a
`value object <https://en.wikipedia.org/wiki/Value_object>`_
is an object defined entirely by its value rather than by an identity. Two
value objects are equal if all their properties are equal — there is no UID,
no database row, no concept of "the same object over time". Classic examples are:
a monetary amount, a date range, a GPS coordinate, a color.

Value objects have three characteristics that make them useful:

*   **Immutable** — once created, they cannot be changed. Operations return a
    new instance rather than modifying an existing one.
*   **Equality by value** — two instances with identical properties are
    interchangeable. Compare them using an :php:`equals()` method, not
    :php:`===`.
*   **Self-validating** — the constructor rejects invalid state, so a value
    object that exists is always valid.

A :php:`Color` value object is a straightforward example: :php:`new Color('Midnight Blue', '#191970')`
and another :php:`new Color('Midnight Blue', '#191970')` are equal and
interchangeable. Neither has an identity. You never update a colour, you
just replace it with a new one.

**In TYPO3 and Extbase**, value objects are implemented as plain PHP classes.
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject` exists in v14 but
is marked :php:`@internal`. It is not public API and must not be extended in
extension code.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Color.php

    final class Color
    {
        public function __construct(
            public readonly string $name,
            public readonly string $hex,
        ) {
            if (!preg_match('/^#[0-9a-fA-F]{6}$/', $hex)) {
                throw new \InvalidArgumentException('Invalid hex color: ' . $hex);
            }
        }

        public function equals(self $other): bool
        {
            return $this->hex === $other->hex;
        }

        public function withName(string $name): self
        {
            return new self($name, $this->hex);
        }
    }

Note that :php:`withName()` returns a new :php:`Color` instance rather than
modifying :php:`$this` — that is the immutability principle in practice. The
constructor validates the hex format immediately, so an invalid :php:`Color`
can never exist.

**Persistence:** value objects are not persisted as their own database records.
Store them as scalar columns on the owning entity and reconstruct the object in
a getter:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Product.php

    class Product extends AbstractEntity
    {
        protected string $colorName = '';
        protected string $colorHex = '#000000';

        public function getColor(): Color
        {
            return new Color($this->colorName, $this->colorHex);
        }

        public function setColor(Color $color): void
        {
            $this->colorName = $color->name;
            $this->colorHex = $color->hex;
        }
    }

If the value object genuinely needs its own table and identity, it is no longer
a value object — use :php:`AbstractEntity` instead.

..  note::

    If the set of possible values is fixed and known at compile time — a
    salutation, a status, a priority level — use a backed enum instead.
    Enums are simpler, Extbase maps them automatically, and PHP enforces
    the construction of only valid cases. Value objects are the right
    choice when the value has structure, behaviour, or validation logic
    beyond what an enum can express.

..  seealso::

    `Enum properties in Extbase domain models <https://docs.typo3.org/permalink/extbase-domain-model-enums>`_ for backed
    enums as model properties, including automatic conversion by Extbase.

..  _extbase-domain-model-hydration:
..  _extbase-model-hydrating:

Hydrating / thawing objects of Extbase models
=============================================

..  Ported from old docs: Extbase/Reference/Domain/Model/Hydrating/Index.rst
    (whole page, lifted as a section). Old anchor: extbase-model-hydrating.

..  todo::
    Needs review: This section was ported verbatim from the old Extbase
    documentation and needs updating to the rewrite conventions.

..  warning::
    The information in this section might be outdated!

Hydrating (the term originates from `doctrine/orm`_), or in Extbase terms thawing,
is the act of creating an object from a given database row. The responsible
class involved is the :php:`\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper`.
During the process of hydrating, the :php:`DataMapper` creates objects to map
the raw database data onto.

Before diving into the framework internals, let us take a look at models from
the user's perspective.

..  _doctrine/orm: https://github.com/doctrine/orm

..  _extbase-domain-model-hydration-constructor:
..  _extbase-model-constructor:

Creating model objects with constructor arguments
-------------------------------------------------

Imagine you have a table :sql:`tx_extension_domain_codesnippets_blog` and a
corresponding model or entity (entity is used as a synonym here)
:php:`\MyVendor\MyExtension\Domain\Model\Blog`.

Now, also imagine there is a domain rule which states, that all blogs must have
a title. This rule can easily be followed by letting the blog class have a
constructor with a required argument :php:`string $title`.

..  literalinclude:: _snippets/_Blog1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example also shows how the `posts` property is initialized. It is done in
the constructor because PHP does not allow setting a default value that is of
type object.

..  _extbase-domain-model-hydration-thawing:
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

..  _extbase-domain-model-hydration-initializing:
..  _extbase-model-initializing:
..  _extbase-model-properties-default-values-initialize:

Initializing objects
--------------------

Have a look at the :php:`$posts` property in the example above. If the
:php:`DataMapper` ignores the constructor, that property is in an invalid state,
that means, uninitialized.

To address this problem and possible others, the :php:`DataMapper` will call the
method :php:`initializeObject(): void` on models, if it exists.

Here is an updated version of the model:

..  literalinclude:: _snippets/_Blog2.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

This example demonstrates how Extbase expects the user to set up their models.
If the method :php:`initializeObject()` is used for initialization logic that
needs to be triggered on initial creation **and** on hydration. Please mind
that :php:`__construct()` **should** call :php:`initializeObject()`.

If there are no domain rules to follow, the recommended way to set up a model
would then still be to define a :php:`__construct()` and
:php:`initializeObject()` method like this:

..  literalinclude:: _snippets/_Blog3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

..  warning::
    Since Extbase does not call the constructor when thawing objects, special
    care must be taken regarding default values. See `Default values for model properties <https://docs.typo3.org/permalink/t3coreapi:extbase-domain-model-properties>`_
    for recommendations.

..  _extbase-domain-model-hydration-mutation:
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
    Extbase do. Both, :ref:`validation <extbase-validation-overview>` and property
    mapping, either use existing mutators or gather type information from them.

..  _extbase-domain-model-hydration-visibility:
..  _extbase-model-visibility:

Property visibility
-------------------

One important thing to know is that Extbase needs entity properties to be
protected or public. As written in the former paragraph,
:php:`AbstractDomainObject::_setProperty()` is used to bypass setters.
However, :php:`AbstractDomainObject` is not able to access private properties of
child classes, hence the need to have protected or public properties.

..  _extbase-domain-model-hydration-di:
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

..  _extbase-domain-model-hydration-event:
..  _extbase-model-event:

Using an event when a object is thawed
--------------------------------------

The PSR-14 event :ref:`AfterObjectThawedEvent` is available to modify values
when creating domain objects.
