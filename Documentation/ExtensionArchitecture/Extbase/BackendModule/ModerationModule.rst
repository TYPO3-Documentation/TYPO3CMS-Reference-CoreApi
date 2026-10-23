:navigation-title: With a page tree

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-backend-module-page-tree:

===================================================
Building an Extbase backend module with a page tree
===================================================

Suppose visitors comment on conferences, and moderators keep an eye on the
comments. If the comments of each site are stored in a folder of that site,
and a moderator usually looks after one site, a module with a page tree is a
good fit: the moderator selects the site or the folder, and the module lists
the comments stored there.

Such a module is the counterpart of the :ref:`conferences module
<extbase-backend-module-no-page-tree>`. It uses the same framework, but the
situation is the opposite one. Where a module without a page tree has to
configure everything, the selected page can supply most of it:

*   The **storagePid** can follow the moderator's choice in the page tree.
*   The **site** of the selected page is known, and with it the languages the
    moderator could choose from.
*   TYPO3 checks that the moderator may see the selected page before the action
    runs.

This page shows how such a comment moderation module can be built:
registration, configuration that keeps the page tree in charge, a list that
includes hidden comments, a language selector, hiding comments with Core's own
visibility toggle, and answering them in an Extbase action. Take the parts
your module needs.

..  contents:: Table of contents
    :local:


..  _extbase-backend-module-page-tree-registration:

Registering an Extbase backend module with a page tree
======================================================

The simplest way to get the page tree is to register the module below the
:ref:`toplevel module <backend-modules-toplevel-module>` `content`, which
shows it. A module below `content` inherits the tree, so the registration
needs no key for it:

..  literalinclude:: _snippets/_ModulesWithPageTree.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

A module below another main module can add the page tree with
:confval:`navigationComponent <backend-module-navigationComponent>` set to
:php:`'@typo3/backend/tree/page-tree-element'`. Core's link validator is
registered this way.

The example registers three actions: `list` shows the comments, `answer`
displays the answer form and `createAnswer` stores the answer. Hiding a comment
does not need an action of its own when the module uses Core's visibility
toggle, see :ref:`Hiding records from an
Extbase backend module with Core's visibility toggle
<extbase-backend-module-page-tree-hide>`.


..  _extbase-backend-module-page-tree-page-context:

What the selected page supplies to an Extbase backend module
============================================================

When the moderator selects a page, the module is called with the page uid in
the `id` request parameter. Before the controller runs, the backend checks
that the moderator may see that page. Without access the module is not
called at all.

From the selected page, the module receives:

*   **The storagePid**: without a configured storagePid, Extbase searches the
    selected page, see :ref:`The storagePid resolution chain in a backend
    module <extbase-persistence-storagepid-backend>`.
*   **The site**: the `site` request attribute holds the site of the selected
    page.
*   **The TypoScript of the page**: a module with page context reads the
    TypoScript of the selected page, see :ref:`Which TypoScript an Extbase
    backend module sees <extbase-backend-module-basics-typoscript>`.

A controller can read the page uid once, in :php:`initializeAction()`, and
use it in every action:

..  literalinclude:: _snippets/_CommentModerationController.php
    :caption: EXT:my_extension/Classes/Controller/CommentModerationController.php
    :visible-lines: 26-50

There is no need to pass the page on. Links, forms and redirects that
Extbase builds in a backend module keep the `id` of the current request, so
the moderator stays on the selected page while working in the module. Only a
module that passes its own values in `id` loses that, see :ref:`The id
parameter in an Extbase backend module <extbase-backend-module-basics-id>`.


..  _extbase-backend-module-page-tree-storage-pid:

Extension-wide TypoScript overrides the selected page
=====================================================

The selected page is only the fallback. A storagePid in the module TypoScript
wins on every request, whichever page the moderator selected. Selecting a page
does not store anything, it only sends the `id`.

This matters as soon as an extension has more than one module. Suppose the
:ref:`conferences module <extbase-backend-module-no-page-tree-configuration>`
sets its storagePid in :typoscript:`module.tx_myextension`, the scope shared by
every module of the extension. A moderation module would inherit that
storagePid and list the comments of folder `42`, wherever the moderator
clicks. One way out is to remove the value on the key of the moderation
module:

..  literalinclude:: _snippets/_ext_localconf_moderation_typoscript.php
    :caption: EXT:my_extension/ext_localconf.php
    :emphasize-lines: 14-16

:typoscript:`__UNSET` is not TypoScript syntax. It is a value that removes a
key when the configuration of the module is merged over the shared scope. The
TypoScript operator :typoscript:`>` does not work here: the key it would
remove does not exist below the module key, and the shared value is merged in
afterwards regardless. Applied to :typoscript:`module.tx_myextension`, it
would remove the storagePid of the conferences module as well.

