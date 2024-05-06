..  include:: /Includes.rst.txt
..  index:: Site handling; Site sets
..  _site-sets:

=========
Site sets
=========

Site sets ship parts of the site configuration as composable pieces. They are
intended to deliver :ref:`settings <sitehandling-settings>`,
:ref:`TypoScript <t3tsref:start>` and
:ref:`page TSconfig <t3tsconfig:include-static-page-tsconfig-per-site>`
for the scope of a site.

Extensions can provide multiple sets in order to ship presets for different
sites or subsets (think of frameworks) where selected features are exposed
as a subset (example: `typo3/seo-xml-sitemap`).

..  contents:: Table of content
    :local:

..  _site-sets-definition:

Site set definition
===================

A set is defined in an extension's sub folder in :path:`Configuration/Sets/`, for
example :file:`EXT:my_extension/Configuration/Sets/MySet/config.yaml`.

The folder name in :path:`Configuration/Sets/` is arbitrary, significant
is the `name` defined in :file:`config.yaml`. The `name` uses a `vendor/name`
scheme by convention, and *should* use the same vendor as the containing
extension. It may differ if needed for compatibility reasons (for example when
sets are moved to other extensions). If an extension provides exactly one set
, it should have the same `name` as defined in :file:`composer.json`.

The :file:`config.yaml` for a set that depends on two other sets looks as
follows:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/config.yaml

    name: my-vendor/my-set
    label: My Set

    # Load TypoScript, TSconfig and settings from dependencies
    dependencies:
      - some-namespace/slider
      - other-namespace/fancy-carousel

..  _site-sets-usage:

Using a site set as dependency in a site
========================================

Sets are applied to sites via `dependencies` array in site configuration:

..  code-block:: yaml
    :caption: config/sites/my-site/config.yaml

    base: 'http://example.com/'
    rootPageId: 1
    dependencies:
      - my-vendor/my-set

Site sets can also be added to a site via the backend module
:guilabel:`Site Management > Sites`.

..  _site-sets-settings-definition:

Settings definitions
====================

Sets can define settings definitions which contain more metadata than just a
value: They contain UI-relevant options like `label`, `description`, `category`
and `tags` and types like `int`, `bool`, `string`, `stringlist`, `text` or
`color`. These definitions are placed in :file:`settings.definitions.yaml`
next to the site set file :file:`config.yaml`.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

    settings:
      foo.bar.baz:
        label: 'My example baz setting'
        description: 'Configure baz to be used in bar'
        type: int
        default: 5

..  _site-sets-settings:

Settings for subsets
====================

Settings for subsets (for example to configure settings in declared dependencies)
can be shipped via :file:`settings.yaml` when placed next to the set file
:file:`config.yaml`.

Note that default values for settings provided by the set do not need to be
defined here, as defaults are to be provided within
:file:`settings.definitions.yaml`.

Here is an example where the setting `styles.content.defaultHeaderType` as
provided by `typo3/fluid-styled-content` is configured via
:file:`settings.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.yaml

    styles:
      content:
        defaultHeaderType: 1


This setting will be exposed as site setting whenever the set
`my-vendor/my-set` is applied as dependency to a site configuration.

..  _site-sets-typoscript:

TypoScript provider
===================

TypoScript dependencies can be included via set dependencies. This mechanism is
much more effective than the previous static_file_include's or manual
:typoscript:`@import` statements.

TypoScript dependencies via sets are automatically ordered and
deduplicated.

Set-defined TypoScript can be shipped within a set. The files
:file:`setup.typoscript` and :file:`constants.typoscript` (placed next to the
:file:`config.yaml` file) will be loaded, if available.
They are inserted (similar to `static_file_include`) into the TypoScript chain
of the site TypoScript that will be defined by a site that is using sets.

Set constants will always be overruled by site settings. Since site settings
always provide a default value, a constant will always be overruled by a defined
setting. This can be used to provide backward compatibility with TYPO3 v12
in extensions, where constants shall be used in v12, while v13 will always
prefer defined site settings.

In contrast to `static_file_include`, dependencies are to be included via
sets. Dependencies are included recursively. This mechanism supersedes the
previous include via `static_file_include` or manual :typoscript:`@import` statements as
sets are automatically ordered and deduplicated. That means TypoScript will not
be loaded multiple times, if a shared dependency is required by multiple sets.

..  note:: :typoscript:`@import` statements are still fine to be used for local
    includes, but should be avoided for cross-set/extensions dependencies.

..  _site-sets-page-tsconfig:

Page TSconfig provider
======================

Page TSconfig is loaded from a file :file:`page.tsconfig`, if placed next to the
site set configuration file :file:`config.yaml` and is scoped to pages within
sites that depend on this set.

Therefore, extensions can ship page TSconfig without the need for database entries or
by polluting global scope when registering page TSconfig globally via
:file:`ext_localconf.php` or :file:`Configuration/page.tsconfig`.
Dependencies can be expressed via sets, allowing for automatic ordering and
deduplication.

..  _site-sets-cli:

Analyzing the available site sets via console command
=====================================================

A list of available site sets can be retrieved with the console command
:bash:`bin/typo3 site:sets:list`:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:sets:list

    ..  group-tab:: Legacy installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:sets:list


..  _site-sets-example-site-package:

Example: Using a set within a site package
==========================================

You can see an example of using a sets within a site package in the extension
:t3ext:`site-package`,
`t3docs/site-package (Source on GitHub) <https://github.com/TYPO3-Documentation/TYPO3CMS-Tutorial-SitePackage-Code>`__.

