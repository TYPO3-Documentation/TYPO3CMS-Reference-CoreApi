.. include:: /Includes.rst.txt


.. _user-settings-extending:

===========================
Extending the User Settings
===========================

Adding fields to the User Settings is done in two steps.
First of all, the new fields are added directly to the
:php:`$GLOBALS['TYPO3_USER_SETTINGS']` array. Then the
field is made visible by calling
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings()`.

The configuration needs to be put into :file:`ext_tables.php`.

Here is an example, taken from the "examples" extension::

   $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_examples_mobile'] = array(
      'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:be_users.tx_examples_mobile',
      'type' => 'text',
      'table' => 'be_users',
   );
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings(
      'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:be_users.tx_examples_mobile,tx_examples_mobile',
      'after:email'
   );

The second parameter in the call to :php:`addFieldsToUserSettings()`
is used to position the new field. In this example, we decide to add it
after the existing "email" field.

In this example the field is also added to the "be_users" table. This is
not described here as it belongs to 'extending the $TCA array'.
See label 'extending' in older versions of the TCA-Reference.

And here is the new field in the User Tools > User Settings module:

.. figure:: Images/UserSettingsExtending.png
   :alt: Extending the User Settings configuration

   The new field visible in the User Settings configuration

"On Click" / "On Confirmation" JavaScript Callbacks
===================================================

To extend the User Settings module with JavaScript callbacks - for example with
a custom button or special handling on confirmation, use :code:`clickData` or
:code:`confirmData`:

.. code-block:: php

   $GLOBALS['TYPO3_USER_SETTINGS'] = [
       'columns' => [
           'customButton' => [
               'type' => 'button',
               'clickData' => [
                   'eventName' => 'setup:customButton:clicked',
               ],
               'confirm' => true,
               'confirmData' => [
                   'message' => 'Please confirm...',
                   'eventName' => 'setup:customButton:confirmed',
               ]
            ],
            // ...

Events declared in corresponding `eventName` options have to be handled by
a custom static JavaScript module. Following snippets show the relevant parts:

.. code-block:: javascript

   document.querySelectorAll('[data-event-name]')
       .forEach((element: HTMLElement) => {
           element.addEventListener('setup:customButton:clicked', (evt: Event) => {
               alert('clicked the button');
           });
       });
   document.querySelectorAll('[data-event-name]')
       .forEach((element: HTMLElement) => {
           element.addEventListener('setup:customButton:confirmed', (evt: Event) => {
               evt.detail.result && alert('confirmed the modal dialog');
           });
       });

PSR-14 event :php:`\TYPO3\CMS\Setup\Event\AddJavaScriptModulesEvent` can be used
to inject a JavaScript module to handle those custom JavaScript events.
