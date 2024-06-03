.. include:: /Includes.rst.txt
.. _LanguageService-api:

===============
LanguageService
===============

This class is used to translate strings in plain PHP. For examples
see :ref:`extension-localization-php`. A :php:`LanguageService` **should not**
be created directly, therefore its constructor is internal. Create a
:php:`LanguageService` with the :ref:`LanguageServiceFactory-api`.

In the backend context a :php:`LanguageService` is stored in the global
variable :php:`$GLOBALS['LANG']`.
In the frontend it can be accessed via the contentObject:

..  code-block:: php
    :caption: Classes/Controller/ExampleController.php

    class ExampleController {
        /**
        * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
        */
        public $cObj;

        public function __construct () {

            $this->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        }

        public function process () {
           ...
           $label = $this->cObj->getData('lll:EXT:my_extension/Resources/Private/Language/locallang.xlf:labels.exampleLabel');
           ...
        }


..  include:: _LanguageService.rst.txt
