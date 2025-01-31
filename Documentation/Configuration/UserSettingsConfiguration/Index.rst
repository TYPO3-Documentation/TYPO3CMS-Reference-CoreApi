..  include:: /Includes.rst.txt
..  index::
    User settings
    Module; User settings
    $GLOBALS; TYPO3_USER_SETTINGS
..  _user-settings-reference:
..  _user-settings:

===========================
User settings configuration
===========================

The user settings module determines what user settings are available
for backend users. The users can access the settings by clicking on their name in
the top bar and then "User settings".

A number of settings such as backend language, password etc. are available
by default. These settings may be extended via extensions as described in
:ref:`user-settings-extending`.

The User Settings module has the most complex form in the TYPO3 backend
not driven by TCA/TCEforms. Instead it uses its own PHP configuration
array :php:`$GLOBALS['TYPO3_USER_SETTINGS']`. It is quite similar to
:doc:`$GLOBALS['TCA'] <t3tca:Index>`, but with less options.

The actual values can be accessed via the array :php:`$GLOBALS['BE_USER']->uc`
as described in :ref:`be-user-configuration`.

This functionality is provided by the `typo3/cms-setup` Composer package.

**Contents:**

..  toctree::
    :titlesonly:

    Columns
    Showitem
    Extending
    Checking
