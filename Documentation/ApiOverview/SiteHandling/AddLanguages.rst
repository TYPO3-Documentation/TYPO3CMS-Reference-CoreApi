..  include:: /Includes.rst.txt
..  index:: pair: Site handling; Languages
..  _sitehandling-addingLanguages:

================
Adding Languages
================

The :guilabel:`Site Management > Sites` module lets you specify which languages
are active for your site, which languages are available, and how they
should behave. New languages for a site can also be configured in this module.

When the backend shows the list of available languages, the list of languages is
limited to the languages defined by the sites module. For instance, the
languages are used in the page module language selector, when editing records
or in the list module.

The language management provides the ability to hide a language on the frontend
while allowing it on the backend. This enables editors to start translating
pages without them being directly live.

..  note::
    In case no site configuration has been created for a tree, all configured
    languages are displayed. In this case the :ref:`page TSconfig options
    <t3tsref:pagemod>` :typoscript:`mod.SHARED.defaultLanguageFlag`,
    :typoscript:`mod.SHARED.defaultLanguageLabel` and
    :typoscript:`mod.SHARED.disableLanguages` settings are also considered -
    those are obsolete, if a site configuration exists.

Language fallbacks can be configured for any language except the default one. A
language fallback means that if content is not available in the current language,
the content is displayed in the fallback language. This may include multiple
fallback levels - for example, "Modern Chinese" might fall back to "Chinese
(Traditional)", which in turn may fallback to "English". All languages can be
configured separately, so you can specify different fallback chains and
behaviors for each language.

Example of a language configuration (excerpt):

..  literalinclude:: _language-example.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

..  index:: pair: Site handling; Languages properties
..  _sitehandling-addingLanguages-properties:

Configuration properties
========================

..  confval:: enabled
    :name: sitehandling-addingLanguages-enabled
    :type: bool
    :Example: :yaml:`true`

    Defines, if the language is visible on the frontend. Editors in the TYPO3
    backend will still be able to translate content for the language.

..  confval:: languageId
    :name: sitehandling-addingLanguages-languageId
    :type: integer
    :Example: :yaml:`1`

    For the default/main language of the given site, use value :yaml:`0`. For
    additional languages use a number greater than :yaml:`0`. Every site should
    have at last one language configured - with :yaml:`languageId: 0`.

    ..  attention::
        Once pages, content or records are created in a specific language, the
        :yaml:`languageId` must not be changed anymore.

..  confval:: title
    :name: sitehandling-addingLanguages-title
    :type: string
    :Example: :yaml:`English`

    The internal human-readable name for this language.

..  confval:: websiteTitle
    :name: sitehandling-addingLanguages-websiteTitle
    :type: string
    :Example: :yaml:`My custom very British title`

    Overrides the global website title for this language.

..  confval:: navigationTitle
    :name: sitehandling-addingLanguages-navigationTitle
    :type: string
    :Example: :yaml:`British`

    Optional navigation title which is used in
    :typoscript:`HMENU.special = language`.

..  confval:: base
    :name: sitehandling-addingLanguages-base
    :type: string / URL
    :Example: :yaml:`/uk/`

    The language base accepts either a URL or a path segment like :yaml:`/en/`.

..  confval:: baseVariants
    :name: sitehandling-addingLanguages-baseVariants
    :type: array

    Allows different base URLs for the same language. They follow the same
    syntax as the :ref:`base variants <sitehandling-baseVariants>` on the root
    level of the site config and they get active, if the condition matches.

    Example:

    ..  code-block:: yaml

        baseVariants:
          -
            base: 'https://example.localhost/'
            condition: 'applicationContext == "Development"'
          -
            base: 'https://staging.example.com/'
            condition: 'applicationContext == "Production/Sydney"'
          -
            base: 'https://testing.example.com/'
            condition: 'applicationContext == "Testing/Paris"'

..  _sitehandling-addingLanguages-locale:

..  confval:: locale
    :name: sitehandling-addingLanguages-locale
    :type: string / locale
    :Example: :yaml:`en_GB` or :yaml:`de_DE.utf8,de_DE`

    The locale to use for this language. For example, it is used during frontend
    rendering. That locale needs to be installed on the server. In a Linux
    environment, you can see installed locales with :bash:`locale -a`. Multiple
    fallback locales can be set as a comma-separated list. TYPO3 will then
    iterate through the locales from left to right until it finds a locale that
    is installed on the server.

..  confval:: hreflang
    :name: sitehandling-addingLanguages-hreflang
    :type: string
    :Example: :yaml:`en-GB`

    Use this property to override the automatic hreflang tag value for this
    language.

    The information is automatically derived from the
    :ref:`locale <sitehandling-addingLanguages-locale>` setting.

    **Example setups:**

    *   You have "German (Germany)" (which is using :yaml:`de-DE` as locale) and
        "German (Austria)" (which is using :yaml:`de-AT` as locale). Here you
        want to set :yaml:`de` as generic fallback in the :yaml:`de-DE` locale
        when using hreflang tags.
    *   You want to explicitly set :yaml:`x-default` for a specific language,
        which is clearly not a valid language key.

..  confval:: typo3Language
    :name: sitehandling-addingLanguages-typo3Language
    :type: string
    :Example: :yaml:`en`

    ..  deprecated:: 12.3
        It is not needed to set this property anymore, and is removed from the
        backend UI. The information is now automatically derived from the
        :ref:`locale <sitehandling-addingLanguages-locale>` setting.
        Using this property will trigger a PHP deprecation notice.

    Language identifier to use in TYPO3 :ref:`XLIFF files <xliff_api>`.

..  confval:: flag
    :name: sitehandling-addingLanguages-flag
    :type: string
    :Example: :yaml:`gb`

    The flag identifier. For example, the flag is displayed in the backend page
    module.

..  confval:: fallbackType
    :name: sitehandling-addingLanguages-fallbackType
    :type: string
    :Example: :yaml:`strict`

    The language fallback mode, one of:

    :yaml:`fallback`
        Fall back to another language, if the record does not exist in the
        requested language. Do overlays and keep the ones that are not
        translated.

        It behaves like the old :typoscript:`config.sys_language_overlay = 1`.
        Keep the ones that are only available in default language.

    :yaml:`strict`
        Same as :yaml:`fallback` but removes the records that are not
        translated.

        If there is no overlay, do not render the default language records,
        it behaves like the old :typoscript:`hideNonTranslated`, and include
        records without default translation.

    :yaml:`free`
        Fall back to another language, if the record does not exist in the
        requested language. But always fetch only records of this specific
        (available) language.

        It behaves like old :typoscript:`config.sys_language_overlay = 0`.

..  confval:: fallbacks
    :name: sitehandling-addingLanguages-fallbacks
    :type: comma-separated list of language IDs
    :Example: :yaml:`1,0`

    The list of fallback languages. If none has a matching translation, a
    "pageNotFound" is thrown.
