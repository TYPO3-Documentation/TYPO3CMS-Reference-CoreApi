.. include:: /Includes.rst.txt
.. _extension-configuration-sets:

============
:file:`Sets`
============

..  versionadded:: 13.1
    `Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_ have
    been introduces.

In this directory TYPO3 extensions can provide their
`Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_.

Each set must be saved in its own directory and have at least a file called
:file:`config.yaml`.

..  contents:: Files in a set:

.. _extension-configuration-sets-config-yaml:

:file:`config.yaml` (mandatory)
===============================

Contains the `definition of a site set <https://docs.typo3.org/permalink/t3coreapi:site-sets-definition>`_
and its dependencies.

Example:

..  include:: /ApiOverview/SiteHandling/_Sets/_site-package/_config.rst.txt

.. _extension-configuration-sets-settings-yaml:

:file:`settings.yaml`
=====================

In this file an extension can override settings defined by other sets. For
example :ref:`Settings provided by site set "Fluid Styled Content" <typo3/cms-fluid-styled-content:site-set-fluid-styled-content-settings>`:

..  include:: /ApiOverview/SiteHandling/_Sets/_site-package/_settings.rst.txt

.. _extension-configuration-sets-settings-definitions-yaml:

:file:`settings.definitions.yaml`
=================================

In this file an extension can define its own settings:
`Site settings definitions <https://docs.typo3.org/permalink/t3coreapi:site-settings-definition>`_.

.. _extension-configuration-sets-setup-typoscript:

:file:`setup.typoscript`
========================

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

:file:`constants.typoscript`
============================

This file contains the Frontend TypoScript Constants that the set should
provide. This file can be used if your extension depends on other extensions
that still rely on TypoScript constants.

.. _extension-configuration-sets-page-tsconfig:

:file:`page.tsconfig`
=====================

This file contains the :ref:`Page TSconfig <t3tsref:pagetoplevelobjects>`
(backend TypoScript) that the set should provide.
