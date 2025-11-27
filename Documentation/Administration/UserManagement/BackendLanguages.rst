:navigation-title: Language

..  include:: /Includes.rst.txt
..  index:: languages, backend language
..  _backendlanguages:

=============================
Changing the backend language
=============================

By default, TYPO3's backend is set to English with no additional languages
available.

..  contents:: **Table of Contents**
    :depth: 1
    :local:

..  _chose-backend-language:

Set your backend language
=========================

One of the available backend languages can be selected in your user account.

Go to :guilabel:`Toolbar (top right) > User Avatar > User Settings` and select
the new language from the field :guilabel:`Language`:

..  figure:: /Images/ManualScreenshots/UserManagement/Users/UserSettingsLanguage.png
    :alt: The tab "Personal data" of the User settings, including field "Language"

If the desired language is not available, administrators with system maintainer
permissions can :ref:`Load an additional language pack <load-language-pack>`
in module :guilabel:`System > Maintenance`.

Save the settings and reload the browser content.

..  note::
    This change only applies to the currently active account.

..  _change-backend-language:

Change the default backend language of a backend user
=====================================================

As an administrator you can change the backend language of another user.

In the record of the backend user, tab general, choose "User interface language".

This setting only takes effect for users that did not :ref:`switch the backend
language in their user settings <chose-backend-language>`.
