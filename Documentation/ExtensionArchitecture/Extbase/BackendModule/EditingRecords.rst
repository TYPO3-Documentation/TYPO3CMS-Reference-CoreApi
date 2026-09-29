:navigation-title: Editing records

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-backend-module-editing:

==============================================
Editing records from an Extbase backend module
==============================================

A module that lists records sooner or later has to change them. The obvious
Extbase answer is a set of actions: `new` and `create`, `edit` and `update`,
`delete`, each with a form and a template. Most backend modules, including
the ones in Core, do not do that. They link to FormEngine, the form the
backend uses for every record, and let it do the editing.

FormEngine brings everything a hand-written form would have to rebuild: the
fields as configured in :abbr:`TCA (Table Configuration Array)`, the editor's
permissions, workspaces, translations, the record history and undo. It writes
through the DataHandler, so hooks and events of other extensions run as they
do everywhere else in the backend. The module only has to link to it, and
the links are Fluid ViewHelpers that need no controller code.

The examples on this page are taken from the list template of the
:ref:`conferences module <extbase-backend-module-no-page-tree>`.

..  contents:: Table of contents
    :local:


..  _extbase-backend-module-editing-record:

Opening a record in FormEngine from an Extbase module
=====================================================

The :ref:`be:link.editRecord <t3viewhelper:typo3-backend-link-editrecord>`
ViewHelper links to the edit form of one record:

..  literalinclude:: _snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 45-52

When the editor saves and closes the form, the backend returns to the page
the link was clicked on. The ViewHelper takes that address from the current
request, so the list comes back with its filters and its page number. Set
`returnUrl` only to send the editor somewhere else.


..  _extbase-backend-module-editing-fields:

Editing selected fields of a record
===================================

The `fields` argument limits the form to the listed fields. A module that
offers a quick way to rename a conference does not need to show the whole
record:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html (excerpt)

    <be:link.editRecord
      table="tx_myextension_domain_model_conference"
      uid="{conference.uid}"
      fields="title,description"
    >
      Edit title and description
    </be:link.editRecord>

The editor can still open the complete record from the form.


..  _extbase-backend-module-editing-contextual:

Editing a record without leaving the list
=========================================

..  versionadded:: 14.3

    The `contextual` argument of `be:link.editRecord` was added. See
    `Important: #110307 - New editRecord ViewHelper argument for contextual
    editing <https://docs.typo3.org/permalink/changelog:important-110307-1753690555>`_.

With `contextual="true"` the form opens in a panel next to the list instead
of replacing it. Together with `fields` this makes a quick edit of a single
value:

..  literalinclude:: _snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 35-42

The ViewHelper loads the JavaScript the panel needs. The module adds nothing.


..  _extbase-backend-module-editing-new:

Creating records from an Extbase backend module
===============================================

The :ref:`be:link.newRecord <t3viewhelper:typo3-backend-link-newrecord>`
ViewHelper opens an empty form for a new record. `pid` names the page the
record is created on:

..  literalinclude:: _snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 27-29

In a module with a page tree the selected page is the natural choice. A module
without one has no such page, and a link without `pid` creates the record on
page `0`, the root of the page tree, where most tables do not allow records.
The conferences module therefore reads the page from the extension
configuration:

..  literalinclude:: _snippets/_ConferenceListModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :visible-lines: 63-68,72-76

