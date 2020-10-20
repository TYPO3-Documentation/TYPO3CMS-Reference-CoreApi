.. include:: ../../../Includes.txt


.. _javascript-navigation:

=========================
Navigation via JavaScript
=========================

Navigate to URL
===============

Navigate to a URL once selected drop-down is changed:

.. code-block:: html

   <select data-global-event="change" data-action-navigate="$value">'

`$value` refers to selected value.

Navigate to URL with Data
=========================

Navigate to an URL on change of a drop-down, including the selected value in the URL:

.. code-block:: html

   <select value="0" name="depth" data-global-event="change"
      data-action-navigate="$data=~s/$value/" data-navigate-value="https://example.org/${value}">

`$data` refers to value of :html:`data-navigate-value`, `$value` to selected value,
`$data=~s/$value/` replaces literal `${value}` with selected value in `:html:`data-navigate-value`


Show Info Popup
===============

Invoke :js:`TYPO3.InfoWindow.showItem` module function to display details for a given
record:

.. code-block:: html

   data-dispatch-action="TYPO3.InfoWindow.showItem" data-dispatch-args-list="be_users,123">
   <!-- ... or (using JSON arguments) ... -->
   data-dispatch-action="TYPO3.InfoWindow.showItem" data-dispatch-args="[&quot;tt_content&quot;,123]">

Shows the info popup of database table `tt_content`, having `uid=123` in the example above.
