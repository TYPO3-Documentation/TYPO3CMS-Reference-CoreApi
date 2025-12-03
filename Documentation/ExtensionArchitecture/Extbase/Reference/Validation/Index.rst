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

..  versionchanged:: 13.2
    All validation messages from included Extbase validators can now be overwritten
    using validator options. It is possible to provide either a translation key or
    a custom message as string.

You can define simple validation rules in the domain model by the attribute
:ref:`extbase-attribute-validate`.

**Example:**

..  literalinclude:: ../_Attributes/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

In this code section the validator :php:`StringLength` provided by Extbase
in class :php:`\TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator`
is applied with one argument.

..  _extbase-validation-controller:

Validation of controller arguments
==================================

..  deprecated:: 14.0
    Applying controller argument validation at **method level** has been
    deprecated. Define validators at **argument level** from
    TYPO3 v14.

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
