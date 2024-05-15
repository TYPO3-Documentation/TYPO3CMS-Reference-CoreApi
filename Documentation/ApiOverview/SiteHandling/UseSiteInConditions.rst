:navigation-title: Usage
..  include:: /Includes.rst.txt
..  index:: Site handling; Conditions
..  _sitehandling-inConditions:

======================================
Using site configuration in conditions
======================================

Site configuration may be used in all conditions that use
`Symfony expression language`_ via the
:t3src:`core/Classes/ExpressionLanguage/FunctionsProvider/Typo3ConditionFunctionsProvider.php`
class - at the moment, this means in
:ref:`EXT:form variants <ext_form:concepts-variants>` and
:ref:`TypoScript conditions <t3tsref:conditions>`.

..  _Symfony expression language: https://symfony.com/doc/current/components/expression_language.html

Two objects are available:

`site`
    You can access the properties of the top level site configuration.

`siteLanguage`
    Access the configuration of the current site language.


.. index:: Site handling; TypoScript conditions

TypoScript examples
===================

The identifier of the site name is evaluated:

..  code-block:: typoscript

    [site("identifier") == "someIdentifier"]
       page.30.value = foo
    [GLOBAL]


A custom field is evaluated:

.. code-block:: typoscript

    [site("configuration")["custom_field"] == "compareValue"]
       page.35.value = abc
    [GLOBAL]

:typoscript:`site("methodName")` is equivalent to a call of "methodName" on the current site object.

You can take a look at :php:`\TYPO3\CMS\Core\Site\Entity\SiteInterface` for accessible methods.

Property of the current site language is evaluated:

..  code-block:: typoscript

    [siteLanguage("locale") == "de_CH.UTF-8"]
       page.40.value = bar
    [GLOBAL]


.. index:: pair: Site handling; YAML

Example for EXT:form
====================

Translate options via :yaml:`siteLanguage` condition:

..  literalinclude:: _form-condition.yaml
    :language: yaml
