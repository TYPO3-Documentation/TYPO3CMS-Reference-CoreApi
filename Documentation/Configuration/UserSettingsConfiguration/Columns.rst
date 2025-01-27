..  include:: /Includes.rst.txt
..  index:: User settings; Columns
..  _user-settings-columns:

===================
['columns'] Section
===================

This contains the configuration array for single fields in the user
settings. This array allows the following configurations:

..  confval:: type
    :name: user-settings-type
    :type: string
    :Allowed values: `button`, `check`, `password`, `select`, `text`, `user`

    Defines the type of the input field

    If `type == user`, then you need to define your own `renderType` too.
    If selectable items shall be filled by your own function, then you can use `type == select` and `itemsProcFunc`.

    **Example:**

    ..  code-block:: php

        'startModule' => [
           'type' => 'select',
           'itemsProcFunc' => 'TYPO3\\CMS\\Setup\\Controller\\SetupModuleController->renderStartModuleSelect',
           'label' => 'LLL:EXT:setup/mod/locallang.xlf:startModule',
        ],

..  confval:: label
    :name: user-settings-label
    :type: string

    Label for the input field, should be a pointer to a localized
    label using the :code:`LLL:` syntax.


..  confval:: buttonLabel
    :name: user-settings-buttonLabel
    :type: string

    Text of the button for type=button fields.
    Should be a pointer to a localized label using the :code:`LLL:` syntax.

..  confval:: access
    :name: user-settings-access
    :type: string
    :Allowed values: `admin`

    Access control. At the moment only a admin-check is implemented

..  confval:: table
    :name: user-settings-table
    :type: stringstring
    :Allowed values: `be_users`

    If the user setting is saved in a DB table, this property sets the
    table. At the moment only `be_users` is implemented.

..  confval:: items
    :name: user-settings-items
    :type: array

    List of items for type=select fields. This should be a simple associative
    array with key-value pairs.

..  confval:: itemsProcFunc
    :name: user-settings-itemsProcFunc
    :type: array

    Defines an external method for rendering items of select-type fields.
    Contrary to what is done with the TCA you have to render the <select>
    tag too. Only used by type=select.

    Use the usual class->method syntax.

..  confval:: clickData.eventName
    :name: user-settings-clickData-eventName
    :type: string

    JavaScript event triggered on click.

..  confval:: confirm
    :name: user-settings-confirm
    :type: boolean

    If true, JavaScript confirmation dialog is displayed.

..  confval:: confirmData.eventName
    :name: user-settings-confirmData-eventName
    :type: string

    JavaScript event triggered on confirmation.

..  confval:: confirmData.message
    :name: user-settings-type
    :type: string

    Confirmation message.
