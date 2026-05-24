:navigation-title: Upgrading from older versions

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Upgrading
..  _extbase-upgrading:

=====================================
Upgrading from older Extbase versions
=====================================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page collects breaking changes and the migration steps needed when
upgrading an Extbase extension to a newer TYPO3 version. Each entry names
what changed, which version introduced the change, and what to do.

.. tip::

    Many migrations can be automated, and TYPO3 Rector (:composer:`ssch/typo3-rector`) provides
    rules to do so. The tool is actively maintained and extended for each TYPO3 version to be
    released.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-upgrading-annotations-to-attributes:

Annotations replaced by PHP attributes (TYPO3 v12 / required from v14)
=======================================================================

..  versionchanged:: 14.0

    DocBlock annotation support was fully removed. Extbase ignores annotations
    silently — no error is thrown.

Native PHP attributes (introduced in PHP 8.0) replace the Doctrine-based
DocBlock annotation syntax. Extbase has supported PHP attributes since
TYPO3 v12; in TYPO3 v14 the annotation syntax was removed entirely.

+-----------------------------------+-----------------------------------+
| Old annotation (removed in v14)   | New PHP attribute                 |
+===================================+===================================+
| ``@Extbase\ORM\Lazy``             | ``#[Lazy]``                       |
+-----------------------------------+-----------------------------------+
| ``@Extbase\ORM\Cascade("remove")``| ``#[Cascade('remove')]``          |
+-----------------------------------+-----------------------------------+
| ``@Extbase\ORM\Transient``        | ``#[Transient]``                  |
+-----------------------------------+-----------------------------------+
| ``@Extbase\Validate(...)``        | ``#[Validate(...)]``              |
+-----------------------------------+-----------------------------------+
| ``@Extbase\IgnoreValidation``     | ``#[IgnoreValidation]``           |
+-----------------------------------+-----------------------------------+

..  code-block:: diff
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

     use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
    +use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
     use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

     class Entity extends AbstractEntity
     {
    -    /**
    -     * @var ObjectStorage<ChildEntity>
    -     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
    -     */
    +    #[Lazy]
         protected ObjectStorage $property;
     }

..  seealso::

    + `ExtbaseAnnotationToAttributeRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#extbaseannotationtoattributerector>`_


..  _extbase-upgrading-attribute-namespace:

Attribute namespace moved from Annotation to Attribute (TYPO3 v14)
===================================================================

..  versionchanged:: 14.0

    The namespace :php:`\TYPO3\CMS\Extbase\Annotation` is deprecated. Class
    aliases remain available in v14 but will be removed in v15. Update your
    :php:`use` statements to :php:`\TYPO3\CMS\Extbase\Attribute` when dropping
    TYPO3 v13 support.

All Extbase attributes moved from :php:`\TYPO3\CMS\Extbase\Annotation` to
:php:`\TYPO3\CMS\Extbase\Attribute`.


..  _extbase-upgrading-attribute-array-syntax:

Attribute array syntax deprecated (TYPO3 v14, removed in v15)
==============================================================

..  versionchanged:: 14.0

    Passing a configuration array as the first argument to Extbase attributes
    is deprecated (:ref:`Deprecation #97559 <changelog:deprecation-97559-1760453281>`).
    The array-based syntax still works in v14 but will be removed in v15.

+-------------------------------------------------+-----------------------------+
| Old array syntax (deprecated in v14)            | New named-argument syntax   |
+=================================================+=============================+
| ``#[Cascade(['value' => 'remove'])]``           | ``#[Cascade('remove')]``    |
+-------------------------------------------------+-----------------------------+
| ``#[Validate(['validator' => 'NotEmpty'])]``    | ``#[Validate('NotEmpty')]`` |
+-------------------------------------------------+-----------------------------+

..  important::

    There is **no attribute syntax that is compatible with both TYPO3 v13 and
    v14**. PHP attributes are parsed statically and cannot be conditionally
    defined based on the TYPO3 version. Extensions supporting both versions in
    the same release must keep the array-based syntax and accept the deprecation
    warning in v14.


..  seealso::

    `MigratePassingAnArrayOfConfigurationValuesToExtbaseAttributesRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#migratepassinganarrayofconfigurationvaluestoextbaseattributesrector>`_


..  _extbase-upgrading-magic-findby:

Magic findBy*(), findOneBy*(), countBy*() methods removed (TYPO3 v14)
======================================================================

..  versionchanged:: 14.0

    Magic property-name methods were deprecated in TYPO3 v12.3 and removed in
    v14. Replace them with the explicit array-based signatures.

+------------------------------+------------------------------------+
| Old (removed in v14)         | New                                |
+==============================+====================================+
| ``findByTitle($value)``      | ``findBy(['title' => $value])``    |
+------------------------------+------------------------------------+
| ``findOneByTitle($value)``   | ``findOneBy(['title' => $value])`` |
+------------------------------+------------------------------------+
| ``countByTitle($value)``     | ``count(['title' => $value])``     |
+------------------------------+------------------------------------+

