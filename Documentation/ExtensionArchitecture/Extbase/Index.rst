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

Extbase is a framework for developing TYPO3 extensions, providing a structured
approach based on the
`Model-View-Controller (MVC) pattern <https://de.wikipedia.org/wiki/Model_View_Controller>`.
It follows principles of
`Domain-Driven Design (DDD) <https://en.wikipedia.org/wiki/Domain-driven_design>`,
enabling developers to build well-structured domain models. By leveraging
object-oriented programming concepts and dependency injection, Extbase
promotes maintainability and testability. It integrates seamlessly with
`Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_,
TYPO3's templating engine, for flexible rendering of frontend content. Extbase
also offers a repository pattern and automatic data mapping to interact with
the database. While it is a supported and widely used framework within TYPO3,
developers should evaluate whether it fits their specific project needs, as
performance considerations may lead to
:ref:`alternative approaches <extension-tutorials>`.

..  toctree::
    :titlesonly:

    Introduction/Index
    Reference/Index
    Examples/Index
