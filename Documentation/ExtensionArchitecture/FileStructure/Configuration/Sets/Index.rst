:navigation-title: Sets

..  include:: /Includes.rst.txt
..  _extension-configuration-sets:

=====================================
Extension folder `Configuration/Sets`
=====================================

..  versionadded:: 13.1
    `Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_ have
    been introduced.

In this directory TYPO3 extensions can provide their
`Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_.

Each set must be saved in its own directory and have at least a file called
:file:`config.yaml`.

.. _extension-configuration-sets-config-yaml:

..  typo3:file:: config.yaml
    :name: set-config-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/config\.yaml$/
    :shortDescription: Contains the definition of a site set. Mandatory.

    Contains the `definition of a site set <https://docs.typo3.org/permalink/t3coreapi:site-sets-definition>`_
    and its dependencies.

Example:

..  include:: /ApiOverview/SiteHandling/_Sets/_site-package/_config.rst.txt

.. _extension-configuration-sets-settings-yaml:

..  typo3:file:: settings.yaml
    :name: set-settings-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/settings\.yaml$/
    :shortDescription: Override settings defined by other sets.

    In this file an extension can override settings defined by other sets. For
    example :ref:`Settings provided by site set "Fluid Styled Content" <typo3/cms-fluid-styled-content:site-set-fluid-styled-content-settings>`:

    ..  literalinclude:: /ApiOverview/SiteHandling/_Sets/_site-package/_settings-map.yaml
        :language: yaml
        :caption: config/sites/<my_site>/settings.yaml | typo3conf/sites/<my_site>/settings.yaml

.. _extension-configuration-sets-settings-definitions-yaml:

..  typo3:file:: settings.definitions.yaml
    :name: set-settings-definitions-yaml
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/settings\.definitions\.yaml$/
    :shortDescription: Contains the setting definition and defaults of a set.

    In this file an extension can define its own settings:
    `Site settings definitions <https://docs.typo3.org/permalink/t3coreapi:site-settings-definition>`_.

.. _extension-configuration-sets-setup-typoscript:

..  typo3:file:: setup.typoscript
    :name: set-setup-typoscript
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/setup\.typoscript$/
    :shortDescription: Provides frontend TypoScript for sites depending on this set.

    This file contains the Frontend :ref:`TypoScript <t3tsref:guide-overview>`
    that the set should provide. If the
    extension keeps its TypoScript in folder `TypoScript <https://docs.typo3.org/permalink/t3coreapi:extension-configuration-typoscript>`_
    for backward compatibility reasons this file **should** contain an import of
    file :file:`Configuration/TypoScript/setup.typoscript` for the main set of the
    extension:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MySet/setup.typoscript

    # For backward compatibility reasons setup.typoscript was not moved
    @import 'EXT:my_extension/Configuration/TypoScript/setup.typoscript'

.. _extension-configuration-sets-constants-typoscript:

..  typo3:file:: constants.typoscript
    :name: set-constants-typoscript
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/constants\.typoscript$/
    :shortDescription: Provides frontend TypoScript constants for sites depending on this set.

    This file contains the Frontend TypoScript Constants that the set should
    provide. This file can be used if your extension depends on other extensions
    that still rely on TypoScript constants.

.. _extension-configuration-sets-page-tsconfig:

..  typo3:file:: page.tsconfig
    :name: set-page-tsconfig
    :scope: set
    :regex: /^.*Configuration\/Sets\/[\w\-]+\/page\.tsconfig$/
    :shortDescription: Provides page TSconfig (backend TypoScript) for sites depending on this set.

    This file contains the :ref:`Page TSconfig <t3tsref:pagetoplevelobjects>`
    (backend TypoScript) that the set should provide.
