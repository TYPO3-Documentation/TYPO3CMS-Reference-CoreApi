:navigation-title: Quick start

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Quick start
..  _extbase-quickstart:

==============================================
Extbase quick start for experienced developers
==============================================

You know TYPO3, you know PHP, you just want the steps. This page gets a minimal
but fully working Extbase extension in front of you as quickly as possible —
a list and detail view for a custom record type, registered as a frontend plugin.

For the reasoning behind each step, follow the links into the relevant chapters.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-quickstart-scaffold:

Step 1: Scaffold the extension
==============================

Use the `FriendsOfTYPO3 kickstarter package <https://github.com/FriendsOfTYPO3/kickstarter>`__ to generate the extension skeleton:

..  code-block:: bash
    :caption: Shell

    composer require friendsoftypo3/kickstarter --dev
    vendor/bin/typo3 make:extension

Answer the prompts (vendor name, extension key, etc.). The kickstarter generates
the directory structure, :file:`composer.json` and the boilerplate files you need.
Since TYPO3 v14 you do not need :file:`ext_emconf.php` unless you plan to publish
your extension to the `TYPO3 Extension Repository <https://extensions.typo3.org>`__.

..  seealso::

    :ref:`extension-create-new` covers the full scaffolding process, including
    manual setup without the kickstarter.


..  _extbase-quickstart-model:

Step 2: Create the domain model
================================

Add a class extending :php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity` to
:file:`Classes/Domain/Model/`. Properties map to database columns by name.

..  literalinclude:: _snippets/_Event.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/Event.php

Key points:

*   Properties must be :php:`protected`, not :php:`public` — Extbase uses getters
    and setters to access them.
*   Do not set default values or initialise properties in the constructor.
    Extbase bypasses the constructor when hydrating objects from the database.
*   Use typed properties. Extbase reads the type declarations to map values
    correctly.

..  seealso::

    :ref:`extbase-domain-model`


..  _extbase-quickstart-repository:

Step 3: Create the repository
==============================

For a basic repository, extending
:php:`\TYPO3\CMS\Extbase\Persistence\Repository` is all you need.
The naming convention is mandatory: a model named :php:`Event` must have a
repository named :php:`EventRepository` in the :php:`Domain\Repository`
namespace.

..  literalinclude:: _snippets/_EventRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

The base class provides :php:`findAll()`, :php:`findByUid()`,
:php:`findBy(array $criteria)`, and :php:`findOneBy(array $criteria)` out of the
box. The old magic :php:`findBy[PropertyName]()` methods were removed in TYPO3 v14.

..  seealso::

    :ref:`extbase-domain-repository`


..  _extbase-quickstart-tca:

Step 4: Define the database table (TCA)
========================================

Create :file:`Configuration/TCA/tx_myextension_domain_model_event.php` with the
column definitions matching your model properties.

Since TYPO3 v13, database columns are
`auto-created from TCA definitions <https://docs.typo3.org/permalink/changelog:feature-101553-1691166389>`__
— you no longer need to define every field in :file:`ext_tables.sql`. Check the
database analyser after installation to confirm the generated schema matches your
expectations. If a column needs a non-default type or index, declare it explicitly
in :file:`ext_tables.sql` and it will take precedence.

The TCA column names must match the property names of your model
(camelCase properties map to snake_case columns by default — for example
:php:`$eventDate` maps to :sql:`event_date`).

..  tip::

    The kickstarter generates TCA and SQL for you if you define your model
    properties during scaffolding. Use :bash:`vendor/bin/typo3 make:model` to
    add a model to an existing extension.

..  seealso::

    :ref:`t3tca:start` for the full TCA reference.


..  _extbase-quickstart-controller:

Step 5: Create the controller
==============================

Controllers live in :file:`Classes/Controller/` and extend
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. Each public method
ending in :php:`Action` is automatically available as a plugin action.
Inject dependencies via the constructor.

..  literalinclude:: _snippets/_EventController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/EventController.php

*   Assign variables to the view with :php:`$this->view->assign()`.
*   Return :php:`$this->htmlResponse()` to render the Fluid template.
*   Typed action arguments are automatically resolved from the request —
    passing an :php:`int` UID in the URL results in a hydrated
    :php:`Event` object in the action.

..  seealso::

    :ref:`extbase-controller-action`


..  _extbase-quickstart-templates:

Step 6: Add Fluid templates
============================

Create the template files Extbase expects by convention:

..  directory-tree::
    :show-file-icons: true

    *   EXT:my_extension/Resources/Private/

        *   Templates/

            *   Event/

                *   List.fluid.html
                *   Show.fluid.html

        *   Layouts/

            *   Default.fluid.html

        *   Partials/

The template name matches the action name — for example :php:`listAction()` maps
to :file:`List.fluid.html`. Variables assigned in the controller are available
directly in the template.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Event/List.fluid.html

    <f:for each="{events}" as="event">
        <h2>{event.title}</h2>
        <p>{event.eventDate -> f:format.date(format: 'd.m.Y')}</p>
        <f:link.action action="show" arguments="{event: event}">
            Read more
        </f:link.action>
    </f:for>

..  seealso::

    :ref:`extbase-view-overview`

    :ref:`fluid` — the full Fluid templating reference, including all built-in
    ViewHelpers.


..  _extbase-quickstart-plugin:

Step 7: Register the plugin
============================

Two calls are required — one in :file:`ext_localconf.php`, one in
:file:`Configuration/TCA/Overrides/tt_content.php`.

Since TYPO3 v14, plugins are registered as dedicated content types (:sql:`CType`)
rather than as subtypes of the old "General Plugin" element. The old
:sql:`list_type` approach is gone.

:file:`ext_localconf.php` tells Extbase which controller actions the plugin
may call:

..  literalinclude:: _snippets/_ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

:file:`Configuration/TCA/Overrides/tt_content.php` registers the plugin as a
content element in the backend:

..  literalinclude:: _snippets/_tt_content.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

..  seealso::

    :ref:`extbase-registration-frontend-plugin`


..  _extbase-quickstart-routing:

Step 8: Configure routing (optional but recommended)
======================================================

Without a route enhancer, URLs contain the raw plugin namespace parameters
(for example: :samp:`?tx_myextension_eventlist[action]=show&tx_myextension_eventlist[event]=5`).
Add an Extbase route enhancer to your site configuration to get
clean URLs like :samp:`/events/my-event`.

..  literalinclude:: _snippets/_routing.yaml
    :language: yaml
    :caption: config/sites/my-site/config.yaml (excerpt)

..  seealso::

    :ref:`extbase-routing` — the full routing chapter with detailed
    examples and common mistakes.


..  _extbase-quickstart-next:

What next?
==========

You have a working extension. From here:

*   :ref:`extbase-concepts` — understand the MVC and ORM patterns
    underlying everything above.
*   :ref:`extbase-persistence-queries` — write custom repository
    queries with ordering, filtering, and limits.
*   :ref:`extbase-validation-overview` — validate model properties and action
    arguments automatically.
*   :ref:`extbase-caching-overview` — understand how caching works for your
    plugin and what your responsibilities are.
