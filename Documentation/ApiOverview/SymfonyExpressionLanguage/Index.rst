.. include:: /Includes.rst.txt
.. index:: Symfony expression language
.. _symfony-expression-language:

===========================
Symfony expression language
===========================

Symfony expression language is used by TYPO3 in certain places. These are
documented in below sections, together with explanations how they can be
extended:

.. contents::
   :depth: 2


.. index:: pair: Symfony expression language; TypoScript
.. _sel-within-typoscript-conditions:

Within TypoScript conditions
============================

In order to provide custom conditions, its essential to understand how
conditions are written. Refer to :ref:`typoscript-syntax-conditions-syntax` if
syntax of conditions is not known yet.

Conditions are evaluated by the `Symfony Expression Language`_ and are evaluated
to boolean results. Therefore an integrator can write :ts:`[true === true]`
which would evaluate to true. In order to provide further functionality within
conditions, the Symfony Expression Language needs to be extended. There are two
parts that can be added to the language, which are variables and functions.

The following section explain how to add variables and functions.


.. index:: pair: Symfony expression language; Custom provider
.. _sel-ts-registering-new-provider-within-extension:

Registering new provider within an extension
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

There has to be a provider, no matter whether variables or functions should be provided.

The provider is registered within :file:`/Configuration/ExpressionLanguage.php`::

   <?php
   return [
       'typoscript' => [
           \Vendor\ExtensionName\ExpressionLanguage\CustomTypoScriptConditionProvider::class,
       ]
   ];

This will register the defined class as provider within context `typoscript`.

.. _sel-ts-implement-provider-within-extension:

Implement provider within extension
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The provider itself is written as PHP Class within
:file:`/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php`, depending on
registered class name::

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
^^^^^^^^^^^^^^^^^^^^

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
can be used within Conditions:

.. code-block:: typoscript

   [variableA === 'valueB']
       page >
       page = PAGE
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

.. _sel-ts-additional-functions:

Additional functions
^^^^^^^^^^^^^^^^^^^^

Additional functions can be provided through another class, which has to be
returned by :php:`CustomTypoScriptConditionProvider` PHP class::

   class CustomTypoScriptConditionProvider extends AbstractProvider
   {
       public function __construct()
       {
           $this->expressionLanguageProviders = [
               CustomConditionFunctionsProvider::class,
           ];
       }
   }

The returned class looks like the following::

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
currently lacks implementation. That's the last step::

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

The first argument :php:`$existingVariables` always provides all registered variables to the function.
All further arguments need to be provided by TypoScript. The above example could look like:

.. code-block:: typoscript

   [webservice('pages', 10)]
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

In case a simple string like a title is returned this can be further checked:

.. code-block:: typoscript

   [webservice('pages', 10) === 'Expected title']
       page.10 >
       page.10 = TEXT
       page.10.value = Matched
   [GLOBAL]

Further information about :php:`ExpressionFunction` can be found within `Symfony
Expression Language - Registering Functions`_

.. _Symfony Expression Language: https://symfony.com/doc/current/components/expression_language.html
.. _Symfony Expression Language - Registering Functions: https://symfony.com/doc/current/components/expression_language/extending.html#registering-functions
