..  include:: /Includes.rst.txt
..  index:: Site handling; Site settings editor
..  _site-settings-editor:

====================
Site settings editor
====================

..  versionadded:: 13.3
    The site setting editor has been introduced as backend module
    :guilabel:`Sites > Setup > Settings`.

In module :guilabel:`Sites > Setup > Settings` you get an overview of all sites in
the current installation and can edit the :ref:`sitehandling-settings` for
all pages that contain settings:

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsOverview.png
    :alt: Screenshot of the Site Settings module in overview

    Site "Home" has settings that can be edited. The others do not.

The settings editor displays the settings of all site sets included in the
current site, including their dependencies. The site sets can define categories
and subcategories to order the settings.

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettings.png
    :alt: Screenshot of the settings of an example site

    The site in the examples includes the "My Sitepackage" and "Blog Example"
    sets. "My Sitepackage" depends on "Fluid Styled Content"

The settings to be displayed here have to be defined in an extension's or
site packages's set in a :ref:`setting definition <site-settings-definition>` file, for example
:file:`EXT:my_sitepackage/Configuration/Sets/MySitepackage/settings.definitions.yaml`.

Settings that have been made directly in the :file:`settings.yaml` file without a
corresponding entry in a :file:`settings.definitions.yaml` are not displayed in
the editor as they have neither a type nor a label. These values are, however,
retained when the editor writes to the :file:`settings.yaml` file.

..  _sitehandling-settings-editor-configuration:

Configuring the site settings editor
====================================

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsDefinition.png
    :alt: Screenshot demonstration the position of the categories, labels etc

    The parts marked by a number can be configured, see list bellow

..  literalinclude:: _Settings/_blog_settings.definitions.yaml
    :caption: EXT:blog_example/Configuration/Sets/BlogExample/settings.definitions.yaml (Excerpt)
    :linenos:

See the complete example at
`settings.definitions.yaml (GitHub) <https://github.com/TYPO3-Documentation/blog_example/blob/main/Configuration/Sets/BlogExample/settings.definitions.yaml>`__.

..  rst-class:: bignums-attention

1.  Main category

    The label of the category is defined in *line 3* of the example code snippet.
    *Line 6 and 9* place two categories as subcategories into this category.

2.  Sub category

    The sub category is defined in *line 5 to 6*. *Line 14* locates the setting
    in this subcategory.

3.  Label

    Can be defined directly in the settings definition (*line 13*) or in a
    :file:`labels.xlf` file.

4.  Description

    Can be defined directly in the settings definition (*line 15*) or in a
    :file:`labels.xlf` file.

5.  Type

    *line 16*, for possible types see :ref:`definition-types`.

6.  Default value

    *line 23* the default value is displayed if the value of the settings was
    not overridden. If the value was overridden, it can be reset to the default.

    ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsReset.png
        :alt: Screenshot showing the "Reset settings" button in the settings popup menu

        Reset the setting to the default value
