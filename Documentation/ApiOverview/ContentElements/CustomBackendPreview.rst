.. include:: /Includes.rst.txt

.. _ConfigureCE-Preview:

====================================================
Configure Custom Backend Preview for Content Element
====================================================

To allow editors a smoother experience, all custom content elements and plugins should be configured with a corresponding backend
preview that shows an approximation of the element's appearance in the TYPO3 page module. The following sections describe how to
achieve that.

A :php:`PreviewRenderer` is used to facilitate (record) previews in TYPO3.

The feature consists of two concepts:

* :php:`PreviewRendererResolver` which is a global implementation to detect which :php:`PreviewRenderer` a given record needs.
* :php:`PreviewRenderer` which is the class responsible for generating the preview and the wrapping.


Writing a PreviewRenderer
-------------------------

A custom :php:`PreviewRenderer` must implement the interface :php:`\TYPO3\CMS\Backend\Preview\PreviewRendererInterface` which contains
the following API methods:

.. code-block:: php

    /**
     * Dedicated method for rendering preview header HTML for
     * the page module only. Receives $item which is an instance of
     * GridColumnItem which has a getter method to return the record.
     *
     * @param GridColumnItem
     * @return string
     */
    public function renderPageModulePreviewHeader(GridColumnItem $item);

    /**
     * Dedicated method for rendering preview body HTML for
     * the page module only.
     *
     * @param GridColumnItem $item
     * @return string
     */
    public function renderPageModulePreviewContent(GridColumnItem $item);

    /**
     * Render a footer for the record to display in page module below
     * the body of the item's preview.
     *
     * @param GridColumnItem $item
     * @return string
     */
    public function renderPageModulePreviewFooter(GridColumnItem $item): string;

    /**
     * Dedicated method for wrapping a preview header and body HTML.
     *
     * @param string $previewHeader
     * @param string $previewContent
     * @param GridColumnItem $item
     * @return string
     */
    public function wrapPageModulePreview($previewHeader, $previewContent, GridColumnItem $item);

.. note::

   Further methods are expected to be added in the future to support generic preview rendering, e.g. usages outside :php:`PageLayoutView`.

Implementing these methods allows you to control the exact composition of the preview.

This means assuming your :php:`PreviewRenderer` returns :html:`<h4>Header</h4>` from the header render method and :html:`<p>Body</p>` from
the preview content rendering method and your wrapping method does :php:`return '<div>' . $previewHeader . $previewContent . '</div>';` then the
entire output becomes :html:`<div><h4>Header</h4><p>Body</p></div>` when combined.

Should you wish to reuse parts of the default preview rendering and only change, for example, the method that renders
the preview body content, you can subclass :php:`\TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer` in your
own :php:`PreviewRenderer` class - and selectively override the methods from the API displayed above.


Configuring the implementation
------------------------------

Individual preview renderers can be defined by using one of the following two approaches:

.. code-block:: php

    $GLOBALS['TCA'][$table]['ctrl']['previewRenderer'] = My\PreviewRenderer::class;


This specifies the PreviewRenderer to be used for any record in :php:`$table`.

Or if your table has a "type" field/attribute:

.. code-block:: php

    $GLOBALS['TCA'][$table]['types'][$type]['previewRenderer'] = My\PreviewRenderer::class;

This specifies the PreviewRenderer only for records of type :php:`$type` as determined by the type field of your table.

Or finally, if your table and field have a :php:`subtype_value_field` TCA setting (like :php:`tt_content.list_type` for example)
and you want to register a preview renderer that applies only when that value is selected (e.g. when a certain plugin type
is selected and you can't match it with the "type" of the record alone):

.. code-block:: php

    $GLOBALS['TCA'][$table]['types'][$type]['previewRenderer'][$subType] = My\PreviewRenderer::class;

Where :php:`$type` is for example :php:`list` (indicating a plugin) and :php:`$subType` is the value of the :php:`list_type` field when the
type of plugin you want to target is selected as plugin type.

.. note::
   The recommended location is in the :php:`ctrl` array in your extension's :file:`Configuration/TCA/$table.php` or
   :file:`Configuration/TCA/Overrides/$table.php` file. The former is used when your extension is the one that creates the table,
   the latter is used when you need to override TCA properties of tables added by the core or other extensions.


Overriding the `PreviewRendererResolver`
----------------------------------------

If necessary, the :php:`PreviewRendererResolver` can be overridden by setting:

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['previewRendererResolver'] = \TYPO3\CMS\Backend\Preview\StandardPreviewRendererResolver::class;

Once overridden, the old resolver will no longer be consulted.

:php:`\TYPO3\CMS\Backend\Preview\PreviewRendererResolverInterface` must be implemented by :php:`PreviewRendererResolvers` and
contains a single API method, :php:`public function resolveRendererFor($table, array $row, int $pageUid);` which
needs to return a single :php:`PreviewRenderer` based on the given input.

