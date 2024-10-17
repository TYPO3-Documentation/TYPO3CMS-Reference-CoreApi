..  include:: /Includes.rst.txt

..  index:: languages, backend language

..  _backendlanguages:

=============================
Changing the backend language
=============================

By default, TYPO3's backend is set to English with no additional languages
available.

.. contents:: **Table of Contents**
   :depth: 1
   :local:


Install an additional language pack
===================================

An additional language pack can be installed as an administrator in the backend:

..  rst-class:: bignums

1.  Go to :guilabel:`Admin Tools > Maintenance > Manage Languages Packs`

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguage.rst.txt

2.  Select :guilabel:`Add Language` and activate the new language:

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguagePacksAddLanguage.rst.txt

3.  The selected language is now available:

    ..  include:: /Images/AutomaticScreenshots/Modules/ManageLanguagePacksAddLanguageAddSuccess.rst.txt

..  note::
    ..  versionadded:: 12.1

    If the :file:`config/system/settings.php` file is write-protected, all
    buttons are disabled and an info box is rendered.


Set the language as backend language for yourself
=================================================

One of the available backend languages can be selected in your user account.
Go to :guilabel:`Toolbar (top right) > User Avatar > User Settings` and select
the new language from the field :guilabel:`Language`:

..  include:: /Images/AutomaticScreenshots/BackendUsers/SettingsLanguage.rst.txt

Save the settings and reload the browser content.

..  note::
    This change only applies to your account.


Change the backend language of another user
===========================================

As an administrator you can change the backend language of another user.

..  rst-class:: bignums

1.  Go to :guilabel:`System > Backend Users`

    ..  include:: /Images/AutomaticScreenshots/BackendUsers/BackendUserListing.rst.txt

2.  Select the user

3.  Change the language

    Select the new language from the field :guilabel:`User Interface Language`.

    ..  include:: /Images/AutomaticScreenshots/BackendUsers/SwitchUserLanguage.rst.txt
