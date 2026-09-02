:navigation-title: Setting definitions

..  include:: /Includes.rst.txt
..  index:: Site handling; Settings

..  _site-settings-definition:

=========================
Site settings definitions
=========================

Site settings definitions define the public configuration contract for site
settings: their identifier, type and guaranteed default value. They are defined
in :ref:`site sets <site-sets>`, in a file called
:file:`settings.definitions.yaml`.

..  important::
    An extension that introduces a setting **MUST** also own and provide its
    definition. This keeps the description, validation rules and fallback value
    available wherever the feature is used. Integrating sets and individual
    sites can then override the value without copying the contract.

A value in :file:`settings.yaml` does not create a definition. Define a setting
before reading or overriding it; see :ref:`site settings <sitehandling-settings>`.

All defined settings from the active sets are displayed in the
:ref:`site settings editor <site-settings-editor>`.

Categories, labels and descriptions mainly describe how a setting appears to
an integrator. The setting identifier, type and default define the runtime
contract used by application code.

The site settings provided by an extension can be automatically documented in
the extensions manual, see
:ref:`site settings documentation <h2document:reference-site-settings>`.

..  contents:: On this page
    :local:

..  _site-settings-definition-example:

Site setting definition example
===============================

The top-level `settings` section contains the contracts, keyed by setting
identifier. Each definition provides at least a type and a default value;
labels and descriptions make it understandable in the editor.

..  literalinclude:: _Settings/_site-settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

Categories are optional and do not change how a setting is read. See
:ref:`Configuring the site settings editor <sitehandling-settings-editor-configuration>` for a complete annotated
example with categories and the resulting editor fields.


..  _site-settings-definition-properties:

Site setting definition properties
==================================

