:navigation-title: Backend modules

..  include:: /Includes.rst.txt
..  index:: Extbase; Backend module runtime
..  _extbase-no-frontend-backend-module:

==========================
Extbase in backend modules
==========================

..  note::

    This page is a work in progress. Content will be added as part of the
    Extbase documentation overhaul.

..  todo::
    Stub page. Planned content: the backend module runtime — dispatch,
    configuration resolution via :typoscript:`module.tx_<extension>`, and the
    differences from a frontend plugin.

A backend module gives editors and administrators a place to work with an
extension's own data: reviewing submissions, maintaining records that have no
frontend form, running reports over the domain model. It is the natural home
for everything an extension needs to offer beyond its frontend output.

Extbase supports this directly. The backend establishes its own request and
configuration, and Extbase has a dedicated code path for it, so the domain
models, repositories and validators an extension already has can be reused in
a module without rewriting them against a lower-level API.

The essentials:

*   Registration is a separate topic and is already documented. See
    :ref:`extbase-registration-backend-module`.
*   Configuration
    comes from :typoscript:`module.tx_<extension>` rather than
    :typoscript:`plugin.tx_<extension>`.
*   The storagePid is resolved differently than in the frontend. See
    :ref:`extbase-persistence-storagepid-backend`.
*   Language handling differs as well, and depends on whether the module works
    with a page tree. See :ref:`extbase-localisation-no-frontend-backend`.

..  seealso::

    :ref:`extbase-localisation-no-frontend` for the language side of running
    Extbase outside the frontend.
