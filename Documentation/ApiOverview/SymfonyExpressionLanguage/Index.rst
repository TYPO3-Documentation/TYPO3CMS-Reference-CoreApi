.. include:: /Includes.rst.txt
.. index:: Symfony expression language
.. _symfony-expression-language:

===========================
Symfony expression language
===========================

Symfony expression language is used by TYPO3 in certain places. These are
documented in the following sections, together with explanations how they can be
extended:

.. contents:: This page
   :backlinks: top
   :class: compact-list
   :local:


.. index:: pair: Symfony expression language; TypoScript
.. _sel-within-typoscript-conditions:

Symfony within TypoScript conditions
====================================

In order to provide custom conditions, its essential to understand how
conditions are written. Refer to :ref:`typoscript-syntax-conditions-syntax` for details.

Conditions are evaluated by the `Symfony Expression Language`_ and are evaluated
to boolean results. Therefore an integrator can write :ts:`[true === true]`
which would evaluate to true. In order to provide further functionality within
conditions, the Symfony Expression Language needs to be extended. There are two
parts that can be added to the language, which are variables and functions.

The following sections explain how to add variables and functions.


.. index:: pair: Symfony expression language; Custom provider
.. _sel-ts-registering-new-provider-within-extension:

Registering new provider within an extension
============================================

There has to be a provider, no matter whether variables or functions will be provided.

The provider is registered in the extension file :file:`/Configuration/ExpressionLanguage.php`, depending on
the extension's custom PHP class name::

   <?php

   return [
       'typoscript' => [
           \Vendor\ExtensionName\ExpressionLanguage\CustomTypoScriptConditionProvider::class,
       ]
   ];


This will register the defined :php:`CustomTypoScriptConditionProvider` PHP class as provider within the context `typoscript`.


.. _sel-ts-implement-provider-within-extension:

Implement provider within extension
===================================

The provider itself is written as PHP Class within the extension file
:file:`/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php`, depending on
the formerly registered PHP class name::

   <?php

   namespace Vendor\ExtensionName\ExpressionLanguage;

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

Additional variables can already be provided within the
:php:`CustomTypoScriptConditionProvider` PHP class::

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
           $this->expressionLanguageVariables = [
               'variableA' => 'valueB',
           ];
       }
   }

In above example a new variable `variableA` with value `valueB` is added, this
can be used within conditions:

.. code-block:: typoscript

   [variableA === 'valueB']
       page >
       page = PAGE
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]


.. _sel-ts-additional-functions:

Additional functions
====================

Additional functions can be provided through another class, which has to be
returned by the example :php:`CustomTypoScriptConditionProvider` PHP class::

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
           $this->expressionLanguageProviders = [
               CustomConditionFunctionsProvider::class,
           ];
       }
   }

The returned class will look like the following::

   <?php

   namespace Vendor\ExtensionName\TypoScript;

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
           // TODO: Implement
       }
   }


The class is already trying to return a new :php:`ExpressionFunction`, but
currently lacks implementation. That is the last step::

   protected function getWebserviceFunction(): ExpressionFunction
   {
       return new ExpressionFunction('webservice', function () {
           // Not implemented, we only use the evaluator
       }, function ($existingVariables, $endpoint, $uid) {
           return GeneralUtility::getUrl(
               'https://example.com/endpoint/'
               . $endpoint
               .  '/'
               . $uid
           );
       });
   }

The first argument :php:`$existingVariables` is an array of which each associative key corresponds to a registered variable.

   *  request (TYPO3\CMS\Core\ExpressionLanguage\RequestWrapper)
   *  applicationContext - string
   *  typo3 . stdClass
   *  tree - stdClass
   *  frontend - stdClass
   *  backend - stdClass
   *  workspace - stdClass
   *  page - array: page record

If you need an undefined number of variables, then you can write the same function in a variadic form::

    // ...
    }, function (...$args) {
        $existingVariables = $args['0'];
        // ...
    }


All further arguments are provided by TypoScript. The above example could look like:

.. code-block:: typoscript

   [webservice('pages', 10)]
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

If a simple string like a page title is returned, this can be further compared:

.. code-block:: typoscript

   [webservice('pages', 10) === 'Expected page title']
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

Further information about :php:`ExpressionFunction` can be found within `Symfony
Expression Language - Registering Functions`_

.. _Symfony Expression Language: https://symfony.com/doc/current/components/expression_language.html
.. _Symfony Expression Language - Registering Functions: https://symfony.com/doc/current/components/expression_language/extending.html#registering-functions
