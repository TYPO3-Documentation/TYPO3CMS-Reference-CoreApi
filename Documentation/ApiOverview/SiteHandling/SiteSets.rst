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

A site set definition contains the configuration for site settings, TypoScript
and PageTSConfig and can be assigned to one or more sites via the site module.
Site set definitions are created in the :path:`Configuration/Sets/` directory
and separated from each other by a sub-folder with any name. In this way,
it is also possible to create several site set definitions per extension. Each
of these sub-folders must have a :file:`config.yaml` that assigns at least a
unique `name` and preferably also a unique `label` to the site set definition.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/config.yaml
    :linenos:

    name: my-vendor/my-set
    label: My Set
    settings:
      website:
        background:
          color: '#386492'
    dependencies:
      - my-vendor/my-other-set
      - other-namespace/fancy-carousel

Line 1: :yaml:`name: my-vendor/my-set`
    Site Set Name
    Similar to the package name of Composer: `[Vendor]/[Package]`
    Is required to uniquely identify the site set
    and to resolve dependencies to other site sets.
    This name does NOT reflect an extension, but only the provider of an
    extension through the vendor name.
    There are NO conclusions from the name here as to which extension
    provided the site set definition.
Line 2: :yaml:`label: My Set`
    This label will be used in the new select box of the site module. Should
    be as unique as possible to avoid duplication in the site module.
Line 3-6: Settings
    Define settings for the website
    **Never** nest settings with a dot! e.g. `website.background.color`
    Otherwise the new settings definitions will not work later.
    If a setting contains special characters or spaces, it is recommended to
    wrap the value in inverted commas. You can also define settings in a
    separate file :file:`settings.yaml`. See section below.
Line 7: Dependencies
    Load :file:`setup.typoscript`, :file:`constants.typoscript`,
    :file:`page.tsconfig` and :file:`config.yaml` from the site set definitions
    of this or other extensions. These dependencies are loaded before your own
    site set. For example a dependency to a site set definition in your own
    site package and/or a dependency to a site set definition from
    another provider (vendor)

..  _site-sets-usage:

Using a site set as dependency in a site
========================================

Sets are applied to sites via `dependencies` array in site configuration:

..  code-block:: yaml
    :caption: config/sites/my-site/config.yaml

    base: 'https://example.com/'
    rootPageId: 1
    dependencies:
      - my-vendor/my-set

Site sets can also be added to a site via the backend module
:guilabel:`Site Management > Sites`.

..  _site-sets-settings-definition:

Settings definitions
====================

The big problem with TypoScript and TSConfig is that each specified value can
only ever be a string. It is up to the developer alone to read these values
and convert them into the desired data type such as integer.

TYPO3 wants to remedy this with settings definitions and now provides an API
with which you can add additional descriptive definitions for each individual
site setting.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

    settings:
      website.background.color:
        # A label for the setting
        label: 'Background color'
        # A detailed description of the setting
        description: 'This will validate the given color string'
        # Which kind of validation/conversion should be applied?
        # See below
        # See: [sysext]/core/Classes/Settings/Type/*
        type: color
        # A default values as fallback, if there was no default
        # defined in config.yaml
        default: '#129845'

..  _definition-types:

Definition Types
----------------

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

    The value must be an array whose array keys start at 0 and increase by 1 per
    element. The list in this type is derived from the internal PHP method
    `array_is_list` and has nothing to do with the fact that comma-separated
    lists can also be converted here.

    The `string` type is executed for each array entry.

..  confval:: color
    :name: site-setting-type-color
    :type: string
    :Path: settings.[my_val].type = color

    Checks whether the specified string can be interpreted as a color code.
    Entries starting with `rgb`, `rgba` and `#` are permitted here.

    For `#` color codes, for example, the system checks whether they
    have 3, 6 or 8 digits.

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
much more effective than the previous
:ref:`static includes <t3tsref:extdev-static-includes>` or manual
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
is the same as the Composer name of the site package.

The site package depends on
:ref:`EXT:fluid_styled_content <typo3/cms-fluid-styled-content:start>`.
Therefore the two sets provided by that system extension are included as
dependencies:

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

The example extension :composer:`t3docs/blog-example` offers one main site set and several
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

..  _site-sets-php-api:

Site Set PHP API
================

..  _site-sets-php-api-site:

Site
----

The site settings can be read out via the site object:

..  code-block:: php

    $color = $site->getSettings()->get('website.background.color');

If a settings definition exists for this setting, the returned value has
already been validated, converted and, if not set, the default value is used.

..  _site-sets-php-api-setregistry:

SetRegistry
-----------

The `SetRegistry` retrieves the site sets found in an ordered sequence, as
defined by `dependencies` in `config.yaml`. Please preferably use the site
object to access the required data. However, if you need to query one or more
site set definitions in order as defined by dependencies, then `SetRegistry`
is the right place to go. To read all site set definitions, please
use `SetCollector`.

..  _site-sets-php-api-setregistry-getsets:

getSets
~~~~~~~

Reads one or more site set definitions including their dependencies.

..  code-block:: php

    $sets = $setRegistry->getSets('my-vendor/my-set', 'my-vendor/my-set');

..  _site-sets-php-api-setregistry-hasset:

hasSet
~~~~~~

Checks whether a site set definition is available.

..  code-block:: php

    $hasSet = $setRegistry->hasSet('my-vendor/my-set');

..  _site-sets-php-api-setregistry-getset:

getSet
~~~~~~

Reads a site set definition WITHOUT dependencies.

..  code-block:: php

    $set = $setRegistry->getSet('my-vendor/my-set');

..  _site-sets-php-api-setcollector:

SetCollector
~~~~~~~~~~~~

TYPO3 comes with a new `ServiceProvider`, which goes through all extensions
with the first instantiation of the `SetCollector` and reads all site set
definitions found.

..  code-block:: php

    public function __construct(
        #[Autowire(lazy: true)]
        protected SetCollector $setCollector,
    ) {}

However, this is not the official way to access the site set definitions and
their dependencies. Please access the configuration via the site object.
Alternatively, you can also use the `SetRegistry`, as only this manages the
site sets in the order declared by the dependency specification.

Only use the `SetCollector` if you need to read all site set definitions.
Dependencies are not taken into account here.
