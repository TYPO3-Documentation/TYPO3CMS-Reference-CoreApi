:navigation-title: New Extbase Docu (WIP)

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Extbase
..  _extbase-extension-framework:

=====================================
Extbase: Extension framework in TYPO3
=====================================

Extbase is TYPO3's framework for building structured, maintainable extensions.
It provides an object-oriented foundation based on the
`Model-View-Controller (MVC) <https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller>`_
pattern and an
`Object-Relational Mapper (ORM) <https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping>`_
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

Extbase is the right choice when your extension revolves around **structured
data that visitors consume**: event listings, product catalogues, news feeds,
job boards, book reviews — anything that lives in the database and needs to be
browsed, filtered, sorted, or displayed in the frontend. This is where Extbase
excels, and where the investment in a proper domain model pays off quickly.
Extensions like :composer:`georgringer/news` are proof: a well-built Extbase
extension can serve millions of page views and remain straightforward to
maintain and extend.

Extbase also handles **simple frontend data entry** well — a conference
registration, a newsletter sign-up, a visitor review — as long as the data
stays simple. When records have complex relationships, or when editors need to
manage them, that work belongs in a backend module, not a frontend form.

..  _extbase-when-not-to-use:

When Extbase is not the right fit
==================================

Extbase is not a universal solution. If there is no structured domain to model
— a site package, a collection of content elements, a utility extension — it
adds overhead without benefit. Use TYPO3's native APIs directly.

Performance is another limit to keep in mind. Extbase maps every database row to a
PHP object, which is comfortable for moderate datasets but becomes a bottleneck
when a single page request pulls in thousands of records. There is no hard
number; it depends on query complexity, relation depth, and how aggressively you
cache — but if you expect very large datasets, benchmark early and consider
whether raw database queries or a dedicated search index would serve you better
from the start.

Finally, Extbase requires a full TYPO3 frontend bootstrap and is not the right
fit for middlewares, CLI commands, or scheduler tasks. For those, TYPO3's native
APIs are the natural choice.

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
    Appendix/Upgrading
