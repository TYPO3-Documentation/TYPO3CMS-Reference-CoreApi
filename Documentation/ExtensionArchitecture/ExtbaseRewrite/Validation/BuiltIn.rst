:navigation-title: Built-in validators

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Built-in validators
..  _extbase-validation-builtin:

========================================================
Built-in validators and the :php:`#[Validate]` attribute
========================================================

Extbase ships a set of validators that cover the most common input constraints.
You attach them to action parameters or model properties using the
:php:`#[Validate]` attribute. Multiple :php:`#[Validate]` attributes on the
same target are treated as a conjunction — all of them must pass.

..  contents:: On this page
    :local:
    :depth: 2


..  _extbase-validation-builtin-syntax:

Syntax of the :php:`#[Validate]` attribute
==========================================

The attribute takes the validator name as its first argument and an optional
``options`` array:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\Attribute\Validate;
    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {
        #[Validate('NotEmpty')]
        #[Validate('StringLength', options: ['minimum' => 3, 'maximum' => 255])]
        protected string $title = '';

        #[Validate('EmailAddress')]
        protected string $contactEmail = '';
    }

The validator name can be either the short name (for built-in validators listed
below) or a fully qualified class name for :ref:`custom validators
<extbase-validation-custom>`:

..  code-block:: php
    :caption: Short name vs. fully qualified class name

    // Short name — built-in validators only
    #[Validate('NotEmpty')]

    // Fully qualified class name — required for custom validators
    #[Validate(\MyVendor\MyExtension\Validation\Validator\SlugValidator::class)]

..  _extbase-validation-builtin-empty:

Empty values and the acceptsEmptyValues flag
============================================

Most built-in validators skip validation when the value is :php:`null` or an
empty string. This is intentional: a field being blank is a separate concern
from it being in the wrong format. Combine with ``NotEmpty`` to enforce that
a field must be present *and* well-formed:

..  code-block:: php
    :caption: Requiring a non-empty, correctly formatted email address

    #[Validate('NotEmpty')]
    #[Validate('EmailAddress')]
    protected string $contactEmail = '';

Without ``NotEmpty``, an empty string passes ``EmailAddress`` validation
silently.


..  _extbase-validation-builtin-reference:

Built-in validator reference
============================

The following validators are provided out of the box. This list covers the
validators available for general use; file upload validators are listed
separately in :ref:`extbase-validation-builtin-file`.

..  _extbase-validation-builtin-notempty:

NotEmpty
--------

Rejects :php:`null`, empty strings, empty arrays, and
`Countable <https://www.php.net/manual/en/class.countable.php>`_ objects with
a count of zero. This is the only built-in validator that does *not* accept
empty values — it is always executed.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 15 60

   * - Option
     - Default
     - Description
   * - ``nullMessage``
     - built-in
     - Custom translation key or message shown when the value is :php:`null`.
   * - ``emptyMessage``
     - built-in
     - Custom translation key or message shown when the value is empty.


..  _extbase-validation-builtin-stringlength:

StringLength
------------

Checks that a string's character count (measured in UTF-8 characters) is
within the given bounds. Objects with a :php:`__toString()` method are
accepted and cast automatically.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 15 60

   * - Option
     - Default
     - Description
   * - ``minimum``
     - ``0``
     - Minimum number of characters required.
   * - ``maximum``
     - ``PHP_INT_MAX``
     - Maximum number of characters allowed.


..  _extbase-validation-builtin-numberrange:

NumberRange
-----------

Checks that a numeric value falls within a given range (inclusive). If
``minimum`` is greater than ``maximum``, the values are swapped silently.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\NumberRangeValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 15 60

   * - Option
     - Default
     - Description
   * - ``minimum``
     - ``0``
     - Minimum value accepted.
   * - ``maximum``
     - ``PHP_INT_MAX``
     - Maximum value accepted.


..  _extbase-validation-builtin-regularexpression:

RegularExpression
-----------------

Validates the value against a
`PCRE regular expression <https://www.php.net/manual/en/book.pcre.php>`_.
The expression is passed directly to :php:`preg_match()` — include the
delimiters.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\RegularExpressionValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 15 60

   * - Option
     - Default
     - Description
   * - ``regularExpression``
     - *(required)*
     - The full PCRE pattern including delimiters, for example ``'/^[a-z]+$/i'``.

..  code-block:: php
    :caption: Restricting a slug to lowercase letters and hyphens

    #[Validate('RegularExpression', options: ['regularExpression' => '/^[a-z0-9\-]+$/'])]
    protected string $slug = '';


..  _extbase-validation-builtin-emailaddress:

EmailAddress
------------

