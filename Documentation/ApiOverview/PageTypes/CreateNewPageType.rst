..  include:: /Includes.rst.txt
..  index:: Page types; Custom
..  _page-types-example:

====================
Create new page type
====================

..  deprecated:: 14.3
    TCA option allowedRecordTypes has also been deprecated:
    `Deprecation: #108557 - TCA option allowedRecordTypes for Page Types <https://docs.typo3.org/permalink/changelog:deprecation-108557-1768610680>`_.

This example demonstrates how to add a new page type (doktype) called "Archive".
Starting with TYPO3 v14, registration is streamlined by centralizing the
configuration in the :abbr:`TCA (Table Configuration Array)`.

..  contents:: Table of contents

..  note::
    The `doktype` value must be defined as a string, for example `'116'`.
    TYPO3 v14 uses strict comparisons in the Page Wizard TypeScript components.
    Using an integer may cause UI issues such as failed validation or form resets.

..  _page-types-example-configure-tca:

1. Configure the page type in TCA
=================================

To define the behavior and appearance of the new page type, create or edit
:file:`Configuration/TCA/Overrides/pages.php`.

..  _page-types-example-inherit-configuration:

Inherit configuration
---------------------

A custom page type usually shares the same fields as a standard page.
Copying the configuration from `doktype 1` ensures that all default tabs and
fields are available. This inheritance must happen first.

..  _page-types-example-record-restrictions:

Define record restrictions
--------------------------

The `allowedRecordTypes` key defines which database tables are allowed
on this page type. Setting this to `['*']` allows all tables, while
specifying tables such as `['tt_content']` restricts it to those tables.

..  _page-types-example-icon-identifier:

Assign icon identifier
----------------------

The icon for the page tree and page properties is assigned via an icon
identifier in the `typeicon_classes` array. This identifier must be registered
later in the Icon API.

..  literalinclude:: _pages.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/pages.php

..  _page-types-example-register-icon:

2. Register the icon via Icon API
=================================

The identifier used in the TCA (`tx-examples-archive-page`) must be
registered in :file:`Configuration/Icons.php` to link it to an SVG file.

..  literalinclude:: _Icons.php
    :language: php
    :caption: EXT:my_extension/Configuration/Icons.php

You can also provide icons for special states by registering additional
identifiers with specific suffixes:

*   **Page is hidden in navigation:** `tx-examples-archive-page-hideinmenu`
*   **Page is a root page:** `tx-examples-archive-page-root`
*   **Page contains content from another page:** `tx-examples-archive-page-contentFromPid`

..  _page-types-example-page-wizard:

3. Enable drag and drop in the page wizard
==========================================

To allow editors to create the new page type via the "New Page" wizard, add it
to the `doktypes` list via user TSconfig.

..  literalinclude:: _user.tsconfig
    :language: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

..  _page-types-example-dynamic-configuration:

4. Advanced: Dynamic configuration
==================================

Instead of using a static TSconfig file, you can use the
:ref:`BeforeLoadedUserTsConfigEvent <t3coreapi:beforeloadedusertsconfigevent>`
to add TSconfig dynamically through a PSR-14 event listener. This allows
context-aware availability of page types.

..  _page-types-example-further-information:

Further information
===================

*   :ref:`PSR-14 Events in TYPO3 <t3coreapi:EventDispatcher>`
*   :ref:`Icon API <icon>`
*   :ref:`TSconfig Reference <t3tsref:usertsconfig>`