An inherited :typoscript:`recursive = 1` stays and then starts at the
selected page. That can suit moderation: a moderator who selects the site root
sees the comments in the folders directly below it, see :ref:`Searching
subpages of the storagePid <extbase-persistence-storagepid-recursive>`.

The other way round works too, and is easier to follow when only one module
needs a fixed storage folder: leave the shared scope empty and set the
storagePid only on the module that needs it, in
:typoscript:`module.tx_myextension_my_extension_conferences`.


..  _extbase-backend-module-page-tree-no-page:

When no page is selected in the page tree
=========================================

A moderator who opens the module for the first time has not selected a page
yet. Extbase would then search page `0`, which usually holds no comments.
Instead of an empty list, the module could display a hint as a
:ref:`flash message <flash-messages-api>`:

..  literalinclude:: _snippets/_CommentModerationController.php
    :caption: EXT:my_extension/Classes/Controller/CommentModerationController.php
    :visible-lines: 52-62


..  _extbase-backend-module-page-tree-list:

Listing hidden records in an Extbase backend module
===================================================

TYPO3 treats records differently depending on where they are shown. The
frontend respects all restrictions and only shows records that are valid for
the visitor: not hidden, within their start and end time, and visible to the
visitor's user groups. The backend is where records are managed, so Core's
backend modules show everything except deleted records.

Extbase follows this. In a backend module, its queries ignore the enable
fields by default: they return hidden records, and records outside their
start and end time, as the other backend modules do.

..  versionchanged:: 14.3.6

    Extbase queries in the backend ignore the enable fields by default.
    Before, they applied them and returned no hidden records.

A moderation list needs exactly that. Otherwise a comment would disappear
from the list the moment the moderator hides it, and could not be shown again
from the module. A repository method can still state it explicitly, and order
the comments newest first, for example:

..  literalinclude:: _snippets/_CommentRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/CommentRepository.php
    :visible-lines: 13-37

In a backend module, :php:`setIgnoreEnableFields(true)` repeats the default.
Setting it anyway keeps the list independent of where the method is called:
in a command or a middleware, Extbase applies the enable fields, and on a
TYPO3 version before 14.3.6 it does so in the backend too. The query
settings are described in :ref:`Query settings
<extbase-persistence-queries-querysettings>`.
Ordering by :sql:`crdate` works without a :php:`crdate` property in the
model: Extbase uses the column of the same name.

The list action can then hand the result to the template:

..  literalinclude:: _snippets/_CommentModerationController.php
    :caption: EXT:my_extension/Classes/Controller/CommentModerationController.php
    :visible-lines: 82-89


..  _extbase-backend-module-page-tree-language:

Choosing the language in an Extbase backend module with a page tree
===================================================================

The site of the selected page knows its languages. A module can offer them
in the language selector of the document header, together with
"All languages", and list the comments of the chosen language:

..  literalinclude:: _snippets/_CommentModerationController.php
    :caption: EXT:my_extension/Classes/Controller/CommentModerationController.php
    :visible-lines: 52,64-84,95-116

What is Extbase-specific here:

*   The chosen language can arrive as an argument of the list action, here
    `language`.
    Extbase passes the arguments of a backend module without a plugin
    namespace, so the parameter is called `language` in the URL as well.
*   :php:`uriFor()` can build the links of the selector. Like every Extbase link
    in a module, it keeps the selected page and adds the route token the
    module requires.
*   Keeping the choice in the module data lets the moderator find the same
    language after selecting another page. The module data is described in
    :ref:`Keeping the filters of an Extbase backend module in ModuleData
    <extbase-backend-module-no-page-tree-module-data>`.
*   :php-short:`\TYPO3\CMS\Core\Context\LanguageAspectFactory::createFromSiteLanguage()`
    creates the language aspect the frontend would use for the chosen
    language, with its fallback configuration, see :ref:`Page-bound modules
    (with page tree) <extbase-localisation-no-frontend-backend-with-page>`.

The second argument of :php:`getAvailableLanguages()` adds "All languages"
with the id `-1`, provided the moderator has access to it. For this choice,
the example passes no language aspect to the repository, which drops the
language restriction with :php:`setRespectSysLanguage(false)`. Each comment is
then listed once, in its own language.

The dropdown itself is not Extbase-specific. It is described in
:ref:`Adding module actions and a language selector to the module header
<docheadercomponent-language-selector>`.


..  _extbase-backend-module-page-tree-hide:

Hiding records from an Extbase backend module with Core's visibility toggle
===========================================================================

The record list of the :guilabel:`Content > Records` module hides and shows
records with a button in each row. A module does not have to build this
itself. It can reuse that button: render the same markup, load the same
JavaScript, and let Core do the rest. This is the recommended way, because
Core then takes care of permissions and of writing the record.

..  literalinclude:: _snippets/_CommentList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/CommentModeration/List.fluid.html
    :visible-lines: 1-41,49-56

