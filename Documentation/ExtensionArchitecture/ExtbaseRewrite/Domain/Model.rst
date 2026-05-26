:navigation-title: Model

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Model
..  _extbase-domain-model:

====================
Extbase domain model
====================

A domain model is a PHP class that represents one type of data your extension
works with — an event, a product, a blog post, a speaker. Each instance of
the class corresponds to one database record. Extbase maps between the two
automatically.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-model-abstract-entity:

AbstractEntity — what you get for free
======================================

Every persisted domain object extends
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {
        // your properties here
    }

You do **not** declare :php:`$uid` or :php:`$pid` — they are inherited.
:php:`AbstractEntity` provides:

*   :php:`getUid(): ?int` — returns :php:`null` until the object is persisted
*   :php:`getPid(): ?int` — the page UID the record lives on
*   :php:`setPid(int $pid): void`
*   Dirty-state tracking — Extbase knows which properties changed since the
    object was loaded and only writes those columns on :php:`update()`

..  note::

    Do not extend :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject`
    directly. :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
    is the correct base class for objects that have identity (a UID).
    :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject` exists but
    is marked :php:`@internal` — see :ref:`extbase-domain-model-value-objects` below.


..  _extbase-domain-model-properties:

Defining model properties in Extbase
====================================

Properties should be :php:`protected`, typed, and have a default value:

..  literalinclude:: _snippets/_Conference.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

Key rules:

*   Declare properties :php:`protected`. Public properties work but bypass
    getters and setters, making lazy loading and dirty-state tracking harder to
    reason about. Private properties are never populated during
    :abbr:`hydration (populating a PHP object with values loaded from the database)`
    — PHP prevents the parent :php:`_setProperty()` method from writing to them
    — and changes to private properties are never persisted for the same reason;
    see :ref:`extbase-appendix-pitfalls-private-properties`.
*   Every property needs a meaningful default so the object is always in a
    valid state before it is populated by Extbase or by your code.
*   Provide getters. Provide setters for properties that should be changeable
    after construction. Read-only properties need only a getter.
*   Boolean properties follow the :php:`is*()` / :php:`set*()` convention
    (:php:`isPublished()`, not :php:`getPublished()`).

**Column mapping convention:** Extbase maps camelCase property names to
snake_case database columns automatically. The property :php:`$conferenceDate`
maps to the column :sql:`conference_date`. When your table or column names do not
follow this convention, override the mapping in
:file:`Configuration/Extbase/Persistence/Classes.php`; see
:ref:`extbase-domain-model-mapping` for the full syntax.

..  seealso::

    `Private properties silently ignored <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-private-properties>`_ — why
    private properties are silently ignored, with the full technical
    explanation.

    Field and table mapping overrides are covered in the mapping reference
    (coming soon) and in `storagePid — when findAll() returns nothing <https://docs.typo3.org/permalink/extbase-domain-repository-storagepid>`_.


..  _extbase-domain-model-attributes:

PHP attributes in Extbase domain models
=======================================

Extbase uses the native PHP attribute syntax to control persistence behaviour and
validation.

..  versionchanged:: 14.0

    DocBlock annotation support was removed. See
    :ref:`extbase-upgrading-annotations-to-attributes` for the migration table
    and the available Rector rule.

The four attributes you will use on model properties:

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

        Excludes a property from persistence entirely. Useful for computed
        values or temporary state that should never reach the database.

    ..  confval:: #[Validate]
        :name: extbase-attr-validate
        :type: :php-short:`\TYPO3\CMS\Extbase\Attribute\ORM\Validate`

        Declares a validation rule on a property. The validator runs when
        the object is submitted via a controller action.
        :php:`#[Validate]` is repeatable — apply multiple validators to one
        property.

Import from the :php:`\TYPO3\CMS\Extbase\Attribute\ORM\` namespace:

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
    in v14 — Extbase will ignore the annotation without an error.

..  seealso::

    `Extbase PHP attributes <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_ — all Extbase PHP attributes
    with parameters and usage examples


..  _extbase-domain-model-relations:

Modelling relations in Extbase
==============================

The following example shows a model with both relation types — a 1:1 relation
to a :php:`Location` and a 1:n relation to a collection of :php:`Comment`
objects:

..  literalinclude:: _snippets/_ConferenceWithRelations.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php (with relations)

A few things to note in the example above:

..  Relation cardinality language needs a dedicated treatment: a nullable typed property
..  can be a true 1:1 (both sides required and unique), a 0:1 (optional), or n:1 (many
..  conference records pointing at one location). These all look the same in PHP but differ
..  in intent and TCA setup. Revisit this section once the relations chapter is written.

*   **Singular relations** (a typed property, nullable when the related object is optional)
    are one common pattern. When :php:`#[Lazy]` is
    applied, Extbase installs a
    :php-short:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy` instead
    of loading the related object immediately. The union type
    :php:`Location|LazyLoadingProxy|null` is required so Extbase can set the
    proxy. The :php:`instanceof LazyLoadingProxy` check in the getter exists
    solely for static analysis — without it PHPStan cannot narrow the return
    type to :php:`?Location`. If you do not need a precisely typed getter, the
    proxy resolves automatically on any access and the check can be omitted.

*   :php:`#[Lazy]` on an :php:`ObjectStorage` means Extbase loads the related
    records only when you first iterate over the storage or call a method on it.
    This avoids loading potentially hundreds of related records just because the
    parent object was loaded.

