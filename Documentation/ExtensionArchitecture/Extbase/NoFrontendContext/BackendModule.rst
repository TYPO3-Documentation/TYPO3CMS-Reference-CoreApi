:navigation-title: Backend modules

..  include:: /Includes.rst.txt
..  index:: Extbase; Backend module
..  _extbase-no-frontend-backend-module:

==========================
Extbase in backend modules
==========================

A backend module gives editors and administrators a place to work with an
extension's own data: reviewing submissions, maintaining records that have no
frontend form, running reports over the domain model. It is the natural home
for everything an extension needs to offer beyond its frontend output.

Extbase supports this directly. The backend establishes its own request and
configuration, and Extbase has a dedicated code path for it, so the domain
models, repositories and validators an extension already has can be reused in
a module without rewriting them against a lower-level API.

Of the three contexts in this chapter, the backend module is the only one
Extbase is designed for. Commands and middlewares use Extbase outside the
context it expects; a module is a supported target with rules of its own. The
configuration comes from a different TypoScript scope, storage pages and
language are resolved from the backend, and a module without a page tree has
to bring more of its configuration itself.

Building a module is covered in its own chapter:
:ref:`Building backend modules with Extbase <extbase-backend-module>`.

..  seealso::

    *   `How an Extbase backend module works
        <https://docs.typo3.org/permalink/t3coreapi:extbase-backend-module-basics>`_
        — request flow, configuration and storage pages in a module.

    *   `Localization outside the frontend context
        <https://docs.typo3.org/permalink/t3coreapi:extbase-localisation-no-frontend>`_
        — the language side of running Extbase outside the frontend.
