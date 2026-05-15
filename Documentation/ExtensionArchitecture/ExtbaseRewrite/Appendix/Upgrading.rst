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

..  code-block:: php
    :caption: Before — DocBlock annotation (ignored in TYPO3 v14)

    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
    use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

    class Entity extends AbstractEntity
    {
        /**
         * @var ObjectStorage<ChildEntity>
         * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
         */
        protected ObjectStorage $property;
    }

..  code-block:: php
    :caption: After — native PHP attribute

    use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
    use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

    class Entity extends AbstractEntity
    {
        #[Lazy()]
        protected ObjectStorage $property;
    }

..  seealso::

    + `ExtbaseAnnotationToAttributeRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#extbaseannotationtoattributerector>`__


..  _extbase-upgrading-attribute-namespace:

Attribute namespace moved from Annotation to Attribute (TYPO3 v14)
===================================================================

..  versionchanged:: 14.0

    The namespace :php:`\TYPO3\CMS\Extbase\Annotation` is deprecated. Class
    aliases remain available in v14 but will be removed in v15.

All Extbase attributes moved from :php:`\TYPO3\CMS\Extbase\Annotation` to
:php:`\TYPO3\CMS\Extbase\Attribute`. Update your :php:`use` statements
when dropping TYPO3 v13 support.


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

    `MigratePassingAnArrayOfConfigurationValuesToExtbaseAttributesRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#migratepassinganarrayofconfigurationvaluestoextbaseattributesrector>`__


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