The JavaScript module :js:`@typo3/backend/recordlist.js` reacts to every
button with :html:`data-datahandler-action="visibility"`. It expects this
markup:

*   The row is a :html:`<tr>` with :html:`data-uid` and :html:`data-table`.
    The script takes the record from the row, not from the button.
*   :html:`data-datahandler-status` is `visible` or `hidden`, the state the
    record has when the list is rendered.
*   The button contains an icon, rendered with :html:`<core:icon>`. The script
    replaces it with a spinner while the request runs, and with the icon for
    the new state afterwards.
*   The row contains a record icon in a cell with the class `col-icon`,
    rendered with :html:`<core:iconForRecord>`. The script replaces it with
    the icon for the new state, and fails without it.
*   :html:`data-datahandler-visible-label` and
    :html:`data-datahandler-hidden-label` become the title of the button in
    the respective state.

A click sends the table, the uid and the requested state to the backend.
Core checks that the table has a field for hiding records, that the moderator
may change records of the table, and that the moderator may see the page the
record is stored on. It then writes through
:ref:`DataHandler <datahandler-basics>`, with history, hooks and cache
clearing. The row stays in the list, only its state changes.

The module writes nothing itself. All the table needs is a hidden field,
configured in :ref:`enablecolumns <t3tca:ctrl-reference-enablecolumns>`.


..  _extbase-backend-module-page-tree-answer:

Answering a comment in an Extbase backend module action
=======================================================

An answer is not an edit of the comment. It can be modelled as a new comment
that refers to the answered one, written by the moderator. This is one of the
cases in which an Extbase module may write records itself rather than handing
them to FormEngine, see
:ref:`When an Extbase module writes records itself
<extbase-backend-module-editing-own-actions>`.

For this, the example uses a :php:`Comment` model with only the fields the
answer form and the list need:

..  literalinclude:: _snippets/_Comment.php
    :caption: EXT:my_extension/Classes/Domain/Model/Comment.php
    :visible-lines: 10-21

The list can link every comment to the answer form:

..  literalinclude:: _snippets/_CommentList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/CommentModeration/List.fluid.html
    :visible-lines: 42-48

Property mapping loads the comment of the action argument with the same
default, so hidden comments can be answered as well. A module that should
not allow this could render the link only for visible comments.

The two actions can follow the usual pattern of a form in Extbase, see
:ref:`Validation <extbase-validation>`. Here, :php:`answerAction()` shows the
form and :php:`createAnswerAction()` stores the answer:

..  literalinclude:: _snippets/_CommentModerationController.php
    :caption: EXT:my_extension/Classes/Controller/CommentModerationController.php
    :visible-lines: 118-165

A module that writes records itself takes over what Core would do
otherwise. The example covers these points:

*   **Checking the permissions.** :php:`mayAnswer()` requires that the
    moderator may change records of the comment table and edit the content of
    the page the comment is stored on.
*   **Setting the page of the answer.** Without :php:`setPid()`, Extbase stores
    a new record on the first storagePid. With :typoscript:`recursive`, that
    is the selected page, which can be the parent of the comment's folder.
*   **Protecting against cross-site requests.** Every backend URL carries
    a route token, and Extbase builds its form URLs through the backend router,
    so a forged request has no valid token. It is recommended to also accept
    the answer only as a `POST` request. The example does this in
    :php:`initializeCreateAnswerAction()` with
    :php:`\TYPO3\CMS\Core\Http\AllowedMethodsTrait`, as Core's backend user
    module does. See :ref:`Security considerations
    <backend-modules-security>`.

What such an action does not have is what DataHandler adds: no history entry
and no DataHandler hooks for the answer. In this example the answer is stored
in the default language, whichever language the answered comment has.

The answer form can be an ordinary Extbase form:

..  literalinclude:: _snippets/_CommentAnswer.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/CommentModeration/Answer.fluid.html

The answer could go through FormEngine instead: a :html:`<be:link.newRecord>`
link with :html:`defaultValues` that prefill the reference to the comment and
the page, see :ref:`Creating records from an Extbase backend module
<extbase-backend-module-editing-new>`. That way the module gets history and
hooks, and the moderator gets the full record form instead of a single field.
Which one fits depends on how much of the record the moderator should see.

Messages from :php:`addFlashMessage()` of the controller go to the queue of
the Extbase module and are rendered by :html:`<f:flashMessages />` in the list
template, see :ref:`Flash messages <extbase-controller-action-flashmessages>`.


..  _extbase-backend-module-page-tree-next:

Next steps for the module with a page tree
==========================================

The two example modules of this chapter show both situations an Extbase
backend module can be in: alone with its configuration, or supplied by the
page the editor selected. The overview of the chapter is in
:ref:`Building backend modules with Extbase <extbase-backend-module>`.

Commands and middlewares have no page and no backend module around them.
How Extbase behaves there is described in :ref:`Extbase without a frontend
context <extbase-no-frontend>`.
