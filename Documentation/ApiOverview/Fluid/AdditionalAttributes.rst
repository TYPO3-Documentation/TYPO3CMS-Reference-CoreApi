.. include:: /Includes.rst.txt
.. index:: Fluid; additionalAttributes

=============================
Property additionalAttributes
=============================

All Fluid ViewHelper that create exactly one HTML tag, tag-based ViewHelpers,
can get passed the property :html:`additionalAttributes`.

A tag-based Fluid ViewHelper generally supports most attributes that are
also available in HTML. There are, for example, the attributes `class` and
`id`, which exists in all tag-based ViewHelpers.

Sometimes attributes are needed that are not provided by the
ViewHelper. A common example are data attributes.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:form.textbox additionalAttributes="{data-anything: 'some info', data-something: some.variable}" />


The property `additionalAttributes` are especially helpful if only a
few of these additional attributes are needed. Otherwise, it is often
reasonable to write an own ViewHelper which extends the corresponding
ViewHelper.

The property `additionalAttributes` is provided by the
:php:`TagBasedViewHelper` so it is also available to custom ViewHelpers
based on this class. See chapter :ref:`fluid-custom-viewhelper`.
