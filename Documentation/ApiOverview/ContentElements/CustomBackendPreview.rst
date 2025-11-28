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

..  _ContentPreviewRenderer:

Extend the default preview renderer
===================================

There are two ways to provide previews for your custom content types:
via page :ref:`TSconfig <ConfigureCE-Preview-PageTSconfig>` or :ref:`event listener <ConfigureCE-Preview-EventListener>`.

..  _ConfigureCE-Preview-PageTSconfig:

Preview rendering with a Fluid template and page TSconfig
---------------------------------------------------------

..  versionchanged:: 14.0
    A :php:`\TYPO3\CMS\Core\Domain\RecordInterface` is passed as variable
    `{record}` to the Fluid Template. The fields are not passed as direct
    variables anymore. `{pi_flexform_transformed}` has been replaced by
    `{record.pi_flexform}`. See also `Breaking: #92434 - Use Record API
    in Page Module Preview Rendering <https://docs.typo3.org/permalink/changelog:breaking-92434-1761644184>`_.


This is the "integrator" way, no PHP coding is required. Just some page TSconfig
and a Fluid template.

..  literalinclude:: _codesnippets/_preview.typoscript
    :caption: EXT:my_extension/Configuration/page.tsconfig

For more details see the :ref:`TSconfig Reference <t3tsref:pageweblayoutpreview>`.

In the Fluid template, the following variables are available:

*   The current record as object (:php-short:`\TYPO3\CMS\Core\Domain\Record`)
    in variable `{record}`

..  literalinclude:: _codesnippets/_Preview.html
    :caption: EXT:my_extension/Resources/Private/Templates/Preview/MyCType.html

..  rubric:: Migration

..  code-block:: diff

    -<h2>{header}</h2>
    +<h2>{record.header}</h2>
    -<p>{bodytext}</p>
    +<p>{record.bodytext}</p>
    -<small>{pi_flexform_transformed.settings.welcome_header}</small>
    +<small>{record.pi_flexform.sheets.s_messages.settings.welcome_header}</small>

..  _ConfigureCE-Preview-EventListener:

Event listener
--------------

This requires at least some PHP coding, but allows more flexibility in
accessing and processing the content elements properties.

The event :php:`PageContentPreviewRenderingEvent` is being dispatched by the
:php:`StandardContentPreviewRenderer`. You can listen to it with your own
event listener.

Have a look at this :ref:`showcase implementation <PageContentPreviewRenderingEvent>`.

For general information see the chapter on :ref:`implementing an event listener <EventDispatcherImplementation>`.

..  _ConfigureCE-Preview-preview-renderer:

Writing a preview renderer
==========================

..  versionchanged:: 14.0
    The `@internal` class
    :php-short:`\TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem` has been
    updated to work with Record objects.

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

..  deprecated:: 13.4
    Registration of subtypes has been deprecated. Registration of custom
    types should therefore always be done by using
    :confval:`record types <t3tca:ctrl-type>`.

    See also :ref:`t3tca:migration-subtype-previewrenderer`.

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
