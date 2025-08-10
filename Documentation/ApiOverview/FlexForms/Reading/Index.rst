:navigation-title: Reading

..  include:: /Includes.rst.txt
..  _read-flexforms:

=========================
Reading FlexForm settings
=========================

FlexForms can be used to store data within an XML structure inside a single DB
column.

..  contents::

..  _read-flexforms-extbase:

Reading FlexForm settings from an Extbase controller
====================================================

All plugin settings are provided in the array  :php:`$this->settings` in the
Extbase controller.

Settings defined via TypoScript are overridden by non-empty values from
settings in the FlexForm of the plugin's content element.


Only FlexForm settings prefixed with `settings.` are available in the controllers
:php:`$this->settings` array. For example FlexForm field `settings.includeCategories`
is available as `$this->settings['includeCategories']`.

Do not rely on any key in the :php:`$this->settings` array being set and always
cast it to the appropriate type. Otherwise PHP errors might be triggered if a
value is not defined in the plugin.

..  code-block:: php
    :caption: packages/my_extension/Classes/Controller/SomeController.php

    $includeCategories = (bool) ($this->settings['includeCategories'] ?? false);

..  _read-flexforms-php:

FlexFormService: Read FlexForms values in PHP
=============================================

You can use the :php-short:`\TYPO3\CMS\Extbase\Service\FlexFormService` to read
the content of a FlexForm field.

This is useful in plain controllers without Extbase support or in other contexts
like console commands or middleware, where no settings are available.

Using :php:`FlexFormService->convertFlexFormContentToArray` the resulting
array can be used conveniently in most use cases:

..  literalinclude:: _codesnippets/_NonExtbaseController.php
    :caption: EXT:my_extension/Classes/Controller/NonExtbaseController.php

..  _read-flexforms-php-structure:

Read the FlexForm data preserving the internal structure
========================================================

The result of :php:`GeneralUtility::xml2array()` preserves the internal
structure of the XML FlexForm, and is usually used to modify a FlexForm
string.

..  code-block:: php

    $flexFormStructure = GeneralUtility::xml2array($flexFormString);

See also section :ref:`modify-flexforms-php`.

..  index:: pair: FlexForms; TypoScript
..  _read-flexforms-ts:

TypoScript: Reading flexform data
---------------------------------

It is possible to read FlexForm properties from TypoScript:

..  literalinclude:: _codesnippets/_flexformContent.typoscript

The key `flexform` is followed by the field which holds the FlexForm data
(`pi_flexform`) and the name of the property whose content should be retrieved
(`settings.categories`).

..  seealso::

   *    :ref:`TypoScript: flexform <t3tsref:data-type-gettext-flexform>`

..  _read-flexforms-fluid:

flex-form data processor
========================

If you defined your :typoscript:`FLUIDTEMPLATE` in TypoScript, you can use
`flex-form data processor <https://docs.typo3.org/permalink/t3tsref:flexformprocessor>`_.

This example would make your FlexForm data available as Fluid variable
`{myOutputVariable}`:

..  literalinclude:: _codesnippets/_dataproccessor.typoscript
