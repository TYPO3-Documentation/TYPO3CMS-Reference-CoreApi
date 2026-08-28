:navigation-title: Site sets

..  include:: /Includes.rst.txt
..  index:: Site handling; Site sets
..  _site-sets:

=========
Site sets
=========

A site set is a reusable package of site configuration. It can contain settings,
TypoScript, page TSconfig and route enhancers. Extensions can provide one set or
several sets for features that integrators can activate separately.

A site activates a set by declaring it as a dependency. TYPO3 then loads the set
and its dependencies in the correct order and removes duplicates.

A set complements the site configuration; it does not replace it. The site
still owns site-specific information such as its base URL, root page and
languages. The set supplies the reusable part that can be shared by several
sites. Installing an extension makes its sets available, but no site uses a set
until the set is selected or added as a dependency.

..  contents:: Table of contents
    :local:

..  toctree::
    :titlesonly:
    :hidden:

    ReusableSets
    ../SiteSettings
    ../SiteSettingDefinitions
    ../SiteSettingsEditor
    Api

..  _site-sets-composition:

Configuration composition
=========================

When TYPO3 loads a site, it starts with the set identifiers declared by that
site. It resolves their dependencies recursively and applies every dependency
before the set that requires it. This creates one deterministic order even when
several sets share the same dependency.

Settings are composed in layers. A definition supplies the initial value, sets
can provide project or feature presets, and the individual site can make the
final override:

..  code-block:: text

    definition default
      -> dependency and set overrides
        -> site-specific override

The same resolved dependency order controls TypoScript, page TSconfig and route
enhancers. As a result, a site gets one effective configuration without having
to import every extension file manually.

..  _site-sets-definition:

Creating a site set
===================

Create each set in its own subdirectory of :path:`Configuration/Sets/`. The
following example shows all files that TYPO3 discovers there by convention;
only :file:`config.yaml` is required:

..  directory-tree::
    :show-file-icons: true

    *   EXT:my_extension/Configuration/Sets/MySet/

        *   config.yaml
        *   constants.typoscript
        *   labels.xlf
        *   page.tsconfig
        *   route-enhancers.yaml
        *   settings.definitions.yaml
        *   settings.yaml
        *   setup.typoscript


..  _site-sets-files:

Supported files
---------------

:file:`config.yaml`
    Defines the set and its dependencies.

:file:`settings.definitions.yaml`
    Defines settings, their types and default values.

:file:`settings.yaml`
    Overrides values of settings defined by this set or a dependency.

:file:`labels.xlf`
    Translates the set label, category and setting labels and descriptions,
    and enum labels.

:file:`setup.typoscript` and :file:`constants.typoscript`
    Provide TypoScript for sites using the set.

:file:`page.tsconfig`
    Provides page TSconfig for pages in sites using the set.

:file:`route-enhancers.yaml`
    Provides route enhancer presets.

See :ref:`Sets <extension-configuration-sets>` for the detailed configuration file
reference and :ref:`translating labels and descriptions for settings <site-settings-definition-translation>` for
:file:`labels.xlf`.

Most sets need only some of these files. A set that exposes configurable values
may contain only :file:`config.yaml` and :file:`settings.definitions.yaml`. A
site-package set often also contains provider files and :file:`settings.yaml`
because it combines several extension sets into a project-specific preset.

