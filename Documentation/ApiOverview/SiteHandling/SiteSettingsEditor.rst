:navigation-title: Settings editor

..  include:: /Includes.rst.txt
..  index:: Site handling; Site settings editor
..  _site-settings-editor:

====================
Site settings editor
====================

Use the editor to review and override defined settings for each site.

The editor changes only the site's override layer in
:file:`config/sites/<my_site>/settings.yaml`. It does not modify the definition,
the reusable defaults or :file:`settings.yaml` files provided by sets. This
allows an extension to update its defaults while each site retains only the
values that were intentionally customized.

..  contents:: On this page
    :local:

..  _site-settings-editor-edit:

Edit site settings
==================

Open :guilabel:`Sites > Setup > Settings` to see all sites with editable
:ref:`site settings <sitehandling-settings>`:

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsOverview.png
    :alt: Screenshot of the Site Setup module in overview, button "Edit site settings" is highlighted

    Click the cog button "Edit site settings" to edit the settings

The settings editor displays the settings of all site sets included in the
current site, including their dependencies. The site sets can define categories
and subcategories to order the settings.

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettings.png
    :alt: Screenshot of the settings of an example site

    The site in the examples includes the "My Sitepackage" and "Blog Example"
    sets. "My Sitepackage" depends on "Fluid Styled Content"

The editor displays only settings defined by an active set, for example in
:file:`EXT:my_sitepackage/Configuration/Sets/MySitepackage/settings.definitions.yaml`.
See :ref:`Site settings definitions <site-settings-definition>`.

Settings that have been made directly in the :file:`settings.yaml` file without a
corresponding entry in a :file:`settings.definitions.yaml` are not displayed in
the editor as they have neither a type nor a label. These values are, however,
retained for backward compatibility when the editor writes to the
:file:`settings.yaml` file. They are not part of the supported configuration
contract described in :ref:`Site settings <sitehandling-settings>`.

..  _sitehandling-settings-editor-configuration:

Configuring the site settings editor
====================================

The editor has no separate field configuration. TYPO3 generates it entirely
from :ref:`site setting definitions <site-settings-definition>`: categories
and labels organize the form, the type selects the field and validates the
submitted value, and the default supplies the value when no override exists.

The following annotated editor view shows how each part of a definition
appears:

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsDefinition.png
    :alt: Annotated screenshot of categories and fields in the site settings editor

    Markers 1 to 7 show how the definition controls the editor

..  rst-class:: bignums-attention

1.  **Main category:** The `label` of a top-level category becomes a heading
    in the editor and an entry in its navigation.

2.  **Subcategory:** The `parent` property places one category below another.
    A setting's `category` property assigns the field to that category.

3.  **Label:** The setting's `label` becomes the field label. It can be written
    directly in the definition or loaded from a :file:`labels.xlf` file.

4.  **Description:** The optional `description` is displayed below the label.
    It can also be translated through :file:`labels.xlf`.

5.  **Setting identifier:** The key below `settings` is the exact identifier
    used in :file:`settings.yaml` and when the setting is read. The editor
    displays it in advanced mode.

6.  **Type:** The `type` selects the form control and validates and converts
    the submitted value. See :ref:`definition types <definition-types>`.

7.  **Displayed value:** The field contains the effective value. In this
    example no set or site overrides `blogExample.partialRootPath`, so TYPO3
    displays the definition's `default` value.

8.  **Reset value:** Resetting a field discards its site-specific override and
    restores the inherited value. This is the value supplied by an active set,
    or the definition's `default` when no set overrides it. See
    :ref:`How a setting value is resolved <sitehandling-settings-resolution>` for the complete resolution order.

    ..  figure:: /Images/ManualScreenshots/SiteHandling/SiteSettingsReset.png
        :alt: Screenshot showing the "Reset settings" button in the settings popup menu

        Reset the setting to the inherited value (8)

The corresponding definition is:

..  literalinclude:: _Settings/_blog_settings.definitions.yaml
    :caption: EXT:blog_example/Configuration/Sets/BlogExample/settings.definitions.yaml (excerpt)
    :linenos:

See the complete example at
`settings.definitions.yaml (GitHub) <https://github.com/TYPO3-Documentation/blog_example/blob/main/Configuration/Sets/BlogExample/settings.definitions.yaml>`__.
