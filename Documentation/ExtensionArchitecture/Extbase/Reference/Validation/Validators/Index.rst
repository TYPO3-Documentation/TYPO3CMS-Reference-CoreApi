:navigation-title: List of Validators

..  include:: /Includes.rst.txt
..  _extbase-validator:

=======================================
Built-in validators provided by Extbase
=======================================

This document lists all built-in Extbase validators,
along with example usage for each using PHP attributes.

..  seealso::
    *   `Using validation for Extbase models and controllers <https://docs.typo3.org/permalink/t3coreapi:extbase-validation>`_
    *   `Custom Extbase validator implementation <https://docs.typo3.org/permalink/t3coreapi:extbase-domain-validator>`_

..  contents:: Validators in Extbase

..  _extbase-validator-alphanumeric:

AlphanumericValidator
=====================

Checks that a value contains **only letters and numbers** — no spaces, symbols,
or special characters.

This includes letters from **many languages**, not just A–Z. For example,
letters from alphabets like **Hebrew, Arabic, Cyrillic**, and others are also
allowed.

This is useful for fields like usernames or codes where only plain text
characters are allowed.

If you want to allow any symbols (like `@`, `#`, `-`) or spaces, use the
`RegularExpressionValidator <https://docs.typo3.org/permalink/t3coreapi:extbase-validator-regularexpression>`_
instead.

..  code-block:: php

    #[Validate(['validator' => 'Alphanumeric'])]
    protected string $username;

..  _extbase-validator-boolean:

BooleanValidator
================

Checks if a value matches a specific boolean value (`true` or `false`).

This validator is useful when you want to enforce that a property explicitly
evaluates to either `true` or `false`, such as for checkboxes in forms.

By default, it accepts any boolean value unless the `is` option is
set.

Options:

`is`
    Interprets strings `'true'`, `'1'`, `'false'`, `'0'`, or `''`.
    Values of other types are converted to boolean directly.

Ensure that a value is a boolean (no strict check, default behavior):

..  code-block:: php

    #[Validate(['validator' => 'Boolean'])]
    protected $isActive;

Require that a value must be `true` (e.g. checkbox must be checked):

..  code-block:: php

    #[Validate(['validator' => 'Boolean', 'options' => ['is' => true]])]
    protected bool $termsAccepted;

Require that a value must be `false`:

..  code-block:: php

    #[Validate(['validator' => 'Boolean', 'options' => ['is' => false]])]
    protected bool $isBlocked;

..  _extbase-validator-collection:

CollectionValidator
===================

The `CollectionValidator` is a built-in Extbase validator for validating arrays
or collections, such as arrays of DTOs or `ObjectStorage<T>` elements.

It allows you to apply a single validation to **each individual item** in a
collection. The validation is recursive: every item is passed through the
validator you specify.

`elementValidator`
    The name or class of a validator that should be applied
    to each item in the collection (e.g. `'NotEmpty'`, `'EmailAddress'`).
`elementType`
    The class name of the collection's element type. All
    registered validators for that type will be applied to each item.

You must provide **either** `elementValidator` or `elementType`.

..  include:: _NoExamples.rst.txt

Use cases:

-   Validating dynamic or repeatable form fields (e.g. multiple answers)
-   Validating input arrays from multi-select fields or checkboxes
-   Validating each related object in an `ObjectStorage` property

..  note::
    Validation will be skipped if neither `elementValidator` nor
    `elementType` is set.

..  _extbase-validator-conjunction:

ConjunctionValidator
====================

The `ConjunctionValidator` allows you to combine multiple validators into a
**logical AND**. All validators in the conjunction must return valid results
for the overall validation to pass.

This validator is typically **used internally** by Extbase when multiple
`#[Validate]` attributes are defined on a property or when validator
conjunctions are configured in the validator resolver.

Behavior:

