.. include:: /Includes.rst.txt

.. index:: Extbase, Validation

==========
Validation
==========

You can write your own validators for domain models. These must be located in
the folder :file:`Domain/Validator/`, they must be named exactly as the corresponding
domain model, but with the suffix Validator and implement the interface
:php:`\TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface`. For more details, see the
following section.


.. todo: This is no longer true. The concept of automatically called domain validators is removed.

Validation API
--------------

.. todo: Add new API must-haves, empty values and configure options, etc.

Extbase provides a generic validation system that is used in many places in Extbase. Extbase
provides validators for common data types, but you can also write your own validators. Each
Validator implements the :php:`\TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface`
that defines the following methods:

.. include:: /CodeSnippets/Extbase/Api/ValidatorInterface.rst.txt

In most use cases extending the abstract class
:php:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator` is sufficient
however.

You can call Validators in your own code with the method `createValidator($validatorName,
$validatorOptions)` in :php:`\TYPO3\CMS\Extbase\Validation\ValidatorResolver`. Though in
general, this is not necessary. Validators are often used in conjunction with domain objects and
controller actions.


Validation of model properties
------------------------------

You can define simple validation rules in the domain model by annotation. For
this, you use the annotation `@TYPO3\CMS\Extbase\Annotation\Validate` with the properties of the object. A brief
example:

*Example B-4: validation in the domain object*

.. code-block:: php
   :caption: EXT:blog_example/Classes/Domain/Model/Blog.php

    namespace Ex\BlogExample\Domain\Model;

    /**
     * A single blog that has multiple posts and can be read by users.
     */
    class Blog extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
    {
        /**
         * The blog's title.
         *
         * @var string
         * @TYPO3\CMS\Extbase\Annotation\Validate("Text")
         * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 1, "maximum": 80})
         */
        protected $title;

        // the class continues here
    }

In this code section, the validators for the `$title` attribute of the Blog object is defined. `$title`
must be a text (i.e., no HTML is allowed), and also the length of the string is checked with the
`StringLength`-Validator (it must be between 1 and 80 characters). Commas can separate several validators
for a property.Parameters of the validators are set in parentheses. You can omit the
quotes for validator options if they are superfluous, as in the example above. If complex validation
rules are necessary (for example, multiple fields to be checked for equality), you must implement
your own validator.


Validation of controller arguments
----------------------------------

The following rules validate each controller argument:

* If the argument has a simple type (string, integer, etc.), this type is checked.
  .. todo: Not any more!

* If the argument is a domain object, the annotations `@TYPO3\CMS\Extbase\Annotation\Validate` in the domain object is taken into
  account, and - if set - the appropriate validator in the folder :file:`Domain/Validator` for the
  existing domain object is run.
  .. todo: Not any more!

* If there is set an annotation :php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation` for the argument,
  no validation is done.
* Additional validation rules can be specified via further `@TYPO3\CMS\Extbase\Annotation\Validate` annotations in the methods
  PHPDoc block.
  .. todo: ALL validators need to be specified with this annotation!

If an action's arguments can not be validated, then the `errorAction` is executed, which will
usually jump back to the last screen. Validation mustn't be performed in certain
cases. Further information for the usage of the annotation :php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation` see
":ref:`case_study-edit_an_existing_object`" in Chapter 9.

.. todo: "If the arguments of an action can not be validated,...". This is misleading. It should
say, "If the arguments of an action are invalid,..."
