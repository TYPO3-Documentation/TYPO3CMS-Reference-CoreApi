:navigation-title: Extbase

..  include:: /Includes.rst.txt
..  index::
    pair: Extension development; Extbase
..  _extbase:

=====================================
Extbase: Extension framework in TYPO3
=====================================

Extbase is an extension framework to create TYPO3 frontend plugins and TYPO3
backend modules. Extbase can be used to develop extensions but it does not
have to be used.

..  _extbase-start-overview:

Overview
========

Extbase is a framework for developing TYPO3 extensions, providing a structured
approach based on the `Model-View-Controller (MVC) pattern <https://de.wikipedia.org/wiki/Model_View_Controller>`_.

..  _extbase-start-principles:

Key Principles
==============

Extbase follows principles of `Domain-Driven Design (DDD) <https://en.wikipedia.org/wiki/Domain-driven_design>`_,
enabling developers to build well-structured domain models. By leveraging
object-oriented programming concepts and dependency injection, Extbase
promotes maintainability and testability.

..  _extbase-start-fluid-integration:

Integration with Fluid
======================

Extbase integrates seamlessly with `Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_,
TYPO3's templating engine, for flexible rendering of frontend content.

..  _extbase-start-database-interaction:

Database Interaction
====================

Extbase offers a repository pattern and automatic data mapping to interact with
the database.

..  _extbase-start-considerations:

Considerations
==============

While Extbase is a supported and widely used framework within TYPO3, developers
should evaluate whether it fits their specific project needs, as performance
considerations may lead to different implementation strategies. For practical
guidance, refer to :ref:`extension tutorials <extension-tutorials>`, which
demonstrate best practices for using Extbase in various scenarios.

..  toctree::
    :titlesonly:

    Introduction/Index
    Reference/Index
    Examples/Index