-   All validators in the conjunction are applied to the value.
-   If **any validator fails**, the entire validation fails.
-   Errors from all failing validators are combined in the result.

While this validator is often constructed internally, you can also define your
own validator combinations manually in the validator resolver or via custom
validators.

..  include:: _NoExamples.rst.txt

..  note::
    If you use multiple `#[Validate(...)]` attributes on a single
    property, Extbase automatically applies them using a `ConjunctionValidator`.
    You do not need to instantiate it manually in most use cases.

..  _extbase-validator-datetime:

DateTimeValidator
=================

Ensures a value is a valid \DateTimeInterface.

..  code-block:: php

    #[Validate(['validator' => 'DateTime'])]
    protected mixed $startDate;

..  _extbase-validator-disjunction:

DisjunctionValidator
====================

The `DisjunctionValidator` is a composite Extbase validator that allows you to
combine multiple validators using a **logical OR**.

It is the inverse of the `ConjunctionValidator`: the value is considered valid
if **at least one** of the nested validators succeeds.

**Behavior:**
-   All validators are evaluated in order.
-   Validation stops as soon as one validator passes.
-   If **all validators fail**, their errors are merged and returned.
-   If **any validator passes**, the result is considered valid.

**Use cases:**

Use this validator when a value is allowed to match **one of multiple conditions**.
For example:
-   A field can be either empty or a valid email
-   A string can be either a number or "N/A"
-   A value can match one of multiple formats

**Usage:**

This validator is typically used manually in custom validators or
in validator resolver configurations.

..  include:: _NoExamples.rst.txt

..  note::

    Extbase does **not** automatically construct disjunctions for you.
    You must manually create and configure a `DisjunctionValidator` when needed.

    It is not currently possible to use this validator directly via
    `#[Validate(...)]` annotations.

..  _extbase-validator-emailaddress:

EmailAddressValidator
=====================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator`
an email address using method :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail()`.

..  code-block:: php

    #[Validate(['validator' => 'EmailAddress'])]
    protected string $email;

..  _extbase-validator-file-name:

FileNameValidator
=================

The :php-short:`TYPO3\CMS\Extbase\Validation\Validator\FileNameValidator`
validates, that the given :php-short:`\TYPO3\CMS\Core\Http\UploadedFile` or
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` with objects of type `UploadedFile`
objects does not contain a PHP executable file by checking the given file
extension.

Internally the :php:`\TYPO3\CMS\Core\Resource\Security\FileNameValidator` is
used to validate the file name.

..  include:: _NoExamples.rst.txt

..  _extbase-validator-file-size:

FileSizeValidator
=================

The :php-short:`TYPO3\CMS\Extbase\Validation\Validator\FileSizeValidator`
validates, that the given :php-short:`\TYPO3\CMS\Core\Http\UploadedFile`
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` with objects of type `UploadedFile`
objects do not exceed the file size configured via the options.

Options:

`minimum`
    The minimum file size to accept in bytes, accepts `K` / `M` / `G` suffixes
`maximum`
    The maximum file size to accept


Internally :php:`\TYPO3\CMS\Core\Type\File\FileInfo` is used to determine the
size.

..  include:: _NoExamples.rst.txt

..  _extbase-validator-float:

FloatValidator
==============

Checks if a value is a floating point number.

..  code-block:: php

    #[Validate(['validator' => 'Float'])]
    protected float $price;

..  _extbase-validator-image-dimensions:

ImageDimensionsValidator
========================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\ImageDimensionsValidator`
validates image dimensions of a given :php-short:`\TYPO3\CMS\Core\Http\UploadedFile` or
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` with objects of type `UploadedFile`
objects.

Options:

`width`
    The exact width of the image
`height`
    The exact height of the image
`minWidth`
    The minimum width of the image
`maxWidth`
    The maximum width of the image
`minHeight`
    The minimum height of the image
`maxHeight`
    The maximum height of the image

..  include:: _NoExamples.rst.txt

