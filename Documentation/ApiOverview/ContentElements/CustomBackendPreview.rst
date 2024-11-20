..  include:: /Includes.rst.txt

..  _ConfigureCE-Preview:

====================================================
Configure custom backend preview for content element
====================================================

To allow editors a smoother experience, all custom content elements and plugins
should be configured with a corresponding backend preview that shows an
approximation of the element's appearance in the TYPO3 page module. The
following sections describe how to achieve that.

A preview renderer is used to facilitate (record) previews in TYPO3. This
class is responsible for generating the preview and the wrapping.

The default preview renderer is :php:`\TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer`
and handles the Core's built-in content types (field :sql:`CType` in table :sql:`tt_content`).

Extend the default preview renderer
===================================

There are two ways to provide previews for your custom content types:
via page :ref:`TSconfig <ConfigureCE-Preview-PageTSconfig>` or :ref:`event listener <ConfigureCE-Preview-EventListener>`.

..  _ConfigureCE-Preview-PageTSconfig:

Page TSconfig
-------------

This is the "integrator" way, no PHP coding is required. Just some page TSconfig
and a Fluid template.

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

    mod.web_layout {
      tt_content {
        preview {
          # Your CType
          example_ctype = EXT:my_extension/Resources/Private/Templates/Preview/ExampleCType.html
        }
      }
    }

For more details see the :ref:`TSconfig Reference <t3tsref:pageweblayoutpreview>`.

..  _ConfigureCE-Preview-EventListener:

Event listener
--------------

This requires at least some PHP coding, but allows more flexibility in
accessing and processing the content elements properties.

..  versionadded:: 12.0
    Since version 12.0 this technique replaces the former hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']`

The event :php:`PageContentPreviewRenderingEvent` is being dispatched by the
:php:`StandardContentPreviewRenderer`. You can listen to it with your own
event listener.

Have a look at this :ref:`showcase implementation <PageContentPreviewRenderingEvent>`.

For general information see the chapter on :ref:`implementing an event listener <EventDispatcherImplementation>`.

Writing a preview renderer
==========================

A custom preview renderer must implement the interface
:php:`\TYPO3\CMS\Backend\Preview\PreviewRendererInterface` which contains
the following API methods:

..  include:: /CodeSnippets/Manual/Backend/PreviewRendererInterface.rst.txt

Implementing these methods allows you to control the exact composition of the
preview.

This means assuming your preview renderer returns :html:`<h4>Header</h4>`
from the header render method and :html:`<p>Body</p>` from the preview content
rendering method and your wrapping method does
:php:`return '<div>' . $previewHeader . $previewContent . '</div>';` then the
entire output becomes :html:`<div><h4>Header</h4><p>Body</p></div>` when
combined.

Should you wish to reuse parts of the default preview rendering and only change,
for example, the method that renders the preview body content, you can extend
:php:`\TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer` in your custom
preview renderer class - and selectively override the methods from the API
displayed above.


Configuring the implementation
==============================

Individual preview renderers can be defined by using one of the following
approaches:

..  rst-class:: bignums

#.  Any record

    ..  code-block:: php

        $GLOBALS['TCA'][$table]['ctrl']['previewRenderer']
            = MyVendor\MyExtension\Preview\MyPreviewRenderer::class;

    This specifies the preview renderer to be used for any record in :php:`$table`.

#.  Table has a type field/attribute

    ..  code-block:: php

        $GLOBALS['TCA'][$table]['types'][$type]['previewRenderer']
            = MyVendor\MyExtension\Preview\MyPreviewRenderer::class;

    This specifies the preview renderer only for records of type :php:`$type` as
    determined by the :ref:`type field <t3tca:types>` of your table.

#.  Table and field have a :php:`subtype_value_field` TCA setting

    If your table and field have a
    :ref:`subtype_value_field <t3tca:types-properties-subtype-value-field>` TCA
    setting (like :php:`tt_content.list_type` for example) and you want to
    register a preview renderer that applies only when that value is selected
    (assume, when a certain plugin type is selected and you can't match it with
    the "type" of the record alone):

    ..  code-block:: php

        $GLOBALS['TCA'][$table]['types'][$type]['previewRenderer'][$subType]
            = MyVendor\MyExtension\Preview\MyPreviewRenderer::class;

    Where :php:`$type` is, for example, :php:`list` (indicating a plugin) and
    :php:`$subType` is the value of the :php:`list_type` field when the type of
    plugin you want to target is selected as plugin type.

..  note::
    The :ref:`recommended location <extension-configuration-tca>` is in the
    :php:`ctrl` array in your extension's :file:`Configuration/TCA/$table.php`
    or :file:`Configuration/TCA/Overrides/$table.php` file. The former is used
    when your extension is the one that creates the table, the latter is used
    when you need to override TCA properties of tables added by the Core or
    other extensions.

..  note::
    The content elements :php:`text`, :php:`textpic`, :php:`textmedia` and
    :php:`image` have their own :php:`PreviewRenderer`. Therefore it's not
    sufficient to overwrite the :php:`StandardContentPreviewRenderer` but
    you need to use the second approach from above for every single of
    these content elements.