Checks that the value is a syntactically valid email address using
:php:`GeneralUtility::validEmail()`.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator`

No options beyond the optional ``message`` override (see
:ref:`extbase-validation-builtin-custom-messages`).


..  _extbase-validation-builtin-url:

Url
---

Checks that the value is a valid URL using :php:`GeneralUtility::isValidUrl()`.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\UrlValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-text:

Text
----

Checks that the value contains no HTML or XML tags (that is, the value equals
:php:`strip_tags($value)`). Useful for plain-text fields that must not accept
markup.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\TextValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-alphanumeric:

Alphanumeric
------------

Checks that the value contains only alphanumeric characters (letters and
digits). The exact character set depends on the locale.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\AlphanumericValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-integer:

Integer
-------

Checks that the value is a valid integer (or a string that represents one).

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\IntegerValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-float:

Float
-----

Checks that the value is a valid floating-point number (or a string that
represents one).

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\FloatValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-number:

Number
------

Checks that the value is numeric — accepts both integers and floats.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\NumberValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-boolean:

Boolean
-------

Checks that the value is a boolean. Useful for checkboxes where the mapping
must produce exactly :php:`true` or :php:`false`.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\BooleanValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-datetime:

DateTime
--------

Checks that the value is a :php:`\DateTime` or :php:`\DateTimeImmutable`
instance. Typically used after property mapping has already converted a string
to a date object.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\DateTimeValidator`

No options beyond the optional ``message`` override.


..  _extbase-validation-builtin-file:

File upload validators
======================

The following validators are specifically designed for
:php:`\TYPO3\CMS\Core\Http\UploadedFile` instances or
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` collections of uploaded
files. They are used in conjunction with the :php:`#[FileUpload]` attribute on
action parameters.

..  _extbase-validation-builtin-fileextension:

FileExtension
-------------

Checks that the uploaded file has one of the allowed extensions.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\FileExtensionValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 75

   * - Option
     - Description
   * - ``allowedExtensions``
     - Comma-separated list of allowed file extensions without leading dot,
       for example ``'jpg,jpeg,png'``.


..  _extbase-validation-builtin-filesize:

FileSize
--------

Checks that the uploaded file size falls within a given range.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\FileSizeValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 75

   * - Option
     - Description
   * - ``minimum``
     - Minimum file size as a string with unit, for example ``'0B'``.
   * - ``maximum``
     - Maximum file size as a string with unit, for example ``'5M'``.


..  _extbase-validation-builtin-mimetype:

MimeType
--------

Checks that the uploaded file's :abbr:`MIME (Multipurpose Internet Mail Extensions)` type is in the allowed list.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\MimeTypeValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 75

   * - Option
     - Description
   * - ``allowedMimeTypes``
     - Array of allowed MIME type strings, for example
       ``['image/jpeg', 'image/png']``.


..  _extbase-validation-builtin-imagedimensions:

ImageDimensions
---------------

Checks that an uploaded image's width and height fall within the given bounds.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\ImageDimensionsValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 75

   * - Option
     - Description
   * - ``minWidth``
     - Minimum image width in pixels.
   * - ``maxWidth``
     - Maximum image width in pixels.
   * - ``minHeight``
     - Minimum image height in pixels.
   * - ``maxHeight``
     - Maximum image height in pixels.


..  _extbase-validation-builtin-fileextensionmimetypeconsistency:

FileExtensionMimeTypeConsistency
--------------------------------

Cross-checks that the file's extension and its detected MIME type are
consistent with each other, guarding against disguised file uploads (for
example, a PHP file renamed to ``image.jpg``).

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\FileExtensionMimeTypeConsistencyValidator`

No configurable options.


..  _extbase-validation-builtin-filename:

FileName
--------

Checks that the uploaded file's name matches a given regular expression.

Class: :php:`\TYPO3\CMS\Extbase\Validation\Validator\FileNameValidator`

.. list-table::
   :header-rows: 1
   :widths: 25 75

   * - Option
     - Description
   * - ``regularExpression``
     - A PCRE pattern the file name must match.


..  _extbase-validation-builtin-custom-messages:

Customising error messages
==========================

Every built-in validator accepts one or more message options that replace the
default error text. Pass a plain string or a translation key.

The option key for each message is the name of the corresponding
:php:`protected string $…Message` property in the validator class — for
example :php:`$exceedMessage` becomes the ``exceedMessage`` option,
:php:`$nullMessage` becomes ``nullMessage``. Validators with only one error
condition use the generic ``message`` key. To find all available keys for a
given validator, check its :php:`$supportedOptions` array in the source at
:file:`EXT:extbase/Classes/Validation/Validator/`.

..  code-block:: php
    :caption: Custom message via translation key

    #[Validate('NotEmpty', options: [
        'nullMessage' => 'my_extension:error.title.required',
    ])]
    protected string $title = '';

..  code-block:: php
    :caption: Custom inline message (useful during development)

    #[Validate('StringLength', options: [
        'maximum' => 255,
        'exceedMessage' => 'The title must not exceed 255 characters.',
    ])]
    protected string $title = '';

Using translation keys is strongly recommended for anything visible to site
visitors.


..  _extbase-validation-builtin-next:

What to read next
=================

*   :ref:`extbase-validation-custom` — write a validator for domain rules that
    the built-in validators cannot express.
*   :ref:`extbase-validation-overview` — how validation fits into the request
    lifecycle and how :php:`errorAction()` is triggered.

