:navigation-title: Custom Validator

.. include:: /Includes.rst.txt
.. index:: Extbase; Validator
.. _extbase_domain_validator:

=======================================
Custom Extbase validator implementation
=======================================

.. seealso::
   *  :ref:`extbase_validation` for general validation in Extbase.

Custom validators are located in the directory :file:`Classes/Domain/Validator`
and therefore in the namespace :php:`Vendor\MyExtension\Domain\Validator`.

All validators extend the :php:`AbstractValidator`
(:php:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`).

.. note::
   In the package :php:`\TYPO3\CMS\Extbase\Validation\Validator\*` Extbase
   offers many validators for default requirements like the validation of
   emails, numbers and strings. You do not need to implement such basic
   checks yourself.

Custom validator for a property of the domain model
====================================================

When the standard validators provided by Extbase are not sufficient you can
write a custom validators to use on the property of a domain model:

.. include:: /CodeSnippets/Extbase/Validator/PropertyValidator.rst.txt

The method :php:`isValid()` does not return a value. In case of an error it
adds an error to the validation result by calling method :php:`addError()`.
The long number added as second parameter of this function is the current UNIX
time in the moment the error message was first introduced. This way all errors
can be uniquely identified.

This validator can be used for any string property of model now by including it
in the annotation of that parameter:

..  literalinclude:: _PropertyValidatorUsage.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

.. note::
   Validators added to a property of a model are executed whenever an object
   of that model is passed to a controller action as a parameter.

   The validation of the parameter can be disabled by the annotation
   :ref:`extbase-annotation-ignore-validation`.

Complete domain model validation
=================================

At certain times in the life cycle of a model it can be necessary to validate
the complete domain model. This is usually done before calling a certain action
that will persist the object.

.. include:: /CodeSnippets/Extbase/Validator/ObjectValidator.rst.txt

If the error is related to a specific property of the domain object, the
function :php:`addErrorForProperty()` should be used instead of :php:`addError()`.

The validator is used as annotation in the action methods of the controller:

..  literalinclude:: _ObjectValidatorUsage.php
    :caption: EXT:blog_example/Classes/Controller/BlogController.php, modified

Dependency injection in validators
==================================

Starting with TYPO3 v12 Extbase validators are capable of :ref:`dependency injection <Dependency-Injection>`
without further configuration, you can use the constructor method:

..  literalinclude:: _MyCustomValidator.php
    :language: php
    :caption: EXT:my_extension/Classes/Validators/MyCustomValidator.php

Extensions that want to support both TYPO3 v12 and v11 have to implement the
method :php:`setOptions` and use the injector method for dependency injection:

..  literalinclude:: _MyCustomValidatorv11v12.php
    :language: php
    :caption: EXT:my_extension/Classes/Validators/MyCustomValidator.php

Additionally, the validator requiring dependency injection has to be registered
in the extension's :file:`Services.yaml` until TYPO3 v11 support is dropped:

..  literalinclude:: _Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml
