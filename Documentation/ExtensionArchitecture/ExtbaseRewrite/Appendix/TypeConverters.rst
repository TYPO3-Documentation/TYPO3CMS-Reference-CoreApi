:navigation-title: Type converters reference

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Type converters
..  _extbase-appendix-typeconverters:

==========================================
Extbase built-in type converters reference
==========================================

Extbase selects a type converter automatically based on the PHP type
declaration of the action parameter and the shape of the incoming request
value. This page lists all converters shipped with TYPO3 v14, their accepted
source types, and the configuration constants they expose.

For an introduction to how type converters are selected and configured, see
:ref:`extbase-controller-propertymapping`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-appendix-typeconverters-scalar:

Scalar type converters
======================

These converters handle PHP primitive types and are selected automatically
whenever an action parameter is typed as :php:`int`, :php:`float`,
:php:`bool`, or :php:`string`.

..  _extbase-appendix-typeconverters-integer:

IntegerConverter
----------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\IntegerConverter`
:Sources: :php:`integer`, :php:`string`
:Target: :php:`integer`
:Priority: 10

Casts the source value to :php:`int`. Returns an error object if the value is
not numeric.

No configuration constants.


..  _extbase-appendix-typeconverters-float:

FloatConverter
--------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\FloatConverter`
:Sources: :php:`float`, :php:`integer`, :php:`string`
:Target: :php:`float`
:Priority: 10

Casts the source value to :php:`float`. When the source is a string,
thousands separator and decimal point characters can be configured:

:php:`FloatConverter::CONFIGURATION_THOUSANDS_SEPARATOR`
    Character used as the thousands separator in the input string (for
    example :php:`'.'` for German locale). Default: none.

:php:`FloatConverter::CONFIGURATION_DECIMAL_POINT`
    Character used as the decimal separator in the input string (for
    example :php:`','` for German locale). Default: :php:`'.'`.


..  _extbase-appendix-typeconverters-boolean:

BooleanConverter
----------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\BooleanConverter`
:Sources: :php:`boolean`, :php:`string`
:Target: :php:`boolean`
:Priority: 10

Casts the source value to :php:`bool` via a PHP typecast.

No configuration constants.


..  _extbase-appendix-typeconverters-string:

StringConverter
---------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\StringConverter`
:Sources: :php:`string`, :php:`integer`
:Target: :php:`string`
:Priority: 10

Casts the source value to :php:`string` via a PHP typecast.

No configuration constants.


..  _extbase-appendix-typeconverters-array:

ArrayConverter
--------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\ArrayConverter`
:Sources: :php:`array`, :php:`string`
:Target: :php:`array`
:Priority: 10

Passes an array source through unchanged. When the source is a string,
splits it on a configurable delimiter:

:php:`ArrayConverter::CONFIGURATION_DELIMITER`
    The delimiter character to split the string on. Required when the
    source is a non-empty string; throws a
    :php-short:`\TYPO3\CMS\Extbase\Property\Exception\TypeConverterException`
    if not set.

:php:`ArrayConverter::CONFIGURATION_REMOVE_EMPTY_VALUES`
    When :php:`true`, filters out empty strings after splitting. Default:
    :php:`false`.

:php:`ArrayConverter::CONFIGURATION_LIMIT`
    Maximum number of elements to return (passed as the third argument to
    :php:`explode()`). Default: :php:`0` (no limit).


..  _extbase-appendix-typeconverters-datetime:

DateTimeConverter
=================

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter`
:Sources: :php:`string`, :php:`integer`, :php:`array`
:Target: :php:`DateTime` (or :php:`DateTimeImmutable`)
:Priority: 10

Converts a string, Unix timestamp, or array of date parts into a
:php:`\DateTime` or :php:`\DateTimeImmutable` object.

:php:`DateTimeConverter::CONFIGURATION_DATE_FORMAT`
    The format string passed to :php:`\DateTime::createFromFormat()`. Defaults
    to :php:`\DateTime::W3C`. Set this when your form sends a date in a locale
    format (for example :php:`'d.m.Y'`).

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

    public function initializeCreateAction(): void
    {
        $this->arguments['conference']
            ->getPropertyMappingConfiguration()
            ->forProperty('conferenceDate')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'd.m.Y',
            );
    }


..  _extbase-appendix-typeconverters-object:

Object type converters
======================

These converters handle PHP objects and are selected automatically when an
action parameter is typed as a domain object, an enum, or
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`.


..  _extbase-appendix-typeconverters-persistentobject:

PersistentObjectConverter
-------------------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter`
:Sources: :php:`integer`, :php:`string`, :php:`array`
:Target: :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject` (and subclasses)
:Priority: 20

The converter used for domain object parameters. When the source is an
integer or plain string, it loads the record with that UID from the
repository. When the source is an array, it maps array keys to object
properties (and optionally creates or modifies the object):

:php:`PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED`
    Set to :php:`true` to allow property updates on an object that already
    has a UID. Required when an array payload includes an :php:`__identity`
    key alongside changed properties.

:php:`PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED`
    Set to :php:`true` to allow creating a new object from an array payload
    that carries no :php:`__identity` key.

Both constants default to :php:`false`. When a :php:`__trustedProperties`
token is present (generated by :html:`<f:form>`), Extbase enables or disables
them automatically based on whether an :php:`__identity` field was rendered.


..  _extbase-appendix-typeconverters-objectconverter:

ObjectConverter
---------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\ObjectConverter`
:Sources: :php:`array`
:Target: :php:`object`
:Priority: 10

