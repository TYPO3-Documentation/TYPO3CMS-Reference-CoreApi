:navigation-title: Outside the frontend

..  include:: /Includes.rst.txt
..  index:: Extbase; Outside the frontend
..  _extbase-no-frontend:

========================================
Using Extbase outside a frontend request
========================================

..  note::

    This chapter is a work in progress. Each page states the essentials;
    full guidance and examples will be added as part of the Extbase
    documentation overhaul.

..  todo::
    Stub chapter. Planned content: what each context provides, what has to be
    established before Extbase can be used, worked examples per context, and
    guidance on when the work belongs elsewhere.

Extbase expects a fully prepared frontend request. By the time an Extbase
plugin runs, the frontend has resolved the page and built the TypoScript
configuration that Extbase reads its settings from.

Outside that context, that preparation has not happened, and Extbase reacts in
two different ways depending on which part of it is used. Controllers, views
and anything else resolving :typoscript:`plugin.tx_<extension>` configuration
fail outright. The persistence layer is deliberately allowed to run without a
request, but with no configuration to draw on it limits it queries to
storagePid :php:`0` alone, so repositories might return nothing rather than
report a problem.

Three contexts run into this, each with a different amount of the frontend
available:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Extbase in backend modules <extbase-no-frontend-backend-module>`

        A request, but not a frontend one. The backend provides its own
        configuration, and Extbase runs in a supported but different mode.

    ..  card:: :ref:`Extbase on the command line <extbase-no-frontend-command>`

        No request at all. Nothing of the frontend exists unless the command
        establishes it.

    ..  card:: :ref:`Extbase in middlewares <extbase-no-frontend-middleware>`

        Anything or nothing, depending on where in the middleware chain the
        middleware runs — the frontend may not have been prepared yet.

Each page describes what is available in that context, what has to be
established before Extbase can be used, and when the work belongs somewhere
else entirely.

..  toctree::
    :titlesonly:
    :hidden:

    BackendModule
    Command
    Middleware
