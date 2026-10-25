..  include:: /Includes.rst.txt
..  index:: Events; BeforeFormValueIsRenderedEvent

..  _BeforeFormValueIsRenderedEvent:

================================
`BeforeFormValueIsRenderedEvent`
================================

..  versionadded:: 15.0
    :changelog: feature-109836-1786049025

The event :php:`\TYPO3\CMS\Form\Event\BeforeFormValueIsRenderedEvent`
is dispatched before the value of a single form element is rendered, for
example on the summary page or in an email. A listener can change the
data that is passed to Fluid in `$data`, such as the `processedValue`, and
add keys for custom templates. The form element and the form runtime are
available in `$element` and `$formRuntime`.

..  _BeforeFormValueIsRenderedEvent-example:

Example: Show "Yes" or "No" for a checkbox on the summary page
==============================================================

A checkbox shows its raw value on the summary page and in emails. The
following listener sets the `processedValue` of every element of type
`Checkbox` to "Yes" or "No":

..  literalinclude:: _BeforeFormValueIsRenderedEvent/_CheckboxYesNoListener.php
    :caption: EXT:my_extension/Classes/EventListener/CheckboxYesNoListener.php

..  _BeforeFormValueIsRenderedEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Form\Event\BeforeFormValueIsRenderedEvent
