.. include:: /Includes.rst.txt

.. index:: Extbase, Validation

.. _extbase_validation:

==========
Validation
==========

.. seealso::
   *  :ref:`extbase_domain_validator` on how to write a custom validator.

Extbase provides a number of validators for standard use cases such as
e-mail addresses, string length, not empty etc.

All validators need to be explicitly applied by the annotation
:ref:`extbase-annotation-validate` to either a
controller action or a property / setter in a model.

It is also possible to write custom validators for properties or complete
models. See chapter :ref:`Custom validators <extbase_domain_validator>` for
more information.

Why is validation needed?
=========================

People often assume that domain objects are consistent and adhere to
some rules at all times.

Unfortunately, this is not achieved automatically. So it is important to
define such rules explicitly.

In the blog example for the model :php:`Person` the following rules can
be defined

*  First name and last name should each have no more then 80 chars.
*  A last name should have at least 2 chars.
*  The parameter :php:`email` has to contain a  valid email address.

These rules are called *invariants*, because they must be
valid during the entire lifetime of the object.

At the beginning of your project, it is important to consider which
invariants your domain objects will consist of.

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

Validation of model properties
===============================

You can define simple validation rules in the domain model by the annotation
:ref:`extbase-annotation-validate`.

**Example:**

..  literalinclude:: _Annotations/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

In this code section the validator :php:`StringLength` provided by Extbase
in class :php:`\TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator`
is applied with one argument.

Validation of controller arguments
===================================

The following rules validate each controller argument:

*  If the argument is a domain object, the annotations
   :php:`\TYPO3\CMS\Extbase\Annotation\Validate` in the domain object are taken into
   account.

*  If there is set an annotation
   :php:`\TYPO3\CMS\Extbase\Annotation\IgnoreValidation` for the argument,
   no validation is done.

*  Validators added in the annotation of the action are applied.

If the arguments of an action are invalid, the
:ref:`errorAction <extbase_class_hierarchy-catching_validation_errors_with_error_action>`
is executed. By default a HTTP response with status 400 is returned. If possible
the user is forwarded to the previous action. This behaviour can be overridden
in the controller.

Annotations with arguments
===========================

Annotations can be called with zero, one or more arguments. See the following
examples:

..  literalinclude:: _Annotations/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Person.php, modified

Available validators shipped with Extbase can be found within
:file:`EXT:extbase/Classes/Validation/Validator/`.


Manually call a validator
==========================

It is possible to call a validator in your own code with the method
:php:`\TYPO3\CMS\Extbase\Validation\ValidatorResolver::createValidator()`.

However please note that the class :php:`ValidatorResolver` is marked as
:php:`@internal` and it is therefore not advisable to use it.
