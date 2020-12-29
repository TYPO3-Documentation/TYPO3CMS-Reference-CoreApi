.. include:: /Includes.rst.txt


.. _javascript-form-helpers:

=======================
JavaScript Form Helpers
=======================

Empty Checkbox Handling
=======================

.. code-block:: html

   <input type="checkbox" name="setting" value="1" data-empty-value="0"
      data-global-event="change" data-action-navigate="$data=~s/$value/">

Checkboxes used to send a particular value when unchecked can be achieved by using
:html:`data-empty-value="0"`. If this attribute is omitted, an empty string `''` is sent.

Submitting a Form on Change
===========================

.. code-block:: html

   <input type="checkbox" data-global-event="change" data-action-submit="$form">
   <!-- ... or (using CSS selector) ... -->
   <input type="checkbox" data-global-event="change" data-action-submit="#formIdentifier">

Submits a form once a value has been changed.
(`$form` refers to parent form element, using CSS selectors like `#formIdentifier`
is possible as well)
