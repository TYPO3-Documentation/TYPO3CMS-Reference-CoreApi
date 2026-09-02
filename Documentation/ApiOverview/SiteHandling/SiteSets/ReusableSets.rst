:navigation-title: Reusable sets

..  include:: /Includes.rst.txt
..  index:: Site handling; Reusable site sets
..  _site-sets-examples:

==================
Reusable site sets
==================

A site package usually provides one set that configures a specific project. A
reusable extension can provide one base set and additional sets for optional
features. Both use the same file conventions and dependency mechanism.

The :ref:`Site sets <site-sets>` chapter provides the quickstart and file reference. This
article builds on those mechanics and focuses on design decisions using complete
extension examples.

The distinction is about responsibility. A reusable extension owns the
configuration contract for its feature, including setting definitions and safe
defaults. A site package decides how those features are combined for a project
and which defaults should be overridden.

..  contents:: Table of contents
    :local:
    :depth: 2

..  _site-sets-example-site-package:

Providing a set in a site package
=================================

Use a site-package set to combine project dependencies, TypoScript and setting
overrides.

Think of this set as the integration layer of the project. Instead of asking an
integrator to select several extension sets, include them as dependencies of
the site-package set. The site then activates one clearly named set and receives
the complete project configuration.

You can see an example of using a set within a site package in the extension
`t3docs/site-package (source on GitHub) <https://github.com/TYPO3-Documentation/TYPO3CMS-Tutorial-SitePackage-Code>`__.

The site package example extension has the following file structure:

..  directory-tree::
    :show-file-icons: true

    *   Configuration

        *   Sets

            *   MySitePackage

                *   config.yaml
                *   constants.typoscript
                *   page.tsconfig
                *   route-enhancers.yaml
                *   settings.yaml
                *   setup.typoscript

            *   ...

    *   Resources

        *   ...

    *   :file:`composer.json <extension-composer-json>`
    *   ...


..  _site-sets-example-site-package-set:

Define the dependency on EXT:fluid_styled_content
-------------------------------------------------

As the example site package contains only one site set, the set has the same
name as the Composer package.

Matching both names is a convention, not a technical requirement. It makes the
main set easy to discover and communicates that it is the default integration
offered by the package.

The site package depends on
:ref:`EXT:fluid_styled_content <typo3/cms-fluid-styled-content:start>`.
Therefore, the two sets provided by that system extension are included as
dependencies:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_config.yaml
    :caption: EXT:site_package/Configuration/Sets/SitePackage/config.yaml

Find all available sets with the console command
:ref:`bin/typo3 site:sets:list <site-sets-cli>`.

..  _site-sets-example-site-package-set-optional:

Define an optional dependency on EXT:form
-----------------------------------------

Optional dependencies work similarly to `suggest` in :file:`composer.json`
(see :ref:`composer.json properties <ext-composer-json-properties>`). An
optional dependency is loaded only when the referenced site set is available.
If it is unavailable, TYPO3 skips it without reporting an error.

In this example, the `typo3/form` set is loaded when it is available:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_config_optional.yaml
    :caption: EXT:site_package/Configuration/Sets/SitePackage/config.yaml

..  hint::
    If you include optional dependencies, ensure that all other code, such as
    PHP and Fluid, also operates gracefully without them. List the extension
    in the Composer `suggest` key where appropriate.

..  _site-sets-example-usage:

Use the site set as a site dependency
-------------------------------------

After the example site package is installed, include the site set in the site
configuration:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_site_config.yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

The site configuration remains responsible for enabling the set. Installing
the site package alone does not change an existing site.

..  _site-sets-example-typoscript:

Load TypoScript via the site package's set
------------------------------------------

The example site package loads its TypoScript by placing
:file:`constants.typoscript` and :file:`setup.typoscript` in the set directory.
These files use :typoscript:`@import` statements to import local TypoScript
files from :path:`Configuration/Sets/SitePackage/TypoScript`:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_setup.typoscript
    :caption: EXT:site_package/Configuration/Sets/SitePackage/setup.typoscript

TypoScript from dependencies is included by the dependent sets, not by
TypoScript imports.

..  _site-sets-example-settings:

Override default settings
-------------------------

In this example,
:file:`EXT:site_package/Configuration/Sets/SitePackage/settings.yaml` overrides
default settings from
:ref:`EXT:fluid_styled_content <typo3/cms-fluid-styled-content:start>`:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_settings-map.yaml
    :caption: EXT:site_package/Configuration/Sets/SitePackage/settings.yaml

These values are project presets. The site package does not redefine the
settings because their definitions and validation rules belong to
`typo3/fluid-styled-content`. Individual sites can still override the presets
in their own :file:`settings.yaml`.

..  _site-sets-example-extension:

Providing sets in a reusable extension
=======================================

Use multiple sets when an extension provides reusable configuration or offers
features that integrators can activate separately.

Keep the base set focused on configuration required by every use of the
extension. Put optional presentation, feeds or integrations into additional
sets. This lets integrators choose a small dependency instead of loading every
feature provided by the extension.

Extensions other than site packages can also provide site sets. Sites or
other sets can depend on them to load their TypoScript and settings.

The example extension :composer:`t3docs/blog-example` offers one main site set
and several sets for specific use cases. It has the following file structure:

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

Separate functionality into multiple site sets
-----------------------------------------------

The main site set of the extension has the same name as the Composer package:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_blog_example/_config.yaml
    :caption: EXT:blog_example/Configuration/Sets/BlogExample/config.yaml

The other two sets require this set and therefore declare it as a dependency:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_blog_example/_default_config.yaml
    :caption: EXT:blog_example/Configuration/Sets/DefaultStyles/config.yaml

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_blog_example/_rss_config.yaml
    :caption: EXT:blog_example/Configuration/Sets/RssFeed/config.yaml

The additional site sets provide TypoScript that depends on the base site set.
They do not use :typoscript:`@include` statements for the base TypoScript. The
declared dependency determines the loading order.

Because each feature set depends on the base set, consumers do not need to
repeat that dependency in their site package. TYPO3 follows the graph,
deduplicates the base set and loads it before the selected feature.

..  _site-sets-reusable-boundaries:

Choosing set boundaries
=======================

A set should represent a configuration unit that makes sense to enable as a
whole. Keep configuration together when its parts always depend on each other.
Split it when an integrator may reasonably want one feature without another.

As a practical guideline:

*   keep a setting definition in the set that owns the corresponding feature;
*   keep project-specific values in the site-package set;
*   express relationships through set dependencies instead of duplicating
    imports; and
*   hide a set only when it is a technical building block that should normally
    be pulled in by another set.
