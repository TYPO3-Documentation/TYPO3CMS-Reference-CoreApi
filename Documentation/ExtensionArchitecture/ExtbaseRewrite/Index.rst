:navigation-title: Extbase

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Extbase
..  _extbase-extension-framework:

=====================================
Extbase: Extension framework in TYPO3
=====================================

Extbase is TYPO3's framework for building structured, maintainable extensions.
It provides an object-oriented foundation based on the
`Model-View-Controller (MVC) <https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller>`__
pattern and an
`Object-Relational Mapper (ORM) <https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping>`__
that handles persistence for you — so you work with PHP objects rather than
raw database queries.

Extbase is the natural choice for extensions that revolve around a domain model:
event listings, product catalogues, news feeds, job boards, or any structured
content that editors manage in the backend and visitors browse in the frontend.
It gives you automatic property mapping, built-in validation, clean URL routing,
and a consistent architecture that other TYPO3 developers will immediately
recognise and feel at home in.

This chapter takes you from the first line of code to a fully working extension.
It covers the domain model and repository layer, controllers and views, frontend
plugins and backend modules, routing, validation, persistence, and caching —
with best practices throughout. Whether you are building your first extension
or working through an inherited codebase, you will find both guided walkthroughs
and in-depth reference material here.

..  _extbase-when-to-use:

When to use Extbase
===================

Extbase shines when your extension centres on structured data with create,
read, update, and delete operations. If editors work with records in the TYPO3
backend and those records are displayed or manipulated in the frontend, Extbase
is very likely the right tool.

It is widely used across the TYPO3 ecosystem — extensions like
:composer:`georgringer/news` are built on Extbase and serve as solid
real-world references for the patterns described in this chapter.

..  _extbase-when-not-to-use:

When Extbase is not the right fit
==================================

Extbase is not a universal solution. It requires a full TYPO3 frontend
bootstrap, which makes it unsuitable for middlewares, CLI commands, or
scheduler tasks without extra effort. For those contexts TYPO3's native
APIs are a better choice.

It is also worth considering alternatives for extensions with no meaningful
domain model — site packages, pure content element collections, or
performance-critical code paths where the ORM overhead would be a liability.

..  seealso::

    :ref:`extbase-concepts` explains the MVC pattern and how Extbase
    implements it in detail.

    For extension development without Extbase, see
    :ref:`extension-architecture`.

    Something not working as expected? See
    :ref:`extbase-appendix-pitfalls` for a scannable list of common
    traps and where the full explanation lives.

    Know what you want to achieve but not which chapter covers it? See
    :ref:`extbase-appendix-tasks` for goal-oriented answers with
    links to the full detail.

..  toctree::
    :titlesonly:

    QuickStart/Index
    Concepts/Index
    Domain/Index
    Controller/Index
    View/Index
    Registration/Index
    Routing/Index
    Validation/Index
    Persistence/Index
    Caching/Index
    Configuration/Index
    Advanced/Index
    Appendix/Attributes
    Appendix/CommonPitfalls
    Appendix/CommonTasks
