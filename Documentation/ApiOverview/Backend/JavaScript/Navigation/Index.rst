..  include:: /Includes.rst.txt
..  index:: JavaScript (Backend); Navigation
..  _javascript-navigation:

=========================
Navigation via JavaScript
=========================

Navigate to URL
===============

Navigate to a URL once selected drop-down is changed:

..  code-block:: html

    <select data-global-event="change" data-action-navigate="$value">
        <!-- ... options ... -->
    </select>

`$value` refers to the selected value.

Navigate to URL with data
=========================

Navigate to a URL on change of a drop-down, including the selected value in the
URL:

..  code-block:: html

    <select
        value="0"
        name="depth"
        data-global-event="change"
        data-action-navigate="$data=~s/$value/"
        data-navigate-value="https://example.org/${value}"
    >
        <!-- ... options ... -->
    </select>

`$data` refers to value of :html:`data-navigate-value`, `$value` to selected value,
`$data=~s/$value/` replaces the literal `${value}` with the selected value in
:html:`data-navigate-value`.


Show info popup
===============

Invoke the :js:`TYPO3.InfoWindow.showItem` module function to display details
for a given record:

..  code-block:: html

    <a
        class="btn btn-default"
        href="#"
        data-dispatch-action="TYPO3.InfoWindow.showItem"
        data-dispatch-args-list="be_users,123"
    >
        Some text
    </a>

or (using JSON arguments)

..  code-block:: html

    <a
        class="btn btn-default"
        href="#"
        data-dispatch-action="TYPO3.InfoWindow.showItem"
        data-dispatch-args="[&quot;tt_content&quot;,123]"
    >
        Some text
    </a>

Shows the info popup of database table :sql:`tt_content`, having `uid=123` in
the example above.