Creates a plain (non-persistent) PHP object from an array of constructor
arguments or property values. Used for value objects and
:abbr:`DTO (Data Transfer Object)` classes that do not extend
:php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject`.

:php:`ObjectConverter::CONFIGURATION_TARGET_TYPE`
    Override the concrete class to instantiate (must be a subclass of the
    declared target type).

:php:`ObjectConverter::CONFIGURATION_OVERRIDE_TARGET_TYPE_ALLOWED`
    Set to :php:`true` to permit the :php:`CONFIGURATION_TARGET_TYPE`
    override. Disabled by default as a security measure.


..  _extbase-appendix-typeconverters-objectstorage:

ObjectStorageConverter
----------------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\ObjectStorageConverter`
:Sources: :php:`string`, :php:`array`
:Target: :php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`
:Priority: 10

Converts an array (or comma-separated string) into an
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`. Each element is
converted individually using the converter registered for the storage's
generic type.

No configuration constants.


..  _extbase-appendix-typeconverters-enum:

EnumConverter
-------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\EnumConverter`
:Sources: :php:`string`, :php:`integer`, :php:`float`
:Target: :php:`object` (any :php:`\UnitEnum` subclass)
:Priority: 20

..  versionadded:: 14.0

Converts a scalar value to a PHP backed enum case. For backed enums the
source value is matched against the :php:`value` of each case; for pure
(unit) enums it is matched against the case :php:`name`.

No configuration constants.


..  _extbase-appendix-typeconverters-core:

TYPO3 Core type converters
==========================

These converters handle TYPO3-specific types and are selected automatically
when the action parameter is typed accordingly.


..  _extbase-appendix-typeconverters-coretype:

CoreTypeConverter
-----------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\CoreTypeConverter`
:Sources: :php:`string`, :php:`integer`, :php:`float`, :php:`boolean`, :php:`array`
:Target: :php-short:`\TYPO3\CMS\Core\Type\TypeInterface`
:Priority: 10

Handles TYPO3 Core value types implementing
:php-short:`\TYPO3\CMS\Core\Type\TypeInterface`, such as
:php-short:`\TYPO3\CMS\Core\Type\Enumeration` subclasses.

No configuration constants.


..  _extbase-appendix-typeconverters-country:

CountryConverter
----------------

:Class: :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\CountryConverter`
:Sources: :php:`string`
:Target: :php-short:`\TYPO3\CMS\Core\Country\Country`
:Priority: 10

Looks up a :php-short:`\TYPO3\CMS\Core\Country\Country` object by ISO code.
Defaults to matching by alpha-2 code (for example :php:`'DE'`):

:php:`CountryConverter::CONFIGURATION_FROM`
    How to match the source string. Accepted values:

    *   :php:`'alpha2IsoCode'` (default) — two-letter ISO 3166-1 alpha-2 code.
    *   :php:`'alpha3IsoCode'` — three-letter ISO 3166-1 alpha-3 code.


..  _extbase-appendix-typeconverters-fal:

FAL type converters
-------------------

..  warning::

    These three converter classes carry :php:`@internal` at the class level
    and are not part of the public Extbase API. Their behaviour or existence
    may change without notice.

:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\FileConverter`
    Converts an integer (file UID) or string to a
    :php-short:`\TYPO3\CMS\Extbase\Domain\Model\File` object.

:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\FileReferenceConverter`
    Converts an integer (file reference UID) to a
    :php-short:`\TYPO3\CMS\Extbase\Domain\Model\FileReference` object.

:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\FolderConverter`
    Converts a string (folder combined identifier) to a
    :php-short:`\TYPO3\CMS\Extbase\Domain\Model\Folder` object.


..  _extbase-appendix-typeconverters-custom:

Writing a custom type converter
===============================

There is no PHP attribute for registering a type converter. Registration
requires a :yaml:`extbase.type_converter` service tag in
:file:`Configuration/Services.yaml`.

Implement
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverterInterface` (or extend
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter`)
and add the tag:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Property/TypeConverter/IsbnConverter.php

    namespace MyVendor\MyExtension\Property\TypeConverter;

    use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
    use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;

    class IsbnConverter extends AbstractTypeConverter
    {
        public function convertFrom(
            $source,
            string $targetType,
            array $convertedChildProperties = [],
            ?PropertyMappingConfigurationInterface $configuration = null,
        ): mixed {
            // return the converted value or a \TYPO3\CMS\Extbase\Error\Error instance
        }
    }

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Property\TypeConverter\IsbnConverter:
      tags:
        - name: extbase.type_converter
          priority: 10
          target: MyVendor\MyExtension\Domain\Model\Isbn
          sources: string

The :yaml:`priority` determines which converter wins when multiple converters
match the same source-and-target combination. Higher numbers win.