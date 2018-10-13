.. include:: ../../Includes.txt

.. _sitehandling-inConditions:

Using site config in conditions
===============================

Site configuration may be used in all conditions that use Symfony Expression language
`Typo3ConditionFunctionsProvider` - at the moment this means in EXT:form variants
and TypoScript conditions.

Two objects are available: `site` and `siteLanguage`. 
With `site` you can access the properties of the top level site configuration.
`siteLanguage` accesses the configuration of the current site language.

TypoScript Examples
-------------------

The identifier of the site name is evaluated:

.. code-block:: typoscript

    [site("identifier") == "someIdentifier"]
        page.30.value = foo
    [global]


Property of the current site language is evaluated:

.. code-block:: typoscript

    [siteLanguage("locale") == "de_CH.UTF-8"]
        page.40.value = bar
    [global]


EXT:form Examples
-----------------

Translate options via `siteLanguage` condition:

.. code-block:: yaml

    renderables:
    -
        type: Page
        identifier: page-1
        label: DE
        renderingOptions:
        previousButtonLabel: 'zurück'
        nextButtonLabel: 'weiter'
        variants:
        -
            identifier: language-variant-1
            condition: 'siteLanguage("locale") == en_US.UTF-8'
            label: EN
            renderingOptions:
            previousButtonLabel: 'Previous step'
            nextButtonLabel: 'Next step'