..  confval-menu::
    :display: table
    :name: site-setting-definition
    :type:
    :required:

    ..  confval:: categories
        :type: array
        :name: site-settings-definition-categories

        Defines groups used to organize settings in the editor.

        ..  confval:: label
            :type: string
            :name: site-settings-definition-categories-label

            Human-readable category label.

        ..  confval:: parent
            :type: :confval:`site-settings-definition-categories` key
            :name: site-settings-definition-categories-parent

            Places the category below another category.

    ..  confval:: settings
        :type: array
        :name: site-settings-definition-settings

        Defines the settings provided by the set. Each array key is the
        setting identifier.

        ..  confval:: label
            :type: string
            :name: site-settings-definition-settings-label

            Required unless TYPO3 can derive the label from a
            :file:`labels.xlf` file in the set directory. See
            :ref:`Translating labels and descriptions for settings <site-settings-definition-translation>`.

        ..  confval:: description
            :type: string
            :name: site-settings-definition-settings-description
            :Example: 'Configure `baz` to be used in `bar`.'

            While Markdown syntax can be used in YAML to provide rich text formatting, there are
            a few gotchas. Because YAML is sensitive to special characters and indentation, you
            might need to wrap your Markdown text in single quotes (') to prevent it from breaking
            the YAML syntax.

        ..  confval:: category
            :type: :confval:`site-settings-definition-categories` key
            :name: site-settings-definition-settings-category

        ..  confval:: type
            :type: a :ref:`definition type <definition-types>`
            :name: site-settings-definition-settings-type
            :required:

        ..  confval:: default
            :type: mixed
            :name: site-settings-definition-settings-default
            :required:

            The default value must have the same type as defined in
            :confval:`site-settings-definition-settings-type`.

        ..  confval:: readonly
            :type: bool
            :name: site-settings-definition-settings-readonly

            If a site setting is marked as readonly, it can be overridden only
            by editing the :file:`config/sites/my-site/settings.yaml` directly,
            but not from within the editor.

        ..  _confval-site-setting-type-enum:

        ..  confval:: enum
            :type: array
            :name: site-settings-definition-settings-enum
            :types: :confval:`site-setting-type-string`

            ..  versionadded:: 14.2
                Enum labels can be localized, see
                `Feature: #106640 - Localize enum labels in site settings definitions <https://docs.typo3.org/permalink/changelog:feature-106640-1766572100>`_.

            Site settings can provide possible options via the `enum` specifier,
            which are selectable in the editor. `enum` is not a separate
            definition type; combine it with a compatible type such as
            :confval:`site-setting-type-string`.

            List-style enum declarations (a plain array of values) derive a
            translation key using `settings.<settingKey>.enum.<enumValue>`,
            see :ref:`Translating enum labels
            <site-settings-definition-translation-enum>`. Map-style enum
            declarations (`value: label`) use the given label directly: it
            can be a literal string, an explicit `LLL:` reference, or
            omitted to fall back to the enum value itself.

            ..  literalinclude:: _Settings/_enum_settings.definitions.yaml
                :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

            ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeEnum.png
                :alt: Screenshot of a site setting with selectable enum values

        ..  confval:: tags
            :type: array
            :name: site-settings-definition-settings-tags

            Optional metadata tags for the setting definition.

        ..  confval:: options
            :type: array
            :name: site-settings-definition-settings-options

            Type-specific options. For example, the
            :confval:`site-setting-type-url` type accepts a `pattern` option
            for an additional regular expression check.

..  note::
    The `settings.definitions.yaml` does not allow any kind of imports. All
    settings must be defined in a single file.

..  _definition-types:

Setting types
=============

..  confval-menu::
    :display: table
    :name: site-setting-type
    :type:
    :required:

    ..  confval:: int
        :name: site-setting-type-int
        :type: string
        :Path: settings.[my_val].type = int

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeInt.png
            :alt: Screenshot of a site setting field of type int

        Checks whether the value is already an integer or can be interpreted as an
        integer. If yes, the string is converted into an integer.

        ..  literalinclude:: _Settings/_settings.definitions.int.yaml

    ..  confval:: number
        :name: site-setting-type-number
        :type: string
        :Path: settings.[my_val].type = number

        Checks whether the value is already an integer or float or whether the
        string can be interpreted as an integer or float. If yes, the string is
        converted to an integer or float.

        ..  literalinclude:: _Settings/_settings.definitions.number.yaml

    ..  confval:: bool
        :name: site-setting-type-bool
        :type: string
        :Path: settings.[my_val].type = bool

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeBool.png
            :alt: Screenshot of a site setting field of type bool

        If the value is already a boolean, it is returned directly 1 to 1.

        If the value is an integer, then `false` is returned for 0 and `true` for 1.

        If the value is a string, the corresponding Boolean value is returned for
        `true`, `false`, `yes`, `no`, `on`, `off`, `0` and `1`.

        ..  literalinclude:: _Settings/_settings.definitions.bool.yaml

    ..  confval:: string
        :name: site-setting-type-string
        :type: string
        :Path: settings.[my_val].type = string

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeString.png
            :alt: Screenshot of a site setting field of type string

        Converts almost all data types into a string. If an object has been
        specified, it must be `stringable`, otherwise no conversion takes place.
        Boolean values are converted to `true` and `false`.

        ..  literalinclude:: _Settings/_settings.definitions.string.yaml

    ..  confval:: text
        :name: site-setting-type-text
        :type: string
        :Path: settings.[my_val].type = text

        Uses the same validation and conversion as the `string` type, but
        identifies the setting as longer text in the editor.

        ..  literalinclude:: _Settings/_settings.definitions.text.yaml

    ..  confval:: stringlist
        :name: site-setting-type-stringlist
        :type: string
        :Path: settings.[my_val].type = stringlist

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeStringlist.png
            :alt: Screenshot of a site setting field of type stringlist

        The value must be an array whose array key starts at 0 and increases by 1 per element. This sequence is
        checked using the internal PHP method array_is_list in order to prevent named array keys from the outset.
        This also means that comma-separated lists cannot be converted here.

        The `string` type is executed for each array entry.

        ..  literalinclude:: _Settings/_settings.definitions.stringlist.yaml

    ..  confval:: color
        :name: site-setting-type-color
        :type: string
        :Path: settings.[my_val].type = color

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeColor.png
            :alt: Screenshot of a site setting field of type color

        Checks whether the specified string can be interpreted as a color code.
        Entries starting with `rgb`, `rgba` and `#` are permitted here.

        For `#` color codes, for example, the system checks whether they
        have 3, 6 or 8 digits.

        ..  literalinclude:: _Settings/_settings.definitions.color.yaml

    ..  confval:: page
        :name: site-setting-type-page
        :type: string
        :Path: settings.[my_val].type = page

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypePage.png
            :alt: Screenshot of a site setting field of type page

        Checks whether the value is already an integer or can be interpreted as an
        integer. If yes, the string is converted into an integer.

        Additionally renders a page browser in the settings editor to allow the
        user to select a page for a specific setting, while still displaying the
        UID in the field.

        ..  literalinclude:: _Settings/_settings.definitions.page.yaml

    ..  confval:: url
        :name: site-setting-type-url
        :type: string
        :Path: settings.[my_val].type = url

        Validates that the value is a URL. An empty value is accepted. Use the
        type-specific `options.pattern` property to require an additional
        regular expression match.

        ..  literalinclude:: _Settings/_settings.definitions.url.yaml

..  _site-settings-definition-translation:

Translating labels and descriptions for settings
================================================

To translate labels and descriptions, create a :file:`labels.xlf` file next to
the set's :file:`config.yaml` and :file:`settings.definitions.yaml`. TYPO3 uses
different translation unit identifiers for the set, categories, settings and
enum values. When a matching translation exists, you can omit the corresponding
literal label or description from the YAML file.

The set label uses the translation unit identifier `label`:

..  rubric:: Example

..  code-block:: xml
    :caption: Example label definition in labels.xlf

    <trans-unit id="label">
        <source>My Custom Set</source>
    </trans-unit>

..  important::
    To translate the labels of your settings using Crowdin, you need to adjust
    your extension's
    :ref:`Crowdin configuration file <crowdin-extension-integration-github-configure>`.

..  _site-settings-definition-translation-category:

Translating category labels
---------------------------

To translate category labels and descriptions, use the following format:

..  code-block:: xml
    :caption: Example category label definitions

    <trans-unit id="categories.mycustomcategory">
        <source>My Custom Category</source>
    </trans-unit>

    <trans-unit id="categories.description.mycustomcategory">
        <source>Description of My Custom Category</source>
    </trans-unit>

..  _site-settings-definition-translation-labels:

Translating settings labels and descriptions
--------------------------------------------

To translate the label and description of a specific setting, use this structure:

..  code-block:: xml
    :caption: Example setting label definitions

    <trans-unit id="settings.mycustomsetting">
        <source>My Custom Setting</source>
    </trans-unit>

    <trans-unit id="settings.description.mycustomsetting">
        <source>My Custom Setting description</source>
    </trans-unit>

..  _site-settings-definition-translation-enum:

Translating enum labels
-----------------------

To translate the labels of :confval:`enum <site-settings-definition-settings-enum>` options for list-style enum
declarations (a plain array of values), use this structure:

..  literalinclude:: _Settings/_enum_list_settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

..  code-block:: xml
    :caption: Matching labels in labels.xlf

    <trans-unit id="settings.mycustomsetting.enum.optionA">
        <source>Option A</source>
    </trans-unit>
    <trans-unit id="settings.mycustomsetting.enum.optionB">
        <source>Option B</source>
    </trans-unit>

Map-style enum declarations (`value: label`) are independent of this key
schema: the given label is used as-is, unless it is an explicit `LLL:`
reference.

..  literalinclude:: _Settings/_enum_map_settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

..  code-block:: xml
    :caption: Referenced label in labels.xlf

    <trans-unit id="settings.custom.optionA">
        <source>Option A (localized)</source>
    </trans-unit>

In this example, `optionA` resolves the referenced `LLL:` label, `optionB`
keeps its literal label as-is, and `optionC` has no label and falls back to
the enum value `optionC` itself.

..  _site-settings-definition-translation-languages:

Translations for other languages
--------------------------------

To provide translations in another language, use the two-letter language prefix
in the filename. For example:

:file:`de.labels.xlf`
