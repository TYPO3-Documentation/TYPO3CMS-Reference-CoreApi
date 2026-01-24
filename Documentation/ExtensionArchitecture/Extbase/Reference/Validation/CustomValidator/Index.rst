:navigation-title: Custom Validator

.. include:: /Includes.rst.txt
.. index:: Extbase; Validator
.. _extbase_domain_validator:

=======================================
Custom Extbase validator implementation
=======================================

..  seealso::
    *   :ref:`extbase_validation` for general validation in Extbase.

Custom validators are located in the directory :file:`Classes/Domain/Validator`
and therefore in the namespace :php:`MyVendor\MyExtension\Domain\Validator`.

All validators must implement :php-short:`TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface`.
They usually extend the :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`.

..  note::
    In the directory :php:`\TYPO3\CMS\Extbase\Validation\Validator\*` Extbase
    offers many validators for default requirements like the validation of
    emails, numbers and strings. You do not need to implement such basic
    checks yourself.

..  versionchanged:: 14.0
    Passing a configuration array to the FileUpload attribute has been deprecated.
    Configuration must be provided via attribute arguments. See
    `Migration and version compatibility (TYPO3 v13 → v14) <https://docs.typo3.org/permalink/t3coreapi:extbase-validation-migration>`_.

..  _extbase_domain_validator-model:

Custom validator for a property of the domain model
====================================================

When the standard validators provided by Extbase are not sufficient you can
write a custom validators to use on the property of a domain model:

..  include:: /CodeSnippets/Extbase/Validator/PropertyValidator.rst.txt

The method :php:`isValid()` does not return a value. In case of an error it
adds an error to the validation result by calling method :php:`addError()`.
The long number added as second parameter of this function is the current UNIX
time in the moment the error message was first introduced. This way all errors
can be uniquely identified.

This validator can be used for any string property of model now by including it
in the attribute of that parameter:

..  literalinclude:: _PropertyValidatorUsage.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

..  note::
    Validators added to a property of a model are executed whenever an object
    of that model is passed to a controller action as a parameter.

    The validation result of the parameter can be ignored by using the attribute
    :ref:`extbase-attribute-ignore-validation`.

..  _extbase_domain_validator-model-complete:

Complete domain model validation
=================================

At certain times in the life cycle of a model it can be necessary to validate
the complete domain model. This is usually done before calling a certain action
that will persist the object.

..  include:: /CodeSnippets/Extbase/Validator/ObjectValidator.rst.txt

If the error is related to a specific property of the domain object, the
function :php:`addErrorForProperty()` should be used instead of :php:`addError()`.

The validator is used as attribute in the action methods of the controller:

..  literalinclude:: _ObjectValidatorUsage.php
    :caption: EXT:blog_example/Classes/Controller/BlogController.php, modified

..  _extbase_domain_validator-di:

Dependency injection in validators
==================================

Extbase validators are capable of :ref:`dependency injection <Dependency-Injection>`
without further configuration, you can use the constructor method:

..  literalinclude:: _MyCustomValidator.php
    :caption: EXT:my_extension/Classes/Domain/Validators/MyCustomValidator.php

..  _extbase_domain_validator-request:

Request object in Extbase validators
====================================

..  versionadded:: 13.2
    Extbase :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`
    provides a getter and a setter for the PSR-7 Request object.

You can use the PSR-7 request object in a validator, for example to get
the site settings:

..  literalinclude:: _RequestValidator.php
    :caption: EXT:my_extension/Classes/Domain/Validators/MyCustomValidator.php
