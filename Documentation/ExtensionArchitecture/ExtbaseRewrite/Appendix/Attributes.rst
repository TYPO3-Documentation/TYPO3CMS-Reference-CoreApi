:navigation-title: PHP attributes reference

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; PHP attributes
..  _extbase-appendix-attributes:

================================
Extbase PHP attributes reference
================================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page is a quick-reference for all PHP attributes defined and handled by
the Extbase framework itself. It covers :abbr:`ORM (Object Relational Mapping)` attributes (used on model
properties), validation attributes (used on model properties and action
parameters), and controller-level attributes (used on action methods).

It does not cover attributes defined by TYPO3 Core outside of Extbase, or
PHP built-in attributes.

..  contents:: On this page
    :local:
    :depth: 2


..  _extbase-appendix-attributes-orm:

ORM (Object Relational Mapping) attributes (persistence)
========================================================

**ORM** (`Object-Relational Mapping <https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping>`_)
is the mechanism that lets you work with PHP objects instead of raw database
rows. Therefor Extbase maps database fields to Object Model properties and back.
The attributes described below are used to control this process.

The attributes are declared in the :php:`\TYPO3\CMS\Extbase\Attribute\ORM`
namespace and are placed on model properties.

..  _extbase-appendix-attributes-lazy:

`#[Lazy]`
---------

:Target: Model property
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Lazy`
:Parameters: none

By default, relations are resolved and processed by loading all related objects together with the parent,
which can harm performance and trigger N+1 queries, for example in list views.
:php:`#[Lazy]` tells Extbase to load the related object only when it is actively
accessed — by calling its methods or reading its properties.

When applied to a relation to a single object, the property type must include
:php-short:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy` so Extbase knows to install the proxy. A typed getter
needs an :php:`instanceof` check only so PHPStan and your IDE can narrow the
return type to :php:`?Location`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
    use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

    class Conference extends AbstractEntity
    {
        #[Lazy]
        protected Location|LazyLoadingProxy|null $location = null;

        public function getLocation(): ?Location
        {
            // the check is only needed to keep phpstan happy. Remove it if not needed.
            if ($this->location instanceof LazyLoadingProxy) {
                $this->location = $this->location->_loadRealInstance();
            }
            return $this->location;
        }
    }

If you do not need a narrowly typed getter, the check is unnecessary — accessing
the proxy in any way triggers resolution automatically.

..  seealso::

    `Relations and ObjectStorage <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — relations and ObjectStorage
    on the model page.

    `Persistence relations <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — full lazy loading reference
    and the N+1 query trap.


..  _extbase-appendix-attributes-cascade:

`#[Cascade]`
------------

:Target: Model property
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Cascade`
:Parameters: :php:`string|null $value = null`

Controls what happens to related objects when the parent object is deleted.
Currently only :php:`'remove'` is supported:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
    use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;

    class Conference extends AbstractEntity
    {
        #[Lazy]
        #[Cascade('remove')]
        protected ObjectStorage $comments;
    }

Without :php:`#[Cascade('remove')]`, deleting the parent object leaves related
records in the database as orphans. With it, Extbase deletes the related
objects automatically via the repository.

..  note::

    Only :php:`'remove'` is supported. Other Doctrine cascade operations
    (:php:`'persist'`, :php:`'merge'`, etc.) are not implemented in Extbase.

..  important::

    Cascade remove is triggered by Extbase's own persistence layer — it only
    fires when you delete an object via a repository method (for example
    :php:`$repository->remove($object)`). Deleting a record through the TYPO3
    backend uses the DataHandler, which is unaware of :php:`#[Cascade]`. For
    cascade behaviour in backend deletions, configure the corresponding TCA
    relation with the appropriate delete behaviour.

    ..  Verify cascade remove behaviour in edge cases against the v14 extbase source.


..  _extbase-appendix-attributes-transient:

`#[Transient]`
--------------