..  _extbase-validator-integer:

IntegerValidator
================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\IntegerValidator`
ensures that a value is an integer.

This validator is useful for validating numeric fields that must contain whole
numbers, such as quantities, IDs, or counters.

#[Validate(['validator' => 'Integer'])]
protected mixed $quantity;

..  code-block:: php

    #[Validate(['validator' => 'Integer'])]
    protected mixed $quantity;

..  _extbase-validator-mime-type:

MimeTypeValidator
=================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\MimeTypeValidator`
validates MIME types of a given :php-short:`\TYPO3\CMS\Core\Http\UploadedFile` or
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` with objects of type `UploadedFile`
objects.

Does also validate, if the extension of the validated file matches the allowed file extensions
for the detected MIME type.

Options:

`allowedMimeTypes`
    Allowed MIME types (using */* IANA media types)

`ignoreFileExtensionCheck`
    If set to :php:`true`, the file extension check is disabled.
    Be aware of security considerations when setting this to :php:`true`.

..  include:: _NoExamples.rst.txt

..  _extbase-validator-notempty:

NotEmptyValidator
=================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator`
ensures that a value is not considered empty.

"Empty" in this context means:

-   An empty string (`''`)
-   `null`
-   An empty array (`[]`)
-   An empty :php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`
-   Any empty countable object like :php:`\SplObjectStorage`

This validator is commonly used to enforce required fields.

..  code-block:: php

    #[Validate(['validator' => 'NotEmpty'])]
    protected string $title;

..  _extbase-validator-numberrange:

NumberRangeValidator
====================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\NumberRangeValidator`
checks that a number falls within a specified numeric range.

This validator supports integers and floats and is useful for validating
percentages, prices, limits, or any numeric input with minimum and/or maximum
constraints.

..  _extbase-validator-numberrange-options:

Validator options
-----------------

`minimum`
    Lower boundary of the valid range (inclusive).

`maximum`
    Upper boundary of the valid range (inclusive).

`message`
    Custom error message or translation key for out-of-range values.

If only `minimum` is set, the validator checks for values **greater than
or equal to** that minimum.

If only `maximum` is set, it checks for values **less than or equal to**
that maximum.

You may use both together to define an inclusive range.

..  _extbase-validator-numberrange-example:

Example: Validate percentage
----------------------------

..  code-block:: php

    use TYPO3\CMS\Extbase\Annotation\Validate;

    class SettingsForm
    {
        #[Validate([
            'validator' => 'NumberRange',
            'options' => ['minimum' => 1, 'maximum' => 100],
        ])]
        protected int $percentage;
    }

..  _extbase-validator-regularexpression:

