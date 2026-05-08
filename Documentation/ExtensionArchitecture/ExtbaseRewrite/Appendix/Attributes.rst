:navigation-title: PHP attributes reference

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; PHP attributes
..  _extbase-appendix-attributes:

================================
Extbase PHP attributes reference
================================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page is a quick-reference for all PHP attributes defined and handled by
the Extbase framework itself. It covers ORM attributes (used on model
properties), validation attributes (used on model properties and action
parameters), and controller-level attributes (used on action methods).

It does not cover attributes defined by TYPO3 Core outside of Extbase, or
PHP built-in attributes. Where a more detailed explanation exists in another
chapter, this page links there.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-appendix-attributes-orm:

ORM attributes (persistence)
=============================

These attributes are declared in the :php:`\TYPO3\CMS\Extbase\Attribute\ORM`
namespace and are placed on
model properties to control how Extbase maps them to and from the database.

..  _extbase-appendix-attributes-lazy:

#[Lazy]
-------

:Target: Model property
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Lazy`
:Parameters: none

Defers loading of a related object or :php:`ObjectStorage` until the property
is first accessed. Without :php:`#[Lazy]`, Extbase loads all related objects
when the parent is loaded — which can trigger N+1 queries in list views.

The proxy resolves itself automatically via PHP magic methods on any property
or method access — you do not need to call :php:`_loadRealInstance()` yourself.

When applied to a 1:1 relation, the property type must include
:php:`LazyLoadingProxy` so Extbase knows to install the proxy. A typed getter
needs an :php:`instanceof` check only so PHPStan and your IDE can narrow the
return type to :php:`?Location`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Event.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
    use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

    #[Lazy]
    protected Location|LazyLoadingProxy|null $location = null;

    public function getLocation(): ?Location
    {
        if ($this->location instanceof LazyLoadingProxy) {
            $this->location = $this->location->_loadRealInstance();
        }
        return $this->location;
    }

If you do not need a narrowly typed getter, the check is unnecessary — accessing
the proxy in any way triggers resolution automatically.

..  seealso::

    `Relations and ObjectStorage <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — relations and ObjectStorage
    on the model page.

    `Persistence relations <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — full lazy loading reference
    and the N+1 query trap.


..  _extbase-appendix-attributes-cascade:

#[Cascade]
----------

:Target: Model property
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Cascade`
:Parameters: :php:`string|null $value = null`

Controls what happens to related objects when the owning object is deleted.
Currently only :php:`'remove'` is supported:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Event.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
    use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;

    #[Lazy]
    #[Cascade('remove')]
    protected ObjectStorage $comments;

Without :php:`#[Cascade('remove')]`, deleting the parent object leaves related
records in the database as orphans. With it, Extbase deletes the related
objects automatically via the repository.

..  note::

    Only :php:`'remove'` is supported. Other Doctrine cascade operations
    (:php:`'persist'`, :php:`'merge'`, etc.) are not implemented in Extbase.


..  _extbase-appendix-attributes-transient:

#[Transient]
------------

:Target: Model property
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\ORM\Transient`
:Parameters: none

Excludes a property from persistence entirely. Extbase never reads or writes
the corresponding column. Use for computed values or temporary state:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Event.php

    use TYPO3\CMS\Extbase\Attribute\ORM\Transient;

    #[Transient]
    protected ?string $displayLabel = null;


..  _extbase-appendix-attributes-validation:

Validation attributes
=====================

These attributes are declared in the
:php:`\TYPO3\CMS\Extbase\Attribute\` namespace and control validation
behaviour on model properties and controller action parameters.


..  _extbase-appendix-attributes-validate:

#[Validate]
-----------

:Target: Model property, action method parameter
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\Validate`
:Repeatable: yes — apply multiple :php:`#[Validate]` to one target
:Parameters:

    :php:`string $validator`
        The validator class name or short name (for example :php:`'NotEmpty'`,
        :php:`'StringLength'`). Short names resolve against the built-in
        validators in :php:`\TYPO3\CMS\Extbase\Validation\Validator\`.

    :php:`array $options = []`
        Options passed to the validator constructor. The available options
        depend on the validator.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Event.php

    use TYPO3\CMS\Extbase\Attribute\Validate;

    #[Validate(validator: 'NotEmpty')]
    #[Validate(validator: 'StringLength', options: ['minimum' => 3, 'maximum' => 50])]
    protected string $title = '';

..  seealso::

    `Built-in validators <https://docs.typo3.org/permalink/extbase-validation-builtin>`_ — all built-in validators and
    their options.

    `Custom validators <https://docs.typo3.org/permalink/extbase-validation-custom>`_ — writing a custom validator.


..  _extbase-appendix-attributes-ignorevalidation:

#[IgnoreValidation]
-------------------

:Target: Action method parameter
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\IgnoreValidation`
:Parameters: none (place directly on the parameter)

Suppresses validation for one action parameter. Useful in multi-step forms
where partial state is forwarded between actions:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/EventController.php

    use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;

    public function previewAction(
        #[IgnoreValidation] Event $event
    ): ResponseInterface {
        // validation skipped for $event
    }

..  note::

    In TYPO3 v14, :php:`#[IgnoreValidation]` must be placed on the
    **parameter**, not on the method with an :php:`argumentName` property.
    The method-level form was deprecated in v14 (Deprecation `#108227
    <https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.0/Deprecation-108227-UsageOfIgnoreValidationAndValidateAttributesForParametersAtMethodLevel.html>`__).


..  _extbase-appendix-attributes-controller:

Controller attributes (v14)
============================

These attributes are declared in the :php:`\TYPO3\CMS\Extbase\Attribute\`
namespace and are applied to controller action methods to control access and
rate limiting. Both are new in TYPO3 v14.

Full documentation for these attributes is planned for the Controller and
Security chapters.


..  _extbase-appendix-attributes-authorize:

#[Authorize]
------------

:Target: Controller action method
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\Authorize`
:New in: TYPO3 v14 (Feature `#107826 <https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.2/Feature-107826-IntroduceExtbaseActionAuthorizationLogic.html>`__)

Declares access requirements for an action method. Extbase checks the
requirements before calling the action and redirects or throws an exception
if they are not met.

Full parameter reference and usage examples are coming in the Security chapter.

..  warning::

    :php:`#[Authorize]` handles action-level access (is the user logged in?
    are they in the right group?) but does **not** verify record ownership.
    Always check that a submitted UID belongs to the current user before
    updating or deleting records — Extbase will not do this for you.


..  _extbase-appendix-attributes-ratelimit:

#[RateLimit]
------------

:Target: Controller action method
:Namespace: :php:`\TYPO3\CMS\Extbase\Attribute\RateLimit`
:New in: TYPO3 v14 (Feature `#108982 <https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.2/Feature-108982-IntroduceRateLimitingForExtbaseActions.html>`__)

Limits how often an action may be called within a time window, per visitor.
Useful for protecting form submission endpoints against brute-force and spam.

Full parameter reference and usage examples are coming in the Security chapter.
