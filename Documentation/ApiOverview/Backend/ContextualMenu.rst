:navigation-title: Context menus

.. include:: /Includes.rst.txt


.. _csm:
.. _context-menu:

=======================
Context-sensitive menus
=======================

Contextual menus exist in many places in the TYPO3 backend. Just try your
luck clicking on any **icon** that you see. Chances are good that a contextual
menu will appear, offering useful functions to execute.

.. include:: /Images/AutomaticScreenshots/Examples/ContextualMenuExtended/ContextMenuTtContent.rst.txt

.. _csm-implementation:

Context menu rendering flow
===========================

Markup
------

..  versionchanged:: 13.0
    The configuration of the context menu was streamlined. Replace

    *   :html:`class="t3js-contextmenutrigger"` with :html:`data-contextmenu-trigger="click"`
    *   :html:`data-table="pages"` with :html:`data-contextmenu-table="pages"`
    *   :html:`data-uid="10"` with :html:`data-contextmenu-uid="10"`
    *   :html:`data-context="tree"` with :html:`data-contextmenu-context="tree"`

    to be compatible with TYPO3 v12+.

The context menu is shown after clicking on the HTML element which has the
:html:`data-contextmenu-trigger` attribute set together with
:html:`data-contextmenu-table`, :html:`data-contextmenu-uid` and optional
:html:`data-contextmenu-context` attributes.

The HTML attribute :html:`data-contextmenu-trigger` has the following options:

*   :html:`click`: Opens the context menu on the "click" and "contextmenu"
    events
*   :html:`contextmenu`: Opens the context menu only on the "contextmenu" event

The JavaScript click event handler is implemented in the
:ref:`ES6 module <backend-javascript-es6>` :js:`@typo3/backend/context-menu.js`. It takes the
data attributes mentioned above and executes an Ajax call to the
:php:`\TYPO3\CMS\Backend\Controller\ContextMenuController->getContextMenuAction()`.

ContextMenuController
---------------------

:php:`ContextMenuController` asks :php:`\TYPO3\CMS\Backend\ContextMenu\ContextMenu`
to generate an array of items. :php:`ContextMenu` builds a list of available
item providers by asking each whether it can provide items
(:php:`$provider->canHandle()`), and what priority it has
(:php:`$provider->getPriority()`).


Item providers registration
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Custom item providers must implement
:php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\ProviderInterface` and can
extend :php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\AbstractProvider`.