RegularExpressionValidator
==========================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\RegularExpressionValidator`
checks whether a given value matches a specified regular expression (regex).
It is useful for validating custom string formats that are not covered by
built-in validators.

For example, it can enforce ID formats, postal codes, or other structured
inputs.

..  note::
    The default error message of the RegularExpressionValidator looks very
    cryptic for end users as it repeats the regular expression. Provide
    an individualized error message.

Options:

`regularExpression`
    The regular expression to validate against.
    Must be a valid PCRE pattern, including delimiters (e.g. `/^...$/`).

`message`
    Custom error message or translation key. If not set, a localized default
    message will be used. The default message looks cryptic and should not be
    shown to website visitors as-is.

Validation behavior:

-   If the value does not match, an error is added.
-   If the regex is invalid, an exception is thrown.
-   The validator supports localized error messages via `LLL:EXT:...` syntax.

..  _extbase-validator-regularexpression-example-basic:

Example: username pattern
-------------------------

Validate that a value contains only alphanumeric characters:

..  code-block:: php

    use TYPO3\CMS\Extbase\Annotation\Validate;

    class UserForm
    {
        #[Validate([
            'validator' => 'RegularExpression',
            'options' => [
                'regularExpression' => '/^[a-z0-9]+$/i'
            ]
        ])]
        public string $username = '';
    }

..  _extbase-validator-regularexpression-example-zip:

Example: ZIP code
-----------------

Validate a 5-digit postal code with a custom error message:

..  code-block:: php

    use TYPO3\CMS\Extbase\Annotation\Validate;

    class AddressForm
    {
        #[Validate([
            'validator' => 'RegularExpression',
            'options' => [
                'regularExpression' => '/^\d{5}$/',
                'message' => 'Bitte eine gültige Postleitzahl eingeben.'
            ]
        ])]
        public string $postalCode = '';
    }

..  _extbase-validator-regularexpression-use-cases:

Use cases
---------

-   Custom identifiers or slugs
-   Postal/ZIP code validation
-   Specific numeric or alphanumeric patterns

..  _extbase-validator-regularexpression-important:

Important
---------

Use this validator only for formats that are not supported by dedicated
validators. Prefer these built-in validators when applicable:

-   `EmailAddressValidator` – for email addresses
-   `DateTimeValidator` – for dates
-   `UrlValidator` – for URLs

These are easier to configure, localized by default, and more robust.

..  note::

    - This is a valid list inside a note.
    - Just make sure it's indented consistently.

..  _extbase-validator-stringlength:

StringLengthValidator
=====================

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator`
validates the length of a string.

The check is also multi-byte save. For example "Ö" is counted as ONE charakter.

Options:

`minimum`
    Minimum length for a valid string. Defaults to `0`. If it is 0 empty
    strings are allowed.
`maximum`
    Maximum length for a valid string.

..  code-block:: php

    #[Validate([
        'validator' => 'StringLength',
        'options' => ['minimum' => 5, 'maximum' => 50],
    ])]
    protected string $description;

..  _extbase-validator-string:

StringValidator
===============

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\StringValidator`
validates that a mixed variable is a string. Fails for array, numbers and bools.

..  code-block:: php

    #[Validate(['validator' => 'String'])]
    protected mixed $comment;

..  _extbase-validator-text:

TextValidator
=============

Checks if the given value is a valid text (contains no HTML/XML tags).

..  note::
    Be aware that the value of this check entirely depends on the output context.
    The validated text is not expected to be secure in every circumstance, if you
    want to be sure of that, use a customized regular expression or filter on output.

..  code-block:: php

    #[Validate(['validator' => 'Text'])]
    protected string $comment;

..  _extbase-validator-url:

UrlValidator
============

The :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\UrlValidator` checks
whether a given string is a valid web URL.

It uses TYPO3’s internal utility method
:php-short:`\TYPO3\CMS\Core\Utility\GeneralUtility::isValidUrl()` to determine
whether the URL is valid.

Only well-formed URLs with a supported scheme such as `http://` or `https://`
will be accepted.

..  _extbase-validator-url-behavior:

Validation behavior
-------------------

-   Only string values are accepted.
-   The URL must include a valid scheme (e.g. `https://`).
-   Validation will fail for incomplete or malformed URLs.

..  _extbase-validator-url-example-basic:

Example: Validate a web URL
---------------------------

This example ensures that a field contains a valid external website address.

..  code-block:: php

    use TYPO3\CMS\Extbase\Annotation\Validate;

    class UserProfile
    {
        #[Validate(['validator' => 'Url'])]
        protected string $website = '';
    }

..  _extbase-validator-url-use-cases:

Use cases
---------

-   Website or blog URLs
-   Social media profile links
-   User-submitted external links

..  _extbase-validator-multiple-example:

Multiple validators example
===========================

You can apply multiple validators on a single property.

..  code-block:: php

    #[Validate(['validator' => 'NotEmpty'])]
    #[Validate([
        'validator' => 'StringLength',
        'options' => ['minimum' => 3, 'maximum' => 20],
    ])]
    protected string $nickname;