The site package example extension has the following file structure:

..  directory-tree::
    :show-file-icons: true

    *   Configuration

        *   Sets

            *   SitePackage

                *   config.yaml
                *   constants.typoscript
                *   page.tsconfig
                *   settings.yaml
                *   setup.typoscript

            *   ...

    *   Resources

        *   ...

    *   composer.json
    *   ...

..  _site-sets-example-site-package-set:

Defining the site set with a fluid_styled_content dependency
------------------------------------------------------------

As our example site package only contains one site set the name of that set
is the same like the composer name of the site package.

The site package depends on EXT:fluid_styled_content. Therefore the two
sets provided by that system extension are included as dependencies:

..  include:: _Sets/_site-package/_config.rst.txt

If you need additional dependencies, you can find all available sets with the
console command :ref:`bin/typo3 site:sets:list <site-sets-cli>`.

..  _site-sets-example-usage:

Using the site set as dependency of a site
------------------------------------------

After the example site package is installed, you can include the site set
in your site configuration:

..  literalinclude:: _Sets/_site-package/_site_config.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

..  _site-sets-example-typoscript:

Loading TypoScript via the site package's set
---------------------------------------------

The example site package also loads its TypoScript by placing the files
:file:`constants.typoscript` and :file:`setup.typoscript` into the folder of the
site set. These TypoScript files use :typoscript:`@import` statements to import
files from the extension's directory :path:`Configuration/TypoScript`:

..  include:: _Sets/_site-package/_setup.rst.txt

Dependant TypoScript is included by the dependant sets and not by
TypoScript imports.

..  _site-sets-example-settings:

Using the site set to override default settings
-----------------------------------------------

In this example the file
:file:`EXT:site_package/Configuration/Sets/SitePackage/settings.yaml`
is used to
override default settings made by the by the set of
:ref:`EXT:fluid_styled_content <typo3/cms-fluid-styled-content:start>`:

..  include:: _Sets/_site-package/_settings.rst.txt

..  _site-sets-example-extension:

Example: Providing a site set in an extension
=============================================

Non site-package extensions can also provide site sets. These can be used by
sites or site sets to include dependant TypoScript and settings.

The example extension :t3ext:`blog_example` offers one main site set and several
site sets for special use-cases. It has the following file structure:

..  directory-tree::
    :show-file-icons: true

    *   Classes

        *   ...

    *   Configuration

        *   Sets

            *   BlogExample

                *   config.yaml
                *   constants.typoscript
                *   page.tsconfig
                *   setup.typoscript

            *   DefaultStyles

                *   config.yaml
                *   setup.typoscript

            *   RssFeed

                *   config.yaml
                *   constants.typoscript
                *   setup.typoscript

            *   ...

    *   Resources

        *   ...

    *   composer.json
    *   ...

..  _site-sets-example-extension-multiple-sets:

Multiple site sets to include separate functionality
----------------------------------------------------

The main site set of the extension has the same name like the Composer name:

..  include:: _Sets/_blog_example/_config.rst.txt

The other two sets depend on this set being loaded and therefore declare it
as dependency:

..  include:: _Sets/_blog_example/_default_config.rst.txt

..  include:: _Sets/_blog_example/_rss_config.rst.txt

The additional site sets provide TypoScript configuration that depends on
the base site set. They do not use :typoscript:`@include` statements to include
the base TypoScript. The dependencies defined in the site set take care of the
correct loading order of the TypoScript.
