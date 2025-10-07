..  include:: /Includes.rst.txt
..  index:: Site handling; Settings

..  _site-settings-definition:

=========================
Site settings definitions
=========================

..  versionadded:: 13.1
    Site-scoped setting definitions where introduced. They will most likely be
    the place to configure site-wide configuration, which was previously only
    possible to modify via modifying TypoScript constants, for example in the
    Constant Editor.

Site settings definitions allow to define settings with a type and a guaranteed
default value. They can be defined in :ref:`site-sets`, in a file called
:file:`settings.definitions.yaml <set-settings-definitions-yaml>`.

It is recommended to use site-sets and their UI configuration in favor of
TypoScript Constants.

All available settings are displayed in the :ref:`site-settings-editor`.

The site settings provided by an extension can be automatically documented in
the extensions manual, see
:ref:`site settings documentation <h2document:reference-site-settings>`.

..  contents:: Table of contents

..  _site-settings-definition-example:

Site setting definition example
===============================

..  literalinclude:: _Settings/_blog_settings.definitions.yaml
    :caption: EXT:blog_example/Configuration/Sets/BlogExample/settings.definitions.yaml (Excerpt)

See the complete example at
`settings.definitions.yaml (GitHub) <https://github.com/TYPO3-Documentation/blog_example/blob/main/Configuration/Sets/BlogExample/settings.definitions.yaml>`__.

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsDefinition.png
    :alt: Screenshot demonstration the position of the categories, labels etc

    The parts marked by a number can be configured, see list below


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

        ..  confval:: label
            :type: string
            :name: site-settings-definition-categories-label

        ..  confval:: parent
            :type: :confval:`site-settings-definition-categories` key
            :name: site-settings-definition-categories-parent

    ..  confval:: settings
        :type: array
        :name: site-settings-definition-settings

        ..  confval:: label
            :type: string
            :name: site-settings-definition-settings-label

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

            The default value must have the same type like defined in
            :confval:`site-settings-definition-settings-type`.

        ..  confval:: readonly
            :type: bool
            :name: site-settings-definition-settings-readonly

            If a site setting is marked as readonly, it can be overridden only
            by editing  the :file:`config/sites/my-site/settings.yaml` directly,
            but not from within the editor.

        ..  confval:: enum
            :type: array
            :name: enum
            :types: :confval:`site-setting-type-string`

            Site settings can provide possible options via the `enum` specifier,
            that will be selectable in the editor GUI.

            ..  literalinclude:: _Settings/_enum_settings.definitions.yaml
                :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

..  note::
    The `settings.definitions.yaml` does not allow any kind of imports. All
    settings must be defined in a single file.

..  _definition-types:

Definition types
================

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
            :alt: Screenshot of a site setting field of type enum

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

        Exactly the same as the `string` type. Use it as an alias if someone doesn't
        know what to do with `string`.

        ..  literalinclude:: _Settings/_settings.definitions.text.yaml

    ..  confval:: enum
        :name: site-setting-type-enum
        :type: string
        :Path: settings.[my_val].type = enum

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypeEnum.png
            :alt: Screenshot of a site setting field of type enum

        Site settings can provide possible options via the `enum` specifier, that will
        be selectable in the editor GUI.

        ..  literalinclude:: _Settings/_settings.definitions.enum.yaml

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

        ..  versionadded:: 13.4.15
            This type has been added to compensate the missing UX functionality
            when using `type=int` to reference page records.
            Integrators had no way to look up page ids while editing site
            settings. This type adds an integrated page browser that solves this
            problem.

        ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypePage.png
            :alt: Screenshot of a site setting field of type page

        Checks whether the value is already an integer or can be interpreted as an
        integer. If yes, the string is converted into an integer.

        Additionally renders a page browser in the settings editor to allow the
        user to select a page for a specific setting, while still displaying the
        UID in the field.

        ..  literalinclude:: _Settings/_settings.definitions.page.yaml

..  _site-settings-definition-translation:

Translating labels and descriptions for settings
================================================

To translate the labels and descriptions for the settings you have defined in
:file:`settings.definition.yml`, remove the `label` entry from there and create a
:file:`labels.xlf` file in the same directory.

The key of the translation unit must be the key of the setting.  
For example, the label of the setting is simply `label` in the XLF file.

.. rubric:: Example

..  code-block:: xml
    :caption: Example label definition in labels.xlf

    <trans-unit id="label">
        <source>My Custom Set</source>
    </trans-unit>

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

..  _site-settings-definition-translation-languages:

Translations for other languages
--------------------------------

To provide translations in another language, use the two-letter language prefix
in the filename. For example:

:file:`de.labels.xlf`