:php:`findByUid()` and :php:`findByIdentifier()` are not affected and remain
available.

..  seealso::

    :ref:`t3coreapi/13:extbase-repository-find-by-magic-migration` — the
    migration guide in the TYPO3 v13 branch of this manual.


..  _extbase-upgrading-standalone-view:

StandaloneView removed (TYPO3 v14)
===================================

..  versionchanged:: 14.0

    :php:`\TYPO3\CMS\Fluid\View\StandaloneView` was deprecated in TYPO3 v13
    and removed in v14. The replacement is
    :php-short:`\TYPO3\CMS\Core\View\ViewFactoryInterface` together with
    :php-short:`\TYPO3\CMS\Core\View\ViewFactoryData`.

:php:`StandaloneView` was the historical way to render a Fluid template outside
of a controller — for example in a service class, a scheduler task, or a mail
renderer. It is no longer available.

The replacement injects :php-short:`\TYPO3\CMS\Core\View\ViewFactoryInterface`
and creates a view by passing a
:php-short:`\TYPO3\CMS\Core\View\ViewFactoryData` value object:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Service/MailService.php

    use TYPO3\CMS\Core\View\ViewFactoryData;
    use TYPO3\CMS\Core\View\ViewFactoryInterface;

    class MailService
    {
        public function __construct(
            protected readonly ViewFactoryInterface $viewFactory,
        ) {}

        public function renderTemplate(ServerRequestInterface $request): string
        {
            $view = $this->viewFactory->create(new ViewFactoryData(
                templateRootPaths: ['EXT:my_extension/Resources/Private/Templates/'],
                partialRootPaths: ['EXT:my_extension/Resources/Private/Partials/'],
                layoutRootPaths: ['EXT:my_extension/Resources/Private/Layouts/'],
                request: $request,
            ));
            $view->assign('data', $this->loadData());
            return $view->render('Mail/Notification');
        }
    }

Pass the current :php:`ServerRequestInterface` wherever possible — the view
factory uses it for request-aware rendering (language, base URI, etc.).

..  seealso::

    *   `Deprecation: #104773 — Custom Fluid views and Extbase <https://docs.typo3.org/permalink/changelog:deprecation-104773-1724942036>`_
        — the changelog entry with the full migration notes.


..  _extbase-upgrading-plugin-list-type:

list_type plugin removed; fifth parameter of configurePlugin() restricted (TYPO3 v14)
======================================================================================

..  versionchanged:: 14.0

    The ``list_type`` / "General Plugin" content element was removed. All
    plugins must be registered as dedicated ``CType`` content elements. The
    fifth parameter ``$pluginType`` of :php:`ExtensionUtility::configurePlugin()`
    now only accepts ``'CType'`` (or being omitted); any other value throws an
    :php:`\InvalidArgumentException` (:ref:`Important #105538 <changelog:important-105538-1730752784>`).

Older extensions may pass
:php:`ExtensionUtility::PLUGIN_TYPE_PLUGIN_LIST` (``'list_type'``) as the
fifth argument, or register their plugin with a ``list_type`` TCA entry. Both
approaches no longer work in TYPO3 v14.

**What to do:**

*   Remove the fifth argument from :php:`configurePlugin()` entirely, or pass
    :php:`ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT` explicitly.
*   Run the TYPO3 upgrade wizard to migrate existing ``list_type`` content
    records to dedicated ``CType`` records.

..  seealso::

    *   `Registering an Extbase frontend plugin <https://docs.typo3.org/permalink/extbase-registration-frontend-plugin>`_
        — current registration approach.

    *   `Plugin registered with list_type no longer works <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-list-type>`_
        — the common pitfalls entry.


..  _extbase-upgrading-translation-domain-syntax:

Translation domain syntax as shorter alternative to LLL:EXT: (TYPO3 v14)
=========================================================================

..  versionadded:: 14.0

    A shorter domain-based syntax for label references was introduced as an
    alternative to the legacy ``LLL:EXT:`` file path syntax
    (:ref:`Feature #93334 <changelog:feature-93334-1729000000>`).

The legacy syntax remains fully supported and is not deprecated. Both forms
resolve to the same translation entries and can be used interchangeably:

+--------------------------------------------------------------------+------------------------------------+
| Legacy syntax                                                      | Domain syntax (v14+)               |
+====================================================================+====================================+
| ``LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:key``    | ``my_ext:key``                     |
+---------------------------------------------------------------+-----------------------------------------+
| ``LLL:EXT:my_ext/Resources/Private/Language/locallang_db.xlf:key`` | ``my_ext.db:key``                  |
+---------------------------------------------------------------+-----------------------------------------+

The domain is formed from the extension key plus an optional resource name. The
resource name is the language file name without the ``locallang_`` prefix and
without the ``.xlf`` extension. The plain ``locallang.xlf`` file has no
resource suffix — the domain is just the extension key.

..  seealso::

    *   :ref:`label-reference-domain` — full syntax reference and resolution
        rules including the :bash:`language:domain:list` CLI command.
