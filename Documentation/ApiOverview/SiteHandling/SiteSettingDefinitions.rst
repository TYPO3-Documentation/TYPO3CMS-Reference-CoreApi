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

The site settings provided by an extension can be automatically documented in the
extensions manual, see
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

    The parts marked by a number can be configured, see list bellow


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

        Checks whether the value is already an integer or can be interpreted as an
        integer. If yes, the string is converted into an integer.

    ..  confval:: number
        :name: site-setting-type-number
        :type: string
        :Path: settings.[my_val].type = number

        Checks whether the value is already an integer or float or whether the
        string can be interpreted as an integer or float. If yes, the string is
        converted to an integer or float.

    ..  confval:: bool
        :name: site-setting-type-bool
        :type: string
        :Path: settings.[my_val].type = bool

        If the value is already a boolean, it is returned directly 1 to 1.

        If the value is an integer, then `false` is returned for 0 and `true` for 1.

        If the value is a string, the corresponding Boolean value is returned for
        `true`, `false`, `yes`, `no`, `on`, `off`, `0` and `1`.

    ..  confval:: string
        :name: site-setting-type-string
        :type: string
        :Path: settings.[my_val].type = string

        Converts almost all data types into a string. If an object has been
        specified, it must be `stringable`, otherwise no conversion takes place.
        Boolean values are converted to `true` and `false`.

    ..  confval:: text
        :name: site-setting-type-text
        :type: string
        :Path: settings.[my_val].type = text

        Exactly the same as the `string` type. Use it as an alias if someone doesn't
        know what to do with `string`.

    ..  confval:: stringlist
        :name: site-setting-type-stringlist
        :type: string
        :Path: settings.[my_val].type = stringlist

        The value must be an array whose array key starts at 0 and increases by 1 per element. This sequence is
        checked using the internal PHP method array_is_list in order to prevent named array keys from the outset.
        This also means that comma-separated lists cannot be converted here.

        The `string` type is executed for each array entry.

    ..  confval:: color
        :name: site-setting-type-color
        :type: string
        :Path: settings.[my_val].type = color

        Checks whether the specified string can be interpreted as a color code.
        Entries starting with `rgb`, `rgba` and `#` are permitted here.

        For `#` color codes, for example, the system checks whether they
        have 3, 6 or 8 digits.


    ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypes1.png
        :alt: Screenshot demonstration the input fields for different setting types (Part 1)

    ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsTypes2.png
        :alt: Screenshot demonstration the input fields for different setting types (Part 2)

        A demonstration of the different setting types
