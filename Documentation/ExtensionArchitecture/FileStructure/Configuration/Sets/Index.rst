:navigation-title: Sets

..  include:: /Includes.rst.txt
..  _extension-configuration-sets:

=====================================
Extension folder `Configuration/Sets`
=====================================

This directory contains an extension's
`Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_.

Each set must be in its own directory and consist of at least a
:file:`config.yaml` file.


..  _extension-configuration-sets-config-yaml:

..  typo3:file:: config.yaml
    :name: set-config-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/config\.yaml$/
    :shortDescription: Contains the definition of a site set. Mandatory.

    Contains the `definition of the site set <https://docs.typo3.org/permalink/t3coreapi:site-sets-definition>`_
    and any dependencies.

Example:

..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_config.yaml
    :caption: EXT:site_package/Configuration/Sets/SitePackage/config.yaml

..  _extension-configuration-sets-settings-yaml:

..  typo3:file:: settings.yaml
    :name: set-settings-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/settings\.yaml$/
    :shortDescription: Override settings defined by other sets.

    In this file an extension can override settings defined by other sets, for
    example, :ref:`settings defined in the "Fluid Styled Content" site set <typo3/cms-fluid-styled-content:site-set-fluid-styled-content-settings>`:

    Values in this file do not create setting definitions. Every setting must
    be defined by an active set before code relies on it.

    ..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_settings-map.yaml
        :caption: EXT:site_package/Configuration/Sets/SitePackage/settings.yaml

..  _extension-configuration-sets-settings-definitions-yaml:

..  typo3:file:: settings.definitions.yaml
    :name: set-settings-definitions-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/settings\.definitions\.yaml$/
    :shortDescription: Contains the setting definition and defaults of a set.

    In this file an extension can define its own settings:
    `Site settings definitions <https://docs.typo3.org/permalink/t3coreapi:site-settings-definition>`_.

..  _extension-configuration-sets-setup-typoscript:

..  typo3:file:: setup.typoscript
    :name: set-setup-typoscript
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/setup\.typoscript$/
    :shortDescription: Provides frontend TypoScript for sites depending on this set.

    This file contains a set's Frontend
    :ref:`TypoScript <t3tsref:guide-overview>`. If the
    extension keeps its TypoScript in folder `TypoScript <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-typoscript>`_
    for backward compatibility reasons, this file **should** import
    the :file:`Configuration/TypoScript/setup.typoscript` file in the main
    extension set:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MySet/setup.typoscript

    # For backward compatibility reasons setup.typoscript was not moved
    @import 'EXT:my_extension/Configuration/TypoScript/setup.typoscript'

..  _extension-configuration-sets-constants-typoscript:

..  typo3:file:: constants.typoscript
    :name: set-constants-typoscript
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/constants\.typoscript$/
    :shortDescription: Provides frontend TypoScript constants for sites depending on this set.

    This file contains the Frontend TypoScript Constants in the set.
    This file should be used if the extension depends on other extensions
    that still rely on TypoScript constants.

..  _extension-configuration-sets-page-tsconfig:

..  typo3:file:: page.tsconfig
    :name: set-page-tsconfig
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/page\.tsconfig$/
    :shortDescription: Provides page TSconfig (backend TypoScript) for sites depending on this set.

    This file contains the :ref:`Page TSconfig <t3tsref:pagetoplevelobjects>`
    (backend TypoScript).

..  _extension-configuration-sets-route-enhancers-yaml:

..  typo3:file:: route-enhancers.yaml
    :name: set-route-enhancers-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/route-enhancers\.yaml$/
    :shortDescription: Provides route enhancers for sites depending on this set.

    This file contains route enhancer presets that are merged into the site
    configuration. See :ref:`Route enhancers <site-sets-route-enhancers>`.
