..  include:: /Includes.rst.txt
..  index:: Page types; Custom
..  _page-types-example:

====================
Create new Page Type
====================

This example demonstrates how to add a new page type (doktype) called "Archive" in TYPO3 v14.
Starting with TYPO3 v14, the registration is more streamlined by centralizing
the configuration within the Table Configuration Array (TCA).

..  note::
    **Important for v14:** The ``doktype`` must be defined as a **string** (e.g., ``'116'``).
    In TYPO3 v14, strict comparisons in the Page Wizard's TypeScript components
    (Lit-templates) will fail if an integer is used, causing UI issues like
    resets or validation errors.

1. Configure the Page Type in TCA
=================================

To define the behavior and appearance of the new page type, create or edit
:file:`Configuration/TCA/Overrides/pages.php`.

Inherit Configuration
--------------------
A custom page type usually shares the same fields as a standard page. By copying
the configuration from ``doktype 1``, you ensure that all default tabs and
fields are present. This inheritance must happen first.

Define Record Restrictions
--------------------------
The ``allowedRecordTypes`` key defines which database tables are allowed
on this page type. Setting this to ``['*']`` allows all tables, while
specifying tables like ``['tt_content']`` restricts it.

Assign Icon Identifier
----------------------
The icon for the page tree and properties is assigned via an **icon identifier** in the ``typeicon_classes`` array. This identifier must be registered later
in the Icon API.

..  literalinclude:: _pages.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/pages.php

2. Register the Icon via Icon API
=================================

The identifier used in the TCA (``tx-examples-archive-page``) must be
registered in :file:`Configuration/Icons.php` to link it to an SVG file.

..  literalinclude:: _Icons.php
    :language: php
    :caption: EXT:my_extension/Configuration/Icons.php

You can also provide icons for special states by registering additional
identifiers with specific suffixes:

* **Page is hidden in navigation:** ``tx-examples-archive-page-hideinmenu``
* **Page is a root page:** ``tx-examples-archive-page-root``
* **Page contains content from another page:** ``tx-examples-archive-page-contentFromPid``

3. Enable Drag & Drop in Page Wizard
====================================

To allow editors to create the new page type via the "New Page" wizard (the
drag-and-drop overlay), you must add it to the ``doktypes`` list via
User TSconfig.

..  literalinclude:: _user.tsconfig
    :language: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

4. Advanced: Dynamic Configuration
==================================

Instead of a static file, you can use the
:ref:`BeforeLoadedUserTsConfigEvent <t3coreapi:beforeloadedusertsconfigevent>`
to inject the TSconfig dynamically via a PSR-14 listener, allowing for
context-aware availability of page types.

Further Information
-------------------

*   :ref:`PSR-14 Events in TYPO3 <t3coreapi:EventDispatcher>`
*   :ref:`Icon API <icon>`
*   :ref:`TSconfig Reference <t3tsref:usertsconfig>`
