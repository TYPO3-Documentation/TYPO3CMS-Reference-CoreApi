..  include:: /Includes.rst.txt
..  index:: Events; BeforeCountriesEvaluatedEvent
..  _BeforeCountriesEvaluatedEvent:

=============================
BeforeCountriesEvaluatedEvent
=============================

..  versionadded:: 13.3

The PSR-14 event :php:`\TYPO3\CMS\Core\Country\Event\BeforeCountriesEvaluatedEvent`
allows to modify the list of countries provided by
the :php:`\TYPO3\CMS\Core\Country\CountryProvider`.

This event allows to to add, remove and alter countries from the list used by the
provider class itself and ViewHelpers like the
:ref:`Form.countrySelect ViewHelper <f:form.countrySelect> <t3viewhelper:typo3-fluid-form-countryselect>`.

..  note::
    The DTO :php:`\TYPO3\CMS\Core\Country\Country`
    uses :file:`EXT:core/Resources/Private/Language/Iso/countries.xlf` for translating
    the country names.

    If additional countries are added, add translations to `countries.xlf`
    via :ref:`$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <t3coreapi:xliff-translating-custom>`.

..  contents:: Table of contents

..  _BeforeCountriesEvaluatedEvent-example:

Example: Add a new country to the country selectors
===================================================

The following event listener adds a new country, 'Magic Kingdom' with alpha 2
code 'XX' and alpha 3 code 'XXX'.

..  literalinclude:: _BeforeCountriesEvaluatedEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Country/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt


..  versionchanged:: 14.0
    `$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']` has been moved
    to `$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <https://docs.typo3.org/permalink/t3coreapi:confval-globals-typo3-conf-vars-lang-resourceoverrides>`_.

As the localized names for the countries are defined in file
:file:`EXT:core/Resources/Private/Language/Iso/countries.xlf`, this language
file needs to be extended via
:ref:`$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides'] <t3coreapi:xliff-translating-custom>`:

..  literalinclude:: _BeforeCountriesEvaluatedEvent/_ext_localconf.php
    :caption: EXT:my_extension/ext_localconf.php

You can now override the language file in the path defined above:

..  literalinclude:: _BeforeCountriesEvaluatedEvent/_countries.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/countries.xlf

And add additional translations for German:

..  literalinclude:: _BeforeCountriesEvaluatedEvent/_de.countries.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/de.countries.xlf

And Klingon:

..  literalinclude:: _BeforeCountriesEvaluatedEvent/_tlh.countries.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/tlh.countries.xlf

..  _BeforeCountriesEvaluatedEvent-api:

API of event BeforeCountriesEvaluatedEvent
==========================================

..  include:: /CodeSnippets/Events/Core/Country/BeforeCountriesEvaluatedEvent.rst.txt