They are then automatically registered by adding the :yaml:`backend.contextmenu.itemprovider`
tag, if :yaml:`autoconfigure` is enabled in :file:`Services.yaml`. The class
:php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\ItemProvidersRegistry` then
automatically receives those services and registers them.

If :yaml:`autoconfigure` is
not enabled in your :file:`Configuration/Services.(yaml|php)` file,
manually configure your item providers with the
:yaml:`backend.contextmenu.itemprovider` tag.

There are two item providers which are always available:

-  :php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\PageProvider`
-  :php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\RecordProvider`

Gathering items
~~~~~~~~~~~~~~~

A list of providers is sorted by priority, and then each provider is asked to
add items. The generated array of items is passed from an item provider with
higher priority to a provider with lower priority.

After that, a compiled list of items is returned to the
:php:`ContextMenuController` which passes it back to the
:file:`ContextMenu.js` as JSON.


Menu rendering in JavaScript
----------------------------

Based on the JSON data :file:`context-menu.js` is rendering a context menu. If
one of the items is clicked, the according JavaScript :js:`callbackAction` is
executed on the :ref:`ES6 module <backend-javascript-es6>` :js:`@typo3/backend/context-menu-actions.js`
or other modules defined in the JSON as :js:`additionalAttributes['data-callback-module']`.

Example of the JSON response:

.. code-block:: javascript

    {
       "view":{
          "type":"item",
          "label":"Show",
          "icon":"<span class=\"t3js-icon icon icon-size-small icon-state-default icon-actions-document-view\" data-identifier=\"actions-document-view\">\n\t<span class=\"icon-markup\">\n<img src=\"\/typo3\/sysext\/core\/Resources\/Public\/Icons\/T3Icons\/actions\/actions-document-view.svg\" width=\"16\" height=\"16\" \/>\n\t<\/span>\n\t\n<\/span>",
          "additionalAttributes":{
             "data-preview-url":"http:\/\/typo37.local\/index.php?id=47"
          },
          "callbackAction":"viewRecord"
       },
       "edit":{
          "type":"item",
          "label":"Edit",
          "icon":"",
          "additionalAttributes":[
          ],
          "callbackAction":"editRecord"
       },
       "divider1":{
          "type":"divider",
          "label":"",
          "icon":"",
          "additionalAttributes":[

          ],
          "callbackAction":""
       },
       "more":{
          "type":"submenu",
          "label":"More options...",
          "icon":"",
          "additionalAttributes":[

          ],
          "callbackAction":"openSubmenu",
          "childItems":{
             "newWizard":{
                "type":"item",
                "label":"'Create New' wizard",
                "icon":"",
                "additionalAttributes":{
                },
                "callbackAction":"newContentWizard"
             }
          }
       }
    }


API usage in the Core
=====================

Several TYPO3 Core modules are already using this API for adding or modifying
items. See following places for a reference:

*   EXT:impexp module adds import and export options for pages, content elements
    and other records. See item provider
    :php:`\TYPO3\CMS\Impexp\ContextMenu\ItemProvider` and :ref:`ES6 module <backend-javascript-es6>`
    :js:`@typo3/impexp/context-menu-actions.js`.
*   EXT:filelist module provides several item providers for files, folders,
    file mounts, filestorage, and drag-drop context menu for the folder tree.
    See following item providers:
    :php:`\TYPO3\CMS\Filelist\ContextMenu\ItemProviders\FileDragProvider`,
    :php:`\TYPO3\CMS\Filelist\ContextMenu\ItemProviders\FileProvider`,
    :php:`\TYPO3\CMS\Filelist\ContextMenu\ItemProviders\FileStorageProvider`,
    :php:`\TYPO3\CMS\Filelist\ContextMenu\ItemProviders\FilemountsProvider`
    and the :ref:`ES6 module <backend-javascript-es6>` :js:`@typo3/filelist/context-menu-actions.js`

Adding context menu to elements in your backend module
======================================================

Enabling context menu in your own backend modules is quite straightforward.
The examples below are taken from the "beuser" system extension and
assume that the module is Extbase-based.

The first step is to include the needed JavaScript using the
:html:`includeJavaScriptModules` property
of the standard backend container Fluid view helper (or backend page
renderer view helper).

Doing so in your layout is sufficient (see
:file:`typo3/sysext/beuser/Resources/Private/Layouts/Default.html`).

..  literalinclude:: _ContextualMenu/_IncludeJS.html

The second step is to activate the context menu on the icons. This kind of markup
is required (taken from
:file:`typo3/sysext/beuser/Resources/Private/Templates/BackendUser/Index.html`):

..  code-block:: xml
    :emphasize-lines: 2

    <td>
        <a href="#"
            data-contextmenu-trigger="click"
            data-contextmenu-table="be_users"
            data-contextmenu-uid="{compareUser.uid}"
            title="id={compareUser.uid}"
        >
            <be:avatar backendUser="{compareUser.uid}" showIcon="TRUE" />
        </a>
    </td>

the relevant line being highlighted. The attribute :html:`data-contextmenu-trigger`
triggers a context menu functionality for the current element. The
:html:`data-contextmenu-table` attribute contains a table name of the record and
:html:`data-contextmenu-uid` the :php:`uid` of the record.

The attribute :html:`data-contextmenu-trigger` has the following options:

*   :html:`click`: Opens the context menu on the "click" and "contextmenu"
    events
*   :html:`contextmenu`: Opens the context menu only on the "contextmenu" event


One additional data attribute can be used :html:`data-contextmenu-context` with
values being, for example, :html:`tree` for context menu triggered from
the page tree. Context is used to hide menu items independently for page tree
independently from other places (disabled items can be configured in TSconfig).

.. note::

   In most cases the :html:`data-contextmenu-uid` attribute contains an integer value.
   However, in case of files and folders this attribute takes file/folder path
   as a value like :html:`data-contextmenu-uid="1:/some-folder/some-file.pdf"`


Disabling Context Menu Items from TSConfig
==========================================

Context menu items can be disabled in TSConfig by adding item name to the
:typoscript:`options.contextMenu` option corresponding to the table and context
you want to cover.

For example, disabling :typoscript:`edit` and :typoscript:`new` items for
table :typoscript:`pages` use:

.. code-block:: typoscript

   options.contextMenu.table.pages.disableItems = edit,new

If you want to disable the items just for certain context (for example tree)
add the :typoscript:`.tree` key after table name like that:

.. code-block:: typoscript

   options.contextMenu.table.pages.tree.disableItems = edit,new

If configuration for certain context is available, the default configuration
is not taken into account.

For more details see :ref:`TSConfig reference <t3tsref:useroptions-contextmenu-key-disableitems>`.

.. _csm-adding:

Tutorial: How to add a custom context menu item
===============================================

..  todo: Document the new ES6 way of creating a context menu
    https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/2298

Follow these steps to add a custom menu item for pages records. You will add a
"Hello world" item which will show an info after clicking.

.. include:: /Images/AutomaticScreenshots/Examples/ContextualMenuExtended/ContextMenuHelloWorld.rst.txt

Step 1: Implementation of the item provider class
-------------------------------------------------

Implement your own item provider class. Provider must implement
:php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\ProviderInterface` and
can extend :php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\AbstractProvider`
or any other provider from EXT:backend.

See comments in the following code snippet clarifying implementation details.

.. include:: /CodeSnippets/Tutorials/ContextMenu/HelloWorldItemProvider.rst.txt

Step 2: JavaScript actions
--------------------------

Provide a JavaScript file (ES6 module) which will be
called after clicking on the context menu item.

..  include:: /CodeSnippets/Tutorials/ContextMenu/ContextMenuActions.rst.txt

Register the JavaScript ES6 modules of your extension if not done yet:

..  include:: /CodeSnippets/Tutorials/ContextMenu/JavaScriptModules.rst.txt

Step 3: Registration
--------------------

If you have :yaml:`autoconfigure: true` set in your extension's :file:`Services.yaml` file all
classes implementing :php:`\TYPO3\CMS\Backend\ContextMenu\ItemProviders\ProviderInterface`
get registered as context menu items automatically:

..  code-block:: yaml
    :caption: EXT:examples/Configuration/Services.yaml
    :emphasize-lines: 4

    services:
      _defaults:
        autowire: true
        autoconfigure: true
        public: false

If :yaml:`autoconfigure` is disabled you can manually register a context menu item provider
by adding the tag :yaml:`backend.contextmenu.itemprovider`:

..  include:: /CodeSnippets/Tutorials/ContextMenu/ManualServicesYaml.rst.txt