*   :php:`#[Cascade('remove')]` on :php:`$comments` means: when this
    :php:`Conference` is deleted, all related :php:`Comment` objects are also
    deleted. A comment has no life outside its event, so this is the right
    choice. Without this attribute, deleting the event leaves orphaned comment
    records in the database. Use cascade remove only when the related objects
    genuinely belong to the parent and have no independent existence.

*   The :php:`addComment()` / :php:`removeComment()` pair uses
    :php:`ObjectStorage::attach()` and :php:`ObjectStorage::detach()`. Do not
    manipulate :php:`$this->comments` directly.

*   The :php:`@var ObjectStorage<Comment>` docblock is required for IDE
    autocompletion and static analysis, even though PHP itself does not enforce
    generic types.

..  seealso::

    `Persistence relations <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — relations, lazy loading,
    and the N+1 query trap.

    `Extbase PHP attributes <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_ — all Extbase PHP attributes
    with parameters and usage examples


..  _extbase-domain-model-filereference:

File reference properties
=========================

A model property that maps to a
:abbr:`FAL (File Abstraction Layer)` file uses
:php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference` — Extbase's own
thin wrapper around the :sql:`sys_file_reference` table. A single file becomes
a nullable property; a collection uses
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`:

..  literalinclude:: _FileUpload/_Conference.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

The corresponding TCA column must be of :ref:`type=file <t3tca:columns-file>`.

In a Fluid template, pass the
:php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference` object directly to
:ref:`f:image <t3viewhelper:typo3-fluid-image>`. This honours any crop
configuration or additional properties set in the TYPO3 backend for that file reference:

..  literalinclude:: _FileUpload/_Show.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.html

..  seealso::

    :ref:`extbase-domain-fileupload` — handling file uploads submitted through a
    frontend form, including the :php:`#[FileUpload]` attribute, validation,
    and deletion.


..  _extbase-domain-model-enums:

Enum properties in Extbase domain models
========================================

`Backed enums <https://www.php.net/manual/en/language.enumerations.backed.php>`_
— enums with an underlying :php:`string` or :php:`int` value, introduced with
PHP 8.1 — work in Extbase
models without any extra configuration. Extbase's built-in
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\EnumConverter` converts the stored value to and from the enum instance
automatically.

Define the enum:

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
    (without a backing type) are not supported — there is no stable scalar
    value to store in the database. Always use backed enums for model
    properties.


..  _extbase-domain-model-transient:

Non-persisted (transient) properties in Extbase models
======================================================

Mark a property :php:`#[Transient]` to exclude it from persistence entirely.
Extbase will never read or write the corresponding column. The property is
populated by your own code — typically a getter that computes the value from
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

Table and field mapping
=======================

Extbase derives the database table name from the class name. The class
:php:`MyVendor\MyExtension\Domain\Model\Conference` maps to the table
:sql:`tx_myextension_domain_model_conference`. Within the table, each
camelCase property maps to a snake_case column.

When a table or column does not match the convention — for example, when you
are mapping to an existing table like :sql:`fe_users` — override the mapping
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

Configuring persistence for Extbase models
==========================================

A model class alone is not enough — TYPO3 also needs a
`TCA <https://docs.typo3.org/m/typo3/reference-tca/main/en-us/>`_
(Table Configuration Array) definition for the table. TCA tells TYPO3 what
columns exist, what type they are, and how they behave in the backend. Without
it, neither the backend nor the database analyser knows anything about your
table.

The database analyser can create the actual database columns automatically from
TCA definitions. This means you **do not need**
:file:`ext_tables.sql` for standard column types — TYPO3 derives the SQL from
the TCA and creates or updates the columns when the database analyser runs
(for example after installing or updating an extension).

You still need :file:`ext_tables.sql` when you require:

*   Custom column types not covered by TCA (for example :sql:`JSON`, spatial types)
*   Explicit indices beyond the defaults
*   Precise control over column length or collation

..  tip::

    Writing a model class and its TCA by hand in parallel is error-prone and
    repetitive. The `TYPO3 Kickstarter
    <https://packagist.org/packages/friendsoftypo3/kickstarter>`_
    (:composer:`friendsoftypo3/kickstarter`) can generate both together via
    its :bash:`vendor/bin/typo3 make:*` commands. It is the recommended
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
no database row, no concept of "the same object over time". Classic examples:
a monetary amount, a date range, a GPS coordinate, a color.

Value objects have three characteristics that make them useful:

*   **Immutable** — once created, they cannot be changed. Operations return a
    new instance rather than modifying the existing one.
*   **Equality by value** — two instances with identical properties are
    interchangeable. Compare them with an :php:`equals()` method, not with
    :php:`===`.
*   **Self-validating** — the constructor rejects invalid state, so a value
    object that exists is always valid.

A :php:`Color` value object is a straightforward example: :php:`new Color('Midnight Blue', '#191970')`
and another :php:`new Color('Midnight Blue', '#191970')` are equal and
interchangeable. Neither has an identity. You never update a colour — you
replace it with a new one.

**In TYPO3 and Extbase**, value objects are implemented as plain PHP classes.
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject` exists in v14 but
is marked :php:`@internal` — it is not public API and must not be extended in
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
    that only valid cases can be constructed. Value objects are the right
    choice when the value has structure, behaviour, or validation logic
    beyond what an enum case can express.

..  seealso::

    `Enum properties in Extbase domain models <https://docs.typo3.org/permalink/extbase-domain-model-enums>`_ — backed
    enums as model properties, including automatic conversion by Extbase.
