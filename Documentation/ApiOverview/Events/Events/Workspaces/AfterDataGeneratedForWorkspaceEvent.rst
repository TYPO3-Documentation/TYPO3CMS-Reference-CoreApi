..  include:: /Includes.rst.txt
..  index:: Events; AfterDataGeneratedForWorkspaceEvent
..  _AfterDataGeneratedForWorkspaceEvent:


=====================================
`AfterDataGeneratedForWorkspaceEvent`
=====================================

The PSR-14 event
:php:`\TYPO3\CMS\Workspaces\Event\AfterDataGeneratedForWorkspaceEvent`
is used in the :guilabel:`Content > Workspaces` module to find all data of versions
of a workspace.

The event holds one entry per version record, indexed by table name and uid,
for example `tt_content:42`. A listener can add columns to the record table
of the module and change the action buttons of a record.

..  _after-data-generated-for-workspace-event-example:
..  _after-data-generated-for-workspace-event-columns:

Add a column to the workspaces module with `additional`
=======================================================

..  versionchanged:: 14.3
    :changelog: important-110591-1788297183

    Before, the module discarded the `additional` section and rendered a
    fixed set of columns.

Add an `additional` section to a record to add a column. A column is
displayed as soon as one record of the workspace declares it, also when that
record is on another page of the table.

..  literalinclude:: _AfterDataGeneratedForWorkspaceEvent/_AddDeadlineColumnListener.php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/AddDeadlineColumnListener.php

All keys of a column are optional:

`label`
    Header of the column. Falls back to the column identifier.

`value`
    Content of the cell, rendered as plain text.

`icon`
    Identifier of an icon rendered in front of the value.

`title`
    Title attribute of the cell.

`url`
    Links the content of the cell to this URL.

..  _after-data-generated-for-workspace-event-actions:

Change the action buttons of a record with `actions`
====================================================

..  versionchanged:: 14.3
    :changelog: important-94407-1788534856

    Before, the module rendered a fixed set of action buttons, and a listener
    could not change them.

Add an `actions` section to a record to change its action buttons. The module
merges the section into the actions it determines itself, so give only the
keys that differ.

..  literalinclude:: _AfterDataGeneratedForWorkspaceEvent/_ModifyRecordActionsListener.php
    :caption: EXT:my_extension/Classes/Workspaces/EventListener/ModifyRecordActionsListener.php

The module renders the actions `preview`, `qrcode`, `open`, `version`,
`expand`, `changes`, `publish`, and `remove` itself. An action takes these
keys:

`enabled`
    `false` renders the button greyed out.

`visible`
    `false` removes the button.

`icon`
    Identifier of the icon of the button.

`title`
    Title attribute of the button.

`url`
    Renders the action as a link to this URL.

`group`
    Identifier of the button group. Actions that the module does not know
    are in the group `custom`.

An action of your own without a `url` renders as a button with a
`data-action` attribute that holds the action identifier. The module renders
the record table again on every update, so attach the JavaScript of your
extension with event delegation.

The permissions of a record, such as `allowedAction_publish`, still set the
default state of the actions of the module.

..  _after-data-generated-for-workspace-event-api:

API
===

..  include:: /CodeSnippets/Events/Workspaces/AfterDataGeneratedForWorkspaceEvent.rst.txt
