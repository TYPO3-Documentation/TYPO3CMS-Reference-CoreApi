:navigation-title: Symfony expression language

..  include:: /Includes.rst.txt
..  index:: Symfony expression language
..  _symfony-expression-language:

=================================
Symfony expression language (SEL)
=================================

Symfony expression language (SEL) is used by TYPO3 in a couple of places. The most
well-known ones are :ref:`TypoScript conditions <t3tsref:typoscript-syntax-global-condition>`.
The :ref:`TypoScript <t3tsref:conditions>` and :ref:`TSconfig <t3tsref:tsconfig-conditions>` references list
available variables and functions of these contexts. But the TYPO3 Core API allows
enriching expressions with additional functionality, which is what this chapter is about.

..  contents:: Table of contents

..  _symfony-expression-language-api:

Main API of the Symfony expression language
===========================================

The TYPO3 Core API provides a relatively slim API in front of the Symfony expression
language: Symfony expressions are used in different contexts (TypoScript conditions,
the EXT:form framework, maybe more).

The class :php:`\TYPO3\CMS\Core\ExpressionLanguage\Resolver` is used to prepare the
expression language processor based on a given context (identified by a string,
for example "typoscript"), and loads registered available variables and functions
for this context.

The :ref:`System > Configuration <ext_lowlevel:module-configuration>` module
provides a list of all registered Symfony expression language providers.

Evaluation of single expressions is then initiated calling
:php:`$myResolver->evaluate()`. While TypoScript casts the return value to :php:`bool`,
Symfony expression evaluation can potentially return :php:`mixed`.

..  index::
    pair: Symfony expression language; Custom provider
    pair: Symfony expression language; TypoScript
..  _sel-within-typoscript-conditions:
..  _sel-ts-registering-new-provider-within-extension:

Registering a custom Symfony expression provider
================================================

There has to be a provider, no matter whether variables or functions will be provided.
A provider is registered in the extension file :file:`Configuration/ExpressionLanguage.php`.

The following example registers the defined PHP class as
provider within the context `typoscript`.

..  literalinclude:: _codesnippets/_ExpressionLanguage.php
    :caption: EXT:my_extension/Configuration/ExpressionLanguage.php

..  _sel-ts-implement-provider-within-extension:

Implementing a custom Symfony expression provider
=================================================

The provider is a PHP class like the following, depending on the formerly
registered PHP class name:

..  literalinclude:: _codesnippets/_CustomTypoScriptConditionProviderEmpty.php
    :caption: EXT:my_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

..  _sel-ts-additional-variables:

Additional variables
--------------------

Additional variables can be provided by the registered provider class.
In practice, adding additional variables is used rather seldom: To
access state, they tend to use :php:`$GLOBALS`, which in general is not
a good idea. Instead, consuming code should provide available variables
by handing them over to the :php:`Resolver` constructor already.
The example below adds a new variable `variableA` with value `valueB`:

..  literalinclude:: _codesnippets/_CustomTypoScriptConditionProviderA.php
    :caption: EXT:my_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

..  _sel-ts-additional-functions:

Additional functions
--------------------

Additional functions can be provided with another class that has to be
registered in the provider:

..  literalinclude:: _codesnippets/_CustomConditionFunctionsProvider.php
    :caption: EXT:my_extension/Classes/ExpressionLanguage/CustomTypoScriptConditionProvider.php

The (artificial) implementation below calls some external URL based on given variables:

..  literalinclude:: _codesnippets/_CustomConditionFunctionsProvider.php
    :caption: EXT:my_extension/Classes/ExpressionLanguage/CustomConditionFunctionsProvider.php


A usage example in TypoScript could be this:

..  literalinclude:: _codesnippets/_conditions.typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript
