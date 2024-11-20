.. include:: /Includes.rst.txt
.. index:: Symfony expression language
.. _symfony-expression-language:

===========================
Symfony expression language
===========================

Symfony expression language (SEL) is used by TYPO3 in a couple of places. The most
well-known ones are :ref:`TypoScript conditions <t3tsref:typoscript-syntax-global-condition>`.
The :ref:`TypoScript <t3tsref:conditions>` and :ref:`TSconfig <t3tsref:tsconfig-conditions>` references list
available variables and functions of these contexts. But the TYPO3 Core API allows
enriching expressions with additional functionality, which is what this chapter is about.


Main API
========

The TYPO3 Core API provides a relatively slim API in front of the Symfony expression
language: Symfony expressions are used in different contexts (TypoScript conditions,
the EXT:form framework, maybe more).

The class :php:`TYPO3\CMS\Core\ExpressionLanguage\Resolver` is used to prepare the
expression language processor based on a given context (identified by a string,
for example "typoscript"), and loads registered available variables and functions
for this context.

The :ref:`System > Configuration <ext_lowlevel:module-configuration>` module
provides a list of all registered Symfony expression language providers.

Evaluation of single expressions is then initiated calling
:php:`$myResolver->evaluate()`. While TypoScript casts the return value to :php:`bool`,
Symfony expression evaluation can potentially return :php:`mixed`.


.. index::
   pair: Symfony expression language; Custom provider
   pair: Symfony expression language; TypoScript
.. _sel-within-typoscript-conditions:
.. _sel-ts-registering-new-provider-within-extension:

Registering new provider
========================

There has to be a provider, no matter whether variables or functions will be provided.
A provider is registered in the extension file :file:`Configuration/ExpressionLanguage.php`.
This will register the defined :php:`CustomTypoScriptConditionProvider` PHP class as
provider within the context `typoscript`.

.. code-block:: php
   :caption: EXT:some_extension/Configuration/ExpressionLanguage.php

   return [
       'typoscript' => [
           \MyVendor\SomeExtension\ExpressionLanguage\CustomTypoScriptConditionProvider::class,
       ]
   ];


.. _sel-ts-implement-provider-within-extension:

Implementing a provider
=======================

The provider is a PHP class like :file:`/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php`,
depending on the formerly registered PHP class name:

.. code-block:: php
   :caption: EXT:some_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

   namespace MyVendor\SomeExtension\ExpressionLanguage;

   use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
       }
   }


.. _sel-ts-additional-variables:

Additional variables
====================

Additional variables can be provided by the registered provider class.
In practice, adding additional variables is used rather seldom: To
access state, they tend to use :php:`$GLOBALS`, which in general is not
a good idea. Instead, consuming code should provide available variables
by handing them over to the :php:`Resolver` constructor already.
The example below adds a new variable `variableA` with value `valueB`:

.. code-block:: php
   :caption: EXT:some_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
           $this->expressionLanguageVariables = [
               'variableA' => 'valueB',
           ];
       }
   }

.. _sel-ts-additional-functions:

Additional functions
====================

Additional functions can be provided with another class that has to be
registered in the provider:

.. code-block:: php
   :caption: EXT:some_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
           $this->expressionLanguageProviders = [
               CustomConditionFunctionsProvider::class,
           ];
       }
   }

The (artificial) implementation below calls some external URL based on given variables:

.. code-block:: php
   :caption: EXT:some_extension/Classes/ExpressionLanguage/CustomConditionFunctionsProvider.php

   namespace Vendor\SomeExtension\TypoScript;

   use Symfony\Component\ExpressionLanguage\ExpressionFunction;
   use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

   class CustomConditionFunctionsProvider implements ExpressionFunctionProviderInterface
   {
       public function getFunctions()
       {
           return [
               $this->getWebserviceFunction(),
           ];
       }

       protected function getWebserviceFunction(): ExpressionFunction
       {
           return new ExpressionFunction(
               'webservice',
               static fn () => null, // Not implemented, we only use the evaluator
               static function ($arguments, $endpoint, $uid) {
                   return GeneralUtility::getUrl(
                       'https://example.org/endpoint/'
                       . $endpoint
                       . '/'
                       . $uid
                   );
               }
           );
       }
   }

A usage example in TypoScript could be this:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

   [webservice('pages', 10)]
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

   # Or compare the result of the function to a string
   [webservice('pages', 10) === 'Expected page title']
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

   # if there are no parameters, your own conditions still need brackets
   [conditionWithoutParameters()]
       # do something
   [GLOBAL]
