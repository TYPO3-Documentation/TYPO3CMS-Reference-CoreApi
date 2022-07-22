
.. index:: Extbase; Annotations
.. _extbase_available-annotations:

Available annotations
^^^^^^^^^^^^^^^^^^^^^

All available annotations for Extbase are placed within the namespace :php:`TYPO3\CMS\Extbase\Annotation`.
They can be imported into the current namespace, e.g.:

.. code-block:: php
   :caption: EXT:blog_example/Classes/Controller/BlogController.php


   use TYPO3\CMS\Extbase\Annotation\ORM\Transient;

   /**
    * @Transient
    * @var Foo
    */
   public $property;

It is completely valid and will be parsed. It is considered to be best practice to
use the following instead, in order to make the source of annotation more
transparent:

.. code-block:: php
   :caption: EXT:blog_example/Classes/Controller/BlogController.php

   use TYPO3\CMS\Extbase\Annotation as Extbase;

   /**
    * @Extbase\Transient
    * @var Foo
    */
   public $property;

The following annotations are available out of the box within Extbase:

:php:`@TYPO3\CMS\Extbase\Annotation\Validate`
   Allows to configure validators for properties and method arguments:


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * Existing TYPO3 validator.
       *
       * @Extbase\Validate("EmailAddress")
       */
      protected $email = '';

      /**
       * Existing TYPO3 validator with options.
       *
       * @Extbase\Validate("StringLength", options={"minimum": 1, "maximum": 80})
       */
      protected $title = '';

      /**
       * Custom validator identified by FQCN.
       *
       * @Extbase\Validate("\Vendor\ExtensionName\Validation\Validator\CustomValidator")
       */
      protected $bar;

      /**
       * Custom Validator identified by dot syntax, with additional parameters.
       *
       * @Extbase\Validate("Vendor.ExtensionName:CustomValidator", param="barParam")
       */
      public function barAction(string $barParam)
      {
          return '';
      }

   The above list provides all possible references to a validator. Available
   validators shipped with Extbase can be found within
   :file:`EXT:extbase/Classes/Validation/Validator/`.

:php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation()`
   Allows to ignore Extbase default validation for a given argument, in context
   of an controller.

   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php


      /**
       * @Extbase\IgnoreValidation("param")
       */
      public function method($param)
      {
      }

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")`
   Allows to remove child entities during deletion of aggregate root.


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Cascade("remove")
       */
      public $property;

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Transient`
   Marks property as transient (not persisted).


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Transient
       */
      public $property;

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy`
   Marks property to be lazily loaded on first access.


   .. code-block:: php
      :caption: EXT:blog_example/Classes/Controller/BlogController.php

      /**
       * @Extbase\ORM\Lazy
       */
      public $property;
