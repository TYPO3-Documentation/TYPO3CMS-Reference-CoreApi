..  include:: /Includes.rst.txt

..  _postupgradetasks:

==================
Post-upgrade tasks
==================

..  _run_upgrade_wizard:
..  _use-the-upgrade-wizard:

Run the upgrade wizard
======================

Enter the Install Tool at :samp:`https://example.org/typo3/install.php` on your
TYPO3 site.

..  include:: /Images/AutomaticScreenshots/Upgrade/UpgradeWizard.rst.txt

TYPO3 provides an upgrade wizard for easy upgrading. Go to the :guilabel:`Upgrade`
section and choose :guilabel:`Upgrade Wizard`.
Take a look at the different wizards provided. You should go
through them one by one.

You must start with :guilabel:`Create missing tables and fields`
if it's displayed, which adds new tables and columns to the database.

Click :guilabel:`Execute`. Now all :file:`ext_tables.sql` files from core and extensions
are read and compared to your current database tables and columns. Any missing
tables and columns will be shown and you'll be able to execute queries
sufficient to add them.

After you added these tables and columns, go on to the next wizard.

..  hint::
    If you have CLI access you can run the update wizards on command line, too.
    This allows you to run all upgrade wizards at once and might help with
    long-running wizards that may fail because of webserver timeouts otherwise.

    For Composer mode

    Run :bash:`./vendor/bin/typo3 upgrade:list -a` to show a complete status of
    upgrade wizards.

    Use :bash:`./vendor/bin/typo3 upgrade:run <wizardName>` to run a specific wizard.

    Use :bash:`./vendor/bin/typo3 upgrade:run` to run all wizards.

    For Classic mode (non-Composer mode) replace :bash:`./vendor/bin/typo3` with
    `./typo3/sysext/core/bin/typo3`.

The "Version Compatibility" wizard sets the compatibility version of your TYPO3
installation to the new version. This allows your frontend output to use new
features of the new TYPO3 version.

..  note::
    This wizard might affect how your website is rendered. After finishing
    the upgrade, check that your website still displays the way it is
    supposed to be and adjust your TypoScript if necessary.

Go through all wizards and apply the (database) updates they propose. Please
note that some wizards provide optional features, like installing system
extensions that you may not need in your current
installation, so take care to only apply those wizards, which you really need.
Apply the optional wizards too - just be sure to select the correct option
(e.g. "No, do not execute"). This way, these wizards will also be removed from
the list of wizards to execute and the upgrade will be marked as "done".

..  include:: /Images/ManualScreenshots/Upgrade/UpgradeWizardExecute.rst.txt

After running through the upgrade wizards go to :guilabel:`Maintenance` >
:guilabel:`Analyze Database Structure`.
You will be able to execute queries to adapt them so that the tables and
columns used by the TYPO3 Core correspond to the structure required for the new
TYPO3 version.

..  note::
    If you don't know the current Install Tool password,
    you can set a new one by entering one in the Install Tool login screen,
    hitting enter and then setting the displayed hash as value
    of :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']`
    in :file:`config/system/settings.php`.


..  note::
    There is an extension :composer:`wapplersystems/core-upgrader`. It contains
    upgrade wizards older than two TYPO3 versions. It can be used to migrate the
    data of installations that need to be upgraded more than two major versions at once.

..  _run_the_database_analyser:
..  _database_analyser:

Run the database analyser
=========================

While in the previous step, tables and columns have been *changed or added* to
allow running the upgrade wizards smoothly. The next step gives you the
possibility to *remove* old and unneeded tables and columns from the database.

Use the "Maintenance section" and click "Analyze Database".

..  include:: /Images/AutomaticScreenshots/AdminTools/DatabaseAnalyzer.rst.txt

See also
`Database compare during update and installation <https://docs.typo3.org/permalink/t3coreapi:database-upgrade>`_.

You will be able to execute queries to remove these tables and columns so that
your database corresponds to the structure required for the new TYPO3 version.

..  warning::
    Be careful if you have deliberately added columns and/or tables to your
    TYPO3 database for your own purposes! Those tables and columns are removed
    only if you mark them to be deleted of course, but please be careful that
    you don't delete them by mistake!

..  note::
    TYPO3 does not directly remove tables and fields, but first renames them
    with a prefix `zzz_deleted_*`. This allows checking whether the fields and
    tables really are not needed anymore or were accidentally marked as deleted
    by wrong configuration.

    When you are sure you aren't going to need them anymore, you can drop them
    via the wizard.

Select the upgrades you want and press "Execute":

..  include:: /Images/ManualScreenshots/Upgrade/DatabaseAnalyzerUpdatesExecuted.rst.txt

When you then click "Compare current database with specification" again and you
only see the message

..  include:: /Images/AutomaticScreenshots/AdminTools/DatabaseAnalyzerDatabaseAnalyzed.rst.txt

then all database updates have been applied.


..  _clear_user_settings:

Clear user settings
===================

You might consider clearing the Backend user preferences. This
can avoid problems, if something in the upgrade requires this. Go to
"Clean up", scroll to "Reset user preferences" and click "Reset backend
user preferences".

..  include:: /Images/AutomaticScreenshots/AdminTools/ResetUserPreferences.rst.txt

..  _post_upgrade_clear_caches:
..  _clear_caches:

Clear caches
============


You have to clear all caches when upgrading.

Go to the :guilabel:`Admin Tools > Maintenance` backend module and click on the
:guilabel:`Flush cache` button:

..  include:: /Images/AutomaticScreenshots/AdminTools/ClearAllCache.rst.txt

Additionally, after an upgrade to a new major version, you should also delete
the other temporary files, which TYPO3 saves in the :file:`typo3temp/` folder.
In the :guilabel:`Admin Tools > Maintenance` module click on the
:guilabel:`Remove Temporary Assets > Scan temporary files` button and select the
appropriate folders.

..  note::
    When you delete the :file:`_processed_/` folder of a file storage all scaled
    images will be removed and the according images processed again when
    visiting a webpage the next time. This may slow down the first rendering of
    the webpage.

..  include:: /Images/AutomaticScreenshots/AdminTools/RemoveTemporaryAssets.rst.txt


..  _update_backend_translation:
..  _update-translations:

Update backend translations
===========================

In the Install tool, go to the module "Maintenance" -> "Manage languages" and
update your translations. If you don't update your translations, new texts will
only be displayed in English. Missing languages or translations can be added
following the section
:ref:`Internationalization and Localization <t3coreapi:internationalization>`.

..  include:: /Images/AutomaticScreenshots/AdminTools/InstallLanguagePacks.rst.txt

..  _maintain-htaccess:

Verify webserver configuration (.htaccess)
==========================================

After an update, the :file:`.htaccess` file may need adoption for the latest TYPO3
major version (for Apache webservers), :ref:`see details on .htaccess <htaccess>`.

Compare the file :file:`vendor/typo3/cms-install/Resources/Private/FolderStructureTemplateFiles/root-htaccess`
(or `.htaccess <https://github.com/TYPO3/typo3/blob/main/typo3/sysext/install/Resources/Private/FolderStructureTemplateFiles/root-htaccess>`__)
with your project's :file:`.htaccess` file and adapt new rules accordingly. If you never
edited the file, copy it over to your project to ensure using the most recent version.

Your project's :file:`.htaccess` file should be under version control and part of your
deployment strategy.

For NGINX based webservers, you may also need to adapt configuration. The changelogs of
TYPO3 will contain upgrade instructions, like in
:ref:`Deprecation: #87889 - TYPO3 backend entry point script deprecated <changelog:deprecation-87889-1705928143>`
