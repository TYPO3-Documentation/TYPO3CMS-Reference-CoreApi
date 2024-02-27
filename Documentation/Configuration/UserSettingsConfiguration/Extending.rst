.. include:: /Includes.rst.txt
.. index:: User settings; Custom settings
.. _user-settings-extending:

===========================
Extending the user settings
===========================

Adding fields to the User Settings is done in two steps.
First of all, the new fields are added directly to the
:php:`$GLOBALS['TYPO3_USER_SETTINGS']` array. Then the
field is made visible by calling
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings()`.

The configuration needs to be put into :file:`ext_tables.php`.

Here is an example, taken from the "examples" extension:

..  literalinclude:: _ext_tables.php
    :language: php
    :caption: EXT:examples/ext_tables.php

The second parameter in the call to :php:`addFieldsToUserSettings()`
is used to position the new field. In this example, we decide to add it
after the existing "email" field.

In this example the field is also added to the "be_users" table. This is
not described here as it belongs to 'extending the $TCA array'.
See label 'extending' in older versions of the TCA-Reference.

And here is the new field in the User Tools > User Settings module:

.. include:: /Images/AutomaticScreenshots/UserSettings/UserSettingsExtending.rst.txt

"On Click" / "On Confirmation" JavaScript Callbacks
===================================================

To extend the User Settings module with JavaScript callbacks - for example with
a custom button or special handling on confirmation, use :code:`clickData` or
:code:`confirmData`:

..  literalinclude:: _ext_tables_settings.php
    :language: php
    :caption: EXT:examples/ext_tables.php

Events declared in corresponding `eventName` options have to be handled by
a custom static JavaScript module. Following snippets show the relevant parts:

..  literalinclude:: _event.js
    :language: js

PSR-14 event :ref:`AddJavaScriptModulesEvent` can be used
to inject a JavaScript module to handle those custom JavaScript events.
