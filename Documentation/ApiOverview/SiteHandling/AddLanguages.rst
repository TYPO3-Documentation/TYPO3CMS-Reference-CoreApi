.. include:: ../../Includes.txt


.. _sitehandling-addingLanguages:

Adding languages
-----------------

The site module allows you to define which languages are active for your site, which languages are available in the frontend and how 
they should behave. 

For an explanation of each of the properties, see below.

When the backend shows the list of available languages - for instance in the page module language selector, when editing records and in the list module - the list of languages is now restricted to those defined by the site module.
If there are for instance five language records in the system, but a site configures only three of them for a page tree, only those three are considered when rendering language drop downs.

The language management comes with an option to hide a language in the frontend while allowing it in the backend. This allows editors to start translating pages without them directly being live. 

.. note::
      In case no site configuration has been created for a tree, all language records are shown. In this case the Page TSconfig options `mod.SHARED.defaultLanguageFlag`, `mod.SHARED.defaultLanguageLabel` and `mod.SHARED.disableLanguages` settings 
      are also considered - those are obsolete if a site configuration exists.

Language fallbacks can be configured for every language but the default one. A language fallback means that if content is not available in the current language, content of the fallback language will be displayed. This may include multiple fallback
levels - for example "Modern Chinese" might fall back to "Chinese (Traditional)" which may then fallback to "English". All languages can be configured separately, so you can have different fallback chains and behavior for each language.

.. tip::
    Used to older TYPO3 versions? The following TypoScript settings will be set based on `config.yaml` - you don't need to have them in your TypoScript
    template:

    * config.language
    * config.locale_all
    * config.htmlTag_dir
    * config.htmlTag_langKey
    * config.sys_language_uid
    * config.sys_language_mode
    * config.sys_language_isocode
    * config.sys_language_isocode_default

Configuration Properties
^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
         languageId

   Data type
         integer

   Description
         The TYPO3 sys_language_uid (the uid of the language record on pid 0)

   Example
         1

.. container:: table-row

   Property
         title

   Data type
         string

   Description
         The internal human-readable name for this language.

   Example
        English


.. container:: table-row

   Property
         navigationTitle

   Data type
         string

   Description
         Optional navigation title which is used in HMENU.special = language

   Example
         British

.. container:: table-row

   Property
         base

   Data type
         string / URL

   Description
         Language base. Accepts either a fully qualified URL or a path segment like "/en/".

   Example
        /uk/

.. container:: table-row

   Property
         locale

   Data type
         string / locale

   Description
         The locale to use for this language (Is set during frontend rendering for example)

   Example
         en_UK

.. container:: table-row

   Property
         iso-639-1

   Data type
         string

   Description
         Two-letter code for the language according to ISO-639 nomenclature (see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)

   Example
         en

.. container:: table-row

   Property
         hreflang

   Data type
         string

   Description
         Frontend language for hreflang and lang tags.

   Example
         en-UK

.. container:: table-row

   Property
         direction

   Data type
         string

   Description
         Text direction for content in this language (left-to-right or right-to-left)

   Example
         ltr


.. container:: table-row

   Property
         typo3Language

   Data type
         string

   Description
         Language Identifier to use in TYPO3 locallang XLIFF files   

   Example
         en


.. container:: table-row

   Property
         flagIdentifier

   Data type
         string

   Description
         Flag identifier. The flag is for example displayed in the backend page module.

   Example
         en

.. container:: table-row

   Property
         fallbackType

   Data type
         string

   Description
         Language fallback mode - strict = no fallbacks, fallback = fallback to another language in case no translation exists

   Example
         strict

.. container:: table-row

   Property
         fallbacks

   Data type
         list of language ids

   Description
         List of fallback languages. If non has a matching translation, a pageNotFound is thrown.

   Example
         '0'