Start with a minimal :file:`config.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/config.yaml

    name: my-vendor/my-set
    label: 'My site set'

`name`
    Required. A globally unique identifier in the form `vendor/set-name`.
    Sites and other sets use this identifier to declare dependencies. It does
    not have to match the extension key or Composer package name.

`label`
    A human-readable, preferably unique label shown in the site module.

The directory name groups the files but is not the public identifier. TYPO3
resolves the set by its `name`, so keep that name stable once other sites or
sets depend on it.

The examples use different identifiers for different purposes:

`my_extension`
    The extension key used in paths such as :file:`EXT:my_extension/`.

`my-vendor/my-set`
    The globally unique site set identifier declared as `name` in
    :file:`config.yaml`.

`myExtension`
    A prefix for setting identifiers such as
    `myExtension.backgroundColor`. Use a stable, extension-specific prefix to
    avoid collisions with settings from other extensions.

These identifiers do not have to use the same spelling. Replace each one with
the corresponding identifier used by your extension or project.

..  _site-sets-settings-definition:

Defining site settings
======================

A setting definition describes a configuration contract. It tells TYPO3 which
identifier exists, which values are valid and which value to use when nobody
has configured an override. TYPO3 also uses this metadata to render a suitable
field in the site settings editor.

Define each setting in :file:`settings.definitions.yaml` before using it. The
following example defines a color setting:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

    settings:
      myExtension.backgroundColor:
        label: 'Background color'
        description: 'Default background color of the site.'
        type: color
        default: '#ffffff'

The definition establishes the setting identifier, type and default value. It
also makes the setting available in the :ref:`Site settings editor <site-settings-editor>`. See
:ref:`Site settings definitions <site-settings-definition>` for all properties and supported types.

..  important::
    :file:`settings.yaml` can only override the value of a setting. It never
    defines the setting itself. Every setting that application code relies on
    must first be defined in :file:`settings.definitions.yaml` by an active set.
    Only that definition provides the type, default value, validation rules and
    editor metadata. See :ref:`Site settings definitions <site-settings-definition>` for the complete
    configuration contract.

..  _site-sets-settings:

Overriding setting defaults
---------------------------

A set can override only the values of settings that are already defined by the
set itself or one of its dependencies. The original definition remains the
single source for the setting's type, default value and metadata; do not copy
it into the overriding set.

Create :file:`settings.yaml` when the set should override a defined default:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.yaml

    myExtension.backgroundColor: '#386492'

A site-specific value in :file:`config/sites/my-site/settings.yaml` takes
precedence over the value from the set. See :ref:`Site settings <sitehandling-settings>` for
the complete loading and access rules.

..  _site-sets-providers:

Providing TypoScript, page TSconfig and routes
==============================================

A set can provide more than settings. These provider files follow conventions:
TYPO3 loads them automatically when they exist next to :file:`config.yaml`, so
they need no separate PHP registration. They apply only to sites that use the
set.

..  _site-sets-typoscript:

TypoScript
----------

Put set-specific TypoScript in :file:`setup.typoscript` and
:file:`constants.typoscript`. TYPO3 loads the files from all dependencies,
orders them and removes duplicates.

The dependency declaration describes why the TypoScript is needed. This makes
the relationship visible in one place and prevents a shared dependency from
being included several times through unrelated imports.

Use this rule for dependencies between sets. Local :typoscript:`@import`
statements within a set are fine. For example, when a set needs the TypoScript
from Fluid Styled Content:

The dependency lets TYPO3 order the sets and remove duplicates. A direct import
or static include bypasses this dependency graph.

..  list-table:: Declaring a cross-set dependency
    :header-rows: 1
    :widths: 50 50

    *   -   Do
        -   Don't
    *   -   Declare `typo3/fluid-styled-content` under `dependencies` in the
            set's :file:`config.yaml`.
        -   Import files from `EXT:fluid_styled_content` in
            :file:`setup.typoscript` or add Fluid Styled Content as a
            :ref:`static include <t3tsref:extdev-static-includes>` in a
            :sql:`sys_template` record.

..  attention::
    In a mixed setup with a TypoScript template (`sys_template`) and site sets,
    disable the :guilabel:`Clear` flags for constants and setup in the
    TypoScript template. When either flag is enabled, the corresponding
    TypoScript from site sets is cleared and does not apply.

..  _site-sets-page-tsconfig:

Page TSconfig
-------------

Put page TSconfig in :file:`page.tsconfig`. TYPO3 applies it only to pages in
sites that use the set. Dependencies determine the loading order and TYPO3
removes duplicates.

This limits the page TSconfig to pages belonging to sites that use the set. For
example, an extension can configure the backend editing interface for an
optional feature without affecting pages in sites where that feature is not
active.

..  _site-sets-route-enhancers:

Route enhancers
---------------

..  versionadded:: 14.1
    See `Feature: #107837 - Route enhancers in site sets <https://docs.typo3.org/permalink/changelog:feature-107837-1732800000>`_