The option is declared in the extension's :ref:`ext_conf_template.txt
<extension-options>`, and administrators set it in :guilabel:`System >
Settings`:

..  literalinclude:: _snippets/_ext_conf_template.txt
    :caption: EXT:my_extension/ext_conf_template.txt
    :language: typoscript

:php-short:`\TYPO3\CMS\Core\Configuration\ExtensionConfiguration` is public
API and needs neither a request nor a page. The storagePid that Extbase has
resolved for the module is part of its framework configuration, which only
the internal Extbase configuration manager returns. Set `newRecordPid` to the
first page of the storagePid from :ref:`Configuring the storagePid of a module
without a page tree <extbase-backend-module-no-page-tree-configuration>`, so
new conferences are created where the list finds them.

To prefill fields of the new record, pass `defaultValues`, for example
:html:`defaultValues="{tx_myextension_domain_model_conference: {published: 0}}"`.


..  _extbase-backend-module-editing-delete:

Deleting records from an Extbase backend module
===============================================

A delete button next to the edit link lets the editor remove a record
straight from the list. Core's redirects module builds it this way, and it
needs no controller action either: the button links to the backend's
DataHandler gateway, the `tce_db` route, with a delete command for the
record:

..  literalinclude:: _snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 9,45-64
    :emphasize-lines: 53-63

The parts of the button:

*   :ref:`be:moduleLink <t3viewhelper:typo3-backend-modulelink>` builds the
    address. The `query` argument carries the DataHandler command
    `cmd[<table>][<uid>][delete]=1`, and `currentUrlParameterName: 'redirect'`
    adds the current address, so the backend returns to the list, with its
    filters, once the record is deleted.
*   The class `t3js-modal-trigger` makes the backend ask before it follows
    the link. The `data-*` attributes set the title, text, severity and button
    labels of the confirmation dialog. The template loads the dialog with
    :html:`<f:asset.module identifier="@typo3/backend/modal.js" />`.

DataHandler deletes the record and checks that the editor may do so. If the
table has a :ref:`delete <t3tca:ctrl-reference-delete>` field, as Extbase
tables usually do, the record is only marked as deleted and can be restored
from the recycler or the record history.

..  note::

    The button is shown to every editor who can open the module. DataHandler
    refuses the deletion when the editor lacks the permission, but the button
    itself does not know. Hide it in the template for editors who may not
    delete, for example based on a value the controller assigns.

The edit form offers deletion as well: a saved record opened in FormEngine
has a :guilabel:`Delete` button in its document header. FormEngine hides that
button when the editor may not delete the record, or when User TSconfig
switches it off with :ref:`options.disableDelete
<t3tsref:confval-useroptions-disabledelete>`. The button in the list is not
affected by that option.


..  _extbase-backend-module-editing-php:

Edit links built in PHP
=======================

Links in the document header, for example a :guilabel:`New conference`
button, are built in the controller rather than in the template. The backend
:php:`\TYPO3\CMS\Backend\Routing\UriBuilder` creates the same addresses from
the `record_edit` route, and Core's backend user module builds its buttons
this way. How to build these links is described in :ref:`Use the backend
UriBuilder to link to "Edit Records" <edit-links>`, and the buttons themselves
in :ref:`Button components <button-components>`. Neither is specific to
Extbase.

For links inside a list, the ViewHelpers are the simpler choice: they need no
controller code and fill in the return address themselves.


..  _extbase-backend-module-editing-own-actions:

When an Extbase module writes records itself
============================================

Handing records to FormEngine is the usual choice, not the only one. Own
actions are justified when the form is not an edit form of one record, for
example:

*   An input that creates a record from another one, such as the answer to a
    comment, which becomes a comment of its own.
*   A step that changes several records at once, or records of several
    tables.
*   A form that must look and behave differently from FormEngine, for example
    a guided sequence of steps.

Such an action is an ordinary Extbase action with a form, validation and a
repository call, as in a frontend plugin. It takes over what FormEngine
would have done: checking that the editor may change the record, and
protecting the form against cross-site requests, see :ref:`Security
considerations <backend-modules-security>`. The :ref:`module with a page tree
<extbase-backend-module-page-tree>` answers comments this way, next to hiding
them through Core's own mechanism.


..  _extbase-backend-module-editing-next:

Next steps after editing records
================================

The conferences module is now complete: it lists, filters and pages through
the conferences, and hands every change to FormEngine. Its counterpart,
:ref:`Building an Extbase backend module with a page tree
<extbase-backend-module-page-tree>`, takes its storage folder, site and
language from the page the editor selects, and writes one kind of record
itself.
