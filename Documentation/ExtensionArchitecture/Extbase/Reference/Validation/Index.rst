:navigation-title: Validation

..  include:: /Includes.rst.txt
..  index:: Extbase, Validation
..  _extbase-validation:

===================================================
Using validation for Extbase models and controllers
===================================================

..  seealso::
    *  :ref:`extbase_domain_validator` on how to write a custom validator.

Extbase provides a number of validators for standard use cases such as
e-mail addresses, string length, not empty etc.

All validators need to be explicitly applied by the attribute
:ref:`extbase-attribute-validate` to either a
controller action or a property / setter in a model.

It is also possible to write custom validators for properties or complete
models. See chapter :ref:`Custom validators <extbase_domain_validator>` for
more information.

..  contents:: Table of contents

..  toctree::
    :caption: Subpages
    :glob:
    :titlesonly:

    */Index

..  _extbase-validation-why:

Why is validation needed?
=========================

People often assume that domain objects are consistent and adhere to
some rules at all times.

Unfortunately, this is not achieved automatically. So it is important to
define such rules explicitly.

In the blog example for the model :php:`Person` the following rules can
be defined

*   First name and last name should each have no more then 80 chars.
*   A last name should have at least 2 chars.
*   The parameter :php:`email` has to contain a  valid email address.

These rules are called *invariants*, because they must be
valid during the entire lifetime of the object.

At the beginning of your project, it is important to consider which
invariants your domain objects will consist of.

..  _extbase-validation-when:

When does validation take place?
================================

Domain objects in Extbase are validated only at one point in time:
When they are used as parameter in a controller action.

When a user sends a request, Extbase first determines which action
within the controller is responsible for this request.

Extbase then maps the arguments so that they fit types as defined in the
actions method signature.

If there are validators defined for the action these are applied before
the actual action method is called.

When the validation fails the method
:ref:`errorAction() <extbase_class_hierarchy-catching_validation_errors_with_error_action>`
of the current controller is called.

..  _extbase-validation-model:

Validation of model properties
==============================

..  versionchanged:: 14.0
    Passing a configuration array to the FileUpload attribute has been deprecated.
    Configuration must be provided via attribute arguments. See
    `Migration and version compatibility (TYPO3 v13 → v14) <https://docs.typo3.org/permalink/t3coreapi:extbase-validation-migration>`_.

You can define simple validation rules in the domain model by the attribute
:ref:`extbase-attribute-validate`.

**Example:**

..  literalinclude:: ../_Attributes/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

In this code section the validator :php:`StringLength` provided by Extbase
in class :php:`\TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator`
is applied with one argument.

Validation messages from included Extbase validators can be overwritten
using validator options. It is possible to provide either a translation key or
a custom message as string.

..  _extbase-validation-migration:

Migration and version compatibility (TYPO3 v13 → v14)
-----------------------------------------------------

With TYPO3 v14, passing a configuration array as the first argument to validation
attributes (for example :php:`#[Validate([ ... ])]`) has been deprecated
(:ref:`Deprecation #97559 <changelog:deprecation-97559-1760453281>`).
A new syntax using attribute arguments was introduced with TYPO3 v14.

The deprecated array-based syntax continues to work in TYPO3 v14 but will be
removed with TYPO3 v15.

..  important::

    There is **no validation attribute syntax that is compatible with both
    TYPO3 v13 and TYPO3 v14**.

    PHP attributes are parsed statically and cannot be conditionally defined
    based on the TYPO3 version. Extensions that support TYPO3 v13 and v14 in the
    same release must therefore continue to use the array-based syntax and accept
    the deprecation warning in TYPO3 v14.

..  code-block:: php
    :caption: Example (TYPO3 v13 and v14 compatible)

    // TODO: Switch to named arguments when dropping TYPO3 v13 support (Deprecation #97559).
    #[Validate([
        'validator' => 'StringLength',
        'options' => ['maximum' => 150],
    ])]

..  code-block:: php
    :caption: Example (TYPO3 v14+, recommended)

    #[Validate(
        validator: 'StringLength',
        options: ['maximum' => 150],
    )]

TYPO3 Rector (:composer:`ssch/typo3-rector`) has rule
:php:`\Ssch\TYPO3Rector\TYPO314\v0\MigratePassingAnArrayOfConfigurationValuesToExtbaseAttributesRector` to
automatically migrate from the annotation syntax to the attribute syntax.

..  _extbase-validation-controller:

Validation of controller arguments
==================================

..  deprecated:: 14.0
    Applying controller argument validation at **method level** has been
    deprecated. Define validators at **argument level** from
    TYPO3 v14.

..  versionchanged:: 14.0
    Passing a configuration array to the FileUpload attribute has been deprecated.
    Configuration must be provided via attribute arguments. See
    `Migration and version compatibility (TYPO3 v13 → v14) <https://docs.typo3.org/permalink/t3coreapi:extbase-validation-migration>`_.

You can also define controller argument validators:

**Example:**

..  code-block:: php
    :caption: Examples for controller argument validators

    public function submitAction(
        #[Validate(validator: 'EmailAddress')]
        string $email,
    ): ResponseInterface {
        // Do something...
    }

The following rules validate each controller argument:

*  If the argument is a domain object, the attributes
   :php:`\TYPO3\CMS\Extbase\Attribute\Validate` in the domain object are taken into
   account.

*  If there is set an attribute
   :php:`\TYPO3\CMS\Extbase\Attribute\IgnoreValidation` for the argument,
   no validation is done. This option must not be used when working with
   extbase file upload, because it leads to a property mapping error.

*  Validators added in the attribute of the action are applied.

If the arguments of an action are invalid, the
:ref:`errorAction <extbase_class_hierarchy-catching_validation_errors_with_error_action>`
is executed. By default a HTTP response with status 400 is returned. If possible
the user is forwarded to the previous action. This behaviour can be overridden
in the controller.

..  _extbase-validation-arguments:

PHP Attribut syntax of validators with arguments
================================================

Validators can be called with zero, one or more arguments. See the following
examples:

..  literalinclude:: ../_Attributes/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Person.php, modified

Available validators shipped with Extbase can be found within
:file:`EXT:extbase/Classes/Validation/Validator/`.

..  _extbase-validation-manual-creation:

Manually call a validator
==========================

It is possible to call a validator in your own code with the method
:php:`\TYPO3\CMS\Extbase\Validation\ValidatorResolver::createValidator()`.

However please note that the class :php-short:`\TYPO3\CMS\Extbase\Validation\ValidatorResolver` is marked as
:php:`@internal` and it is therefore not advisable to use it.