:Target: Model property
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Transient`
:Parameters: none

Excludes a property from persistence entirely. Extbase never reads or writes
the corresponding column. Use for computed values or temporary state:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Transient;

    class Conference extends AbstractEntity
    {
        #[Transient]
        protected ?string $displayLabel = null;
    }

..  _extbase-appendix-attributes-validation:

Validation attributes
=====================

These attributes are declared in the :php:`\TYPO3\CMS\Extbase\Attribute` namespace
and control validation behaviour on model properties and controller action parameters.


..  _extbase-appendix-attributes-validate:

`#[Validate]`
-------------

:Target: Model property, action method parameter
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\Validate`
:Repeatable: yes — apply multiple :php:`#[Validate]` to one target
:Parameters:

    :php:`string $validator`
        The validator class name or short name (for example :php:`'NotEmpty'`,
        :php:`'StringLength'`). Short names resolve against the built-in
        validators in :php:`\TYPO3\CMS\Extbase\Validation\Validator`.

    :php:`array $options = []`
        Options passed to the validator constructor. The available options
        depend on the validator.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\Validate;

    class Conference extends AbstractEntity
    {
        #[Validate(validator: 'NotEmpty')]
        #[Validate(validator: 'StringLength', options: ['minimum' => 3, 'maximum' => 50])]
        protected string $title = '';
    }

..  seealso::

    `Built-in validators <https://docs.typo3.org/permalink/extbase-validation-builtin>`_ — all built-in validators and
    their options.

    `Custom validators <https://docs.typo3.org/permalink/extbase-validation-custom>`_ — writing a custom validator.


..  _extbase-appendix-attributes-ignorevalidation:

`#[IgnoreValidation]`
---------------------

:Target: Action method parameter
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\IgnoreValidation`
:Parameters: none (place directly on the parameter)

Suppresses validation for one action parameter. Useful in multi-step forms
where partial state is forwarded between actions:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
    use Psr\Http\Message\ResponseInterface;

    class ConferenceController extends ActionController
    {
        public function previewAction(
            #[IgnoreValidation]
            Conference $conference,
        ): ResponseInterface {
            // validation skipped for $conference
        }
    }

Place :php:`#[IgnoreValidation]` directly on the parameter — method-level
placement with :php:`argumentName` is deprecated in TYPO3 v14 and removed in
v15. See :ref:`extbase-upgrading-ignorevalidation-parameter`.


..  _extbase-appendix-attributes-controller:

Controller attributes
=====================

These attributes are declared in the :php:`\TYPO3\CMS\Extbase\Attribute`
namespace and are applied to controller action methods to control access and
rate limiting.

.. Full documentation for these attributes is planned for the Controller and Security chapters.


..  _extbase-appendix-attributes-authorize:

`#[Authorize]`
--------------

:Target: Controller action method
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\Authorize`

..  versionadded:: 14.0

    Introduced in Feature `#107826 <https://docs.typo3.org/permalink/changelog:feature-107826-1766220191>`_.

Declares access requirements for an action method. Extbase checks the
requirements before calling the action and redirects or throws an exception
if they are not met.

.. Full parameter reference and usage examples are coming in the Security chapter.

..  warning::

    :php:`#[Authorize]` handles action-level access ("is the user logged in?
    are they in the right group?") but does **not** verify record ownership.
    Always check that a submitted UID belongs to the current user before
    updating or deleting records — Extbase will not do this for you.


..  _extbase-appendix-attributes-ratelimit:

`#[RateLimit]`
--------------

:Target: Controller action method
:Fully qualified namespace: :php:`\TYPO3\CMS\Extbase\Attribute\RateLimit`

..  versionadded:: 14.0

    Introduced in Feature `#108982 <https://docs.typo3.org/permalink/changelog:_feature-108982-1771078311>`_.

Limits how often an action may be called within a time window, per visitor.
Useful for protecting form submission endpoints against brute-force and spam.

.. Full parameter reference and usage examples are coming in the Security chapter.
