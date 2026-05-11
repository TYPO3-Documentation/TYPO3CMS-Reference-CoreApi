:navigation-title: Concepts

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Concepts
..  _extbase-concepts:

========================
Core concepts of Extbase
========================

Before working with Extbase in detail it helps to understand the two ideas
that shape everything else: the MVC pattern and the ORM.

**MVC** (Model-View-Controller) is an architectural pattern that separates what
your data looks like, how it is displayed, and what happens when a user makes a
request. Extbase enforces this separation structurally — controllers, models,
and templates each live in their own place and have clearly defined
responsibilities.

**ORM** (Object-Relational Mapping) is the mechanism that lets you work with
PHP objects instead of raw database rows. You call methods on a repository and
receive populated domain objects; the SQL stays out of your way.

Understanding these two ideas makes the rest of Extbase predictable. The naming
conventions, the file structure, the way repositories work, the way actions are
dispatched — all of it follows directly from MVC and ORM principles.

..  note::

    The pages in this chapter give you the bird's-eye view. They explain the
    *why*, not the *how*. Each section links to the dedicated chapter where the
    full detail lives — follow those links when you are ready to build.

..  toctree::
    :titlesonly:

    Mvc
    Persistence
