:navigation-title: Introduction

..  include:: /Includes.rst.txt
..  index::
    pair: Extension development; Extbase introduction

..  _extbase-introduction:

====================
Extbase introduction
====================

..  todo:: Refer to a good example, e.g. tea, blog_example?

..  todo:: Add tips how to get more information or help

..  _extbase-introduction-what-is:

What is Extbase?
================

Extbase is provided via a TYPO3 system extension (typo3-cms/extbase). Extbase is
a framework within the TYPO3 Core. The framework is based on the software pattern
`MVC (model-view-controller) <https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller>`__
and uses
`ORM (object relational modeling) <https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping>`__.

Extbase can be and is often used in combination with the Fluid templating engine,
but Fluid **can** also be used without Extbase. Backend modules and
plugins can be implemented using Extbase, but  can also be done with TYPO3 Core
native functionality.
Extbase is not a prerequisite for extension development. In most cases,
using Extbase means writing less code, but the performance may suffer.

Key parts of Extbase are the Object Relational Model (ORM),  automatic validation
and its "Property Mapper".

When Extbase was released, it was introduced as the modern way to program
extensions and the "old" way (pibase) was propagated as outdated. When we look
at this today, it is not entirely true: Extbase is a good fit for some specific
types of extensions and there are always alternatives. For some use cases it
is not a good fit at all and the extension can and should be developed without
Extbase.

Thus, many things, such as backend modules or plugins can be done "the Extbase
way" or "the Core way". This is a design decision, the extension developer must
make for the specific use case.

..  attention::

    Extbase is one of many options in the "toolbox" of TYPO3 extension development.

    TYPO3 is flexible, often provides several approaches for one thing and it is
    up to the extension developer to make an informed choice.

..  _extbase-introduction-or-not:

Extbase or not?
===============

When to use Extbase and when to use other methods?

As a rule of thumb (which should not be blindly followed but gives some
guidance):

Use Extbase if you:

*   wish to get started quickly, e.g. using the
    :ref:`extension_builder <extension-builder>`
*   are a beginner or do not have much experience with TYPO3
*   want to create a "classic" Extbase extension with plugins and (possibly)
    backend modules (as created with the extension_builder)

Do not use Extbase

*   if performance might be an issue with the "classic" Extbase approach
*   if there is no benefit from using the Extbase approach
*   if you are writing an extension where Extbase does not add any or much value,
    e.g. an extension consisting only of Backend modules, a site package, a
    collection of content elements, an Extension which is used as a command line
    tool.

There is also the possibility to use a "mixed" approach, e.g. use Extbase
controllers, but do not use the persistence of Extbase. Use TYPO3
:ref:`QueryBuilder <database>` (which is based on doctrine/dbal) instead.
With Extbase persistence or with other ORM approaches, you may run into
performance problems. The database tables are mapped to "Model" objects which
are acquired via "Repository" classes. This often means more is fetched, mapped
and allocated than necessary. Especially if there are large tables and/or many
relations, this may cause performance problems. Some can be circumvented by
using "lazy initialization" which is supported within Extbase.

However, if you use the "mixed" approach, you will not get some of the
advantages of Extbase and have to write more code yourself.

..  seealso::

    For more information to get started with Extension development, see
    :ref:`extension-create-new`.