Put route enhancer presets below the `routeEnhancers` key in
:file:`route-enhancers.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/route-enhancers.yaml

    routeEnhancers:
      MyEnhancer:
        type: Simple
        routePath: '/my-path/{param}'
        aspects:
          param:
            type: StaticValueMapper
            map:
              value1: '1'
              value2: '2'

TYPO3 merges route enhancers in dependency order. Later sets can override
earlier sets, and the site configuration takes precedence over all set-defined
enhancers.

The file supports YAML imports:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/route-enhancers.yaml

    imports:
      - { resource: 'route-enhancers/*.yaml' }

    routeEnhancers:
      # Additional enhancers can be defined here

See also:

*   `Routing - readable, SEO-friendly URLs <https://docs.typo3.org/permalink/t3coreapi:routing-introduction>`_
*   `Route enhancements and aspects <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration>`_
*   `The Extbase plugin route enhancer <https://docs.typo3.org/permalink/t3coreapi:extbase-routing-enhancer>`_

..  _site-sets-usage:

Using a site set
================

Add the set identifier to the site's `dependencies` array:

..  code-block:: yaml
    :caption: config/sites/my-site/config.yaml

    base: 'https://example.com/'
    rootPageId: 1
    dependencies:
      - my-vendor/my-set

Alternatively, select the set in :guilabel:`Sites > Setup`.

This dependency is the activation point. Two sites in the same installation
can therefore use different sets or different combinations of sets even though
the providing extensions are installed globally.

After activation, the site settings editor displays the set's defined settings.
Application code can read them through the site object:

..  code-block:: php

    $backgroundColor = $site->getSettings()->get(
        'myExtension.backgroundColor',
    );

Because the setting is defined, TYPO3 validates the value as a color and uses
the default when no set or site override exists. See :ref:`Site set PHP API <site-sets-php-api>`
for more PHP examples.

..  _site-sets-dependencies:

Depending on other site sets
============================

A set can declare required and optional dependencies in :file:`config.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/config.yaml

    name: my-vendor/my-set
    label: 'My site set'
    dependencies:
      - my-vendor/my-required-set
    optionalDependencies:
      - other-vendor/optional-set

`dependencies`
    Required sets. TYPO3 reports an error when one is unavailable.

`optionalDependencies`
    Sets that are loaded when available and skipped without an error otherwise.

TYPO3 resolves dependencies recursively and loads them before the current set.
If several sets require the same dependency, TYPO3 loads it only once. See
:ref:`Define an optional dependency on EXT:form <site-sets-example-site-package-set-optional>` for a complete example.

A set dependency describes a configuration relationship; it does not install
the extension that provides the referenced set. Use a required dependency when
the current configuration cannot work without the other set. Use an optional
dependency only when the set's PHP, Fluid and TypoScript also work when that
dependency is absent.

..  _site-sets-hidden:

Hiding site sets
================

Set `hidden: true` to hide a helper set from the backend set selection and the
default console listing:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyHelperSet/config.yaml

    name: my-vendor/my-helper-set
    label: 'My helper set'
    hidden: true

The flag changes visibility, not dependency resolution. TYPO3 still loads a
hidden set when another set or a site explicitly depends on it. This makes the
flag suitable for technical building blocks that users should not normally
select on their own.

Use user TSconfig to hide additional sets when backend users should choose from
only a curated list:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    options.sites.hideSets := addToList(typo3/fluid-styled-content)

..  _site-sets-cli:

Listing available site sets
===========================

Use the `site:sets:list` command to check whether TYPO3 discovered a set:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 site:sets:list

    ..  group-tab:: Classic mode installation (without Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 site:sets:list

The command lists discovered sets; it does not show which sets are active for a
particular site. Inspect the site's dependencies in :guilabel:`Sites > Setup`
or :file:`config/sites/<my-site>/config.yaml` for that information.

..  _site-sets-keep-going:

Keep going
==========

*   :ref:`Reusable site sets <site-sets-examples>` explains conventions for site packages and
    reusable extension sets.
*   :ref:`Site settings <sitehandling-settings>` explains value precedence and all access
    methods.
*   :ref:`Site settings definitions <site-settings-definition>` is the property and type reference.
*   :ref:`Site settings editor <site-settings-editor>` explains the backend editor.
*   :ref:`Site set PHP API <site-sets-php-api>` documents the PHP API.
