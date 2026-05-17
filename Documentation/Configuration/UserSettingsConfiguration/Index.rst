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

..  versionchanged:: 14.2

    The backend user profile settings configuration, previously stored in
    :php:`$GLOBALS['TYPO3_USER_SETTINGS']`, is now available in TCA at
    :php:`$GLOBALS['TCA']['be_users']['columns']['user_settings']`.

The user settings module determines what user settings are available
for backend users. The users can access the settings by clicking on their name in
the top bar and then "User settings".

A number of settings such as backend language, password etc. are available
by default. These settings may be extended via extensions as described in
:ref:`user-settings-extending`.

The User Settings module is handled by TCA and configured via
:php:`$GLOBALS['TCA']['be_users']['columns']['user_settings']`. It does however
have less options then normal TCA.

The actual values can be accessed via the array :php:`$GLOBALS['BE_USER']->getUserSettings()`
as described in :ref:`be-user-configuration`.

**Contents:**

..  toctree::
    :titlesonly:

    Extending
