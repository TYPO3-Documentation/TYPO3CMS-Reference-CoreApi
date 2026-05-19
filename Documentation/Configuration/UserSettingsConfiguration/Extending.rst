.. include:: /Includes.rst.txt
.. index:: User settings; Custom settings
.. _user-settings-extending:

===========================
Extending the user settings
===========================

..  deprecated:: 14.2

    The method :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings()`
    has been deprecated in favor of the new :php:`addUserSetting()` method.

Adding fields to User Settings is done in a TCA Overrides file.

Here is an example taken from the "examples" extension:

..  literalinclude:: _be_users.php
    :caption: EXT:examples/Configuration/TCA/Overrides/be_users.php

The third parameter in the call to :php:`addUserSetting()`
is used to position the new field. In this example we add it
after the existing "email" field.

The new field is then displayed in the user settings after clearing the caches.

..  _user-settings-tca:
..  _user-settings-showitem:
..  _user-settings-checking:
..  _user-settings-columns:

TCA available for the user settings module
==========================================

The `user_settings` TCA column has the following structure:

`columns`
    Array of field configurations, each containing:

    `label`
        The field label (LLL reference or string)

    `config`
        Standard TCA config array (type, renderType, items, etc.)

    `table` (optional)
        Set to `'be_users'` if the field is stored in a be_users table column

`showitem`
    Comma-separated list of fields to display, supports `--div--;` for tabs

Available field types:

*   `input` - Text input field
*   `number` - Number input field
*   `email` - Email input field
*   `password` - Password input field
*   `check` with :`renderType => 'checkboxToggle'` - Checkbox/toggle
*   `select` with `renderType => 'selectSingle'` - Select dropdown
*   `language` - Language selector

.. _user-settings-extending-javascript:

"On Click" / "On Confirmation" JavaScript Callbacks
===================================================

PSR-14 event :ref:`AddJavaScriptModulesEvent` can be used
to inject a JavaScript module to handle custom JavaScript events.

.. _user-settings-extending-migration:

Migration from addFieldsToUserSettings to addUserSetting
========================================================

Replace the two-step approach with the new :php:`addUserSetting()` method.
Note that the new method uses TCA-style configuration and should be called from
:file:`Configuration/TCA/Overrides/be_users.php` instead of :file:`ext_tables.php`.

Before:

..  code-block:: php
    :caption: ext_tables.php (before)

    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['myCustomSetting'] = [
        'type' => 'check',
        'label' => 'my_extension.messages:myCustomSetting',
    ];
    ExtensionManagementUtility::addFieldsToUserSettings(
        'myCustomSetting',
        'after:emailMeAtLogin'
    );

After:

..  code-block:: php
    :caption: Configuration/TCA/Overrides/be_users.php (after)

    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

    ExtensionManagementUtility::addUserSetting(
        'myCustomSetting',
        [
            'label' => 'my_extension.messages:myCustomSetting',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'after:emailMeAtLogin'
    );
