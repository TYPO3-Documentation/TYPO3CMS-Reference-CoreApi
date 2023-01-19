..  include:: /Includes.rst.txt
..  index:: Country API
..  _country-api:

===========
Country API
===========

..  versionadded:: 12.2

TYPO3 ships a list of countries of the world. The list is based on the
`ISO 3166-1`_ standard, with the alphanumeric short name ("FR" or "FRA" in its
three-letter short name), the English name ("France"), the official name
("Republic of France"), also the numerical code, and the country's flag as
emoji (UTF-8 representation).

..  note::
    The country list is based on `Debian's ISO code list`_ and shipped
    statically as PHP content in the Country API.

..  _ISO 3166-1: https://en.wikipedia.org/wiki/ISO_3166-1
..  _Debian's ISO code list: https://salsa.debian.org/iso-codes-team/iso-codes

.. contents:: Contents
   :local:


Using the PHP API
=================

:ref:`Dependency injection <DependencyInjection>` can be used to retrieve the
:php:`\TYPO3\CMS\Core\Country\CountryProvider` class:

..  literalinclude:: _MyClass.php
    :caption: EXT:my_extension/Classes/MyClass.php


Get a country
-------------

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    // Get the country by Alpha-2 code
    $france = $this->countryProvider->getByIsoCode('FR');

    // Get the country by name
    $france = $this->$countryProvider->getByName('France');

    // Get the country by Alpha-3 code
    $france = $this->$countryProvider->getByAlpha3IsoCode('FRA');

The methods return a :php:`\TYPO3\CMS\Core\Country\Country` object.


Get all countries
-----------------

To get all countries call the :php:`getAll()` method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $allCountries = $this->countryProvider->getAll();

The method returns an array of :php:`\TYPO3\CMS\Core\Country\Country` objects.


The :php:`Country` object
-------------------------

A country object can be used to fetch all information about it, also with
translatable labels:

..  literalinclude:: _MyClassWithTranslation.php
    :caption: EXT:my_extension/Classes/MyClassWithTranslation.php


PHP API reference
=================

:php:`CountryProvider`
----------------------

.. include:: /CodeSnippets/Manual/Country/CountryProvider.rst.txt

:php:`Country`
--------------

.. include:: /CodeSnippets/Manual/Country/Country.rst.txt


..  index:: CountrySelect ViewHelper
..  _country-select-viewhelper:

Form ViewHelper
===============

A Fluid ViewHelper is shipped with TYPO3 to render a dropdown for forms:

..  code-block:: html

    <f:form.countrySelect
        name="country"
        value="AT"
        sortByOptionLabel="true"
        prioritizedCountries="{0: 'DE', 1: 'AT', 2: 'CH'}"
    />

Available options
-----------------

:html:`disabled`
    Specifies that the form element should be disabled when the page loads.

:html:`required`
    If set, no empty value is allowed.

:html:`errorClass`
    Specify the CSS class to be set, if there are errors for this ViewHelper.

:html:`sortByOptionLabel`
    Whether the country list should be sorted by option label or not.

:html:`optionLabelField`
    Specify the type of label of the country list. Available options are:

    *   :html:`name`
    *   :html:`localizedName`
    *   :html:`officialName`
    *   :html:`localizedOfficialName`

    Default option is :html:`localizedName`.

:html:`alternativeLanguage`
    If specified, the country list will be shown in the given language.

:html:`prioritizedCountries`
    Define a list of countries which should be listed as first options in the
    form element.

:html:`onlyCountries`
    Restrict the countries to be rendered in the list.

:html:`excludeCountries`
    Define which countries should not be shown in the list.

:html:`prependOptionLabel`
    Provide an additional option at first position with the specified label.

:html:`prependOptionValue`:
    Provide an additional option at first position with the specified value.

..  tip::
    A combination of :html:`optionLabelField` and :html:`alternativeLanguage` is
    possible. For instance, if you want to show the localized official names,
    but not in your default language, but in French. You can achieve this by
    using the following combination:

    .. code-block:: html

        <f:form.countrySelect
            name="country"
            optionLabelField="localizedOfficialName"
            alternativeLanguage="fr"
            sortByOptionLabel="true"
        />

