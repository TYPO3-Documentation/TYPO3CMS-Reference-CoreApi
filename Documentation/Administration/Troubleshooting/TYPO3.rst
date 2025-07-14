.. include:: /Includes.rst.txt

.. index:: resetting password, new password, new user

.. _troubleshooting-typo3:

=====
TYPO3
=====

.. _troubleshooting-typo3-password-reset:

Resetting Passwords
===================

.. _troubleshooting-backend-admin-password:

Backend Administrator Password
------------------------------

When the password for a backend user needs to be reset, log into the backend with an
alternative user and use the :guilabel:`System > Backend Users` tool to reset
the users password. Note that only backend users with administrative rights can
access the `Backend Users` tool to make this change.

If an alternative administrator account is not available or it doesn't have the
appropriate access, the Install Tool can be accessed directly
using the following address to create a new administrative user:

.. code-block:: none

   https://example.com/typo3/install.php

The Install Tool requires the "Installation Password" that would have been set
when TYPO3 was installed.

.. include:: /Images/AutomaticScreenshots/InstallTool/InstallToolPassword.rst.txt

Once logged in to the Admin Tool go to :guilabel:`Maintenance > Create Administrative User`
and select :guilabel:`Create Administrator`. In this dialogue you
can create a new administrative user.

.. include:: /Images/AutomaticScreenshots/BackendUsers/CreateAdministrator.rst.txt

.. include:: /Images/AutomaticScreenshots/BackendUsers/CreateAdministratorForm.rst.txt

Use this new administrator account to log into the TYPO3 backend. In the module
:guilabel:`Backend Users` you can change the passwords of existing users,
including administrators.

.. _troubleshooting-install-tool-password:

Install Tool Password
---------------------

..  versionadded:: 14.0

    You can also use command `vendor/bin/typo3 install:password:set
    <https://docs.typo3.org/permalink/t3coreapi:console-command-install-password-set>`_
    to change the install tool password.

Write access to :file:`config/system/settings.php` (in Classic mode installations
:file:`typo3conf/system/settings.php`) is required to reset the
:guilabel:`Install Tool` password.

Before editing this file, visit:

.. code-block:: none

   https://example.com/typo3/install.php


Enter the new password into the dialogue box. As the new password is not correct,
the following response will be returned:

.. code-block:: none
   :caption: Example Output

   "Given password does not match the install tool login password. Calculated hash:
   $argon2i$v=xyz"

Copy this hash including the :php:`$argon2i` part and any trailing dots.

Then edit :file:`config/system/settings.php` and replace the following
array entry with the new hashed password:

.. code-block:: php
   :caption: config/system/settings.php

   'BE' => [
      'installToolPassword' => '$argon2i$v=xyz',
   ],

..  note::

    If the new install tool password does not work, check if it gets overridden
    later in the file :file:`config/system/settings.php` or in the
    file :file:`config/system/additional.php`
    if one exists. If you can still not log into the install tool check if
    there are errors in the logs when debugging is enabled.

.. _troubleshooting-debug-mode:

Debug Settings
==============

During troubleshooting, in the :guilabel:`"Settings > Configuration Presets"`
section of the Install Tool, under "Debug settings", the "Debug" preset can be
change to show errors in the frontend.

.. include:: /Images/AutomaticScreenshots/DebugSettings/ConfigurationPresets.rst.txt

.. include:: /Images/AutomaticScreenshots/DebugSettings/DebugSettings.rst.txt

The following TypoScript setting can also be added to the root TypoScript for
the site to show additional debug information.
This is particularly useful when debugging Fluid errors:

..  code-block:: typoscript
    :caption: config/sites/my_site/setup.typoscript

    config.contentObjectExceptionHandler = 0

.. seealso::

   :ref:`t3coreapi:error-handling-configuration-examples-debug`

.. important::

   Once debugging has been completed, make sure to remove any debug Typoscript and
   set Debug setting back to 'Live'.

Additionally, the following logs should be checked for additional information:

*  Webserver log files for general problems (e.g. :file:`/var/log/apache2` or :file:`/var/log/httpd` on
   Linux based systems)
*  TYPO3 Administration log in :guilabel:`SYSTEM > Log` via TYPO3's backend.
*  TYPO3 logs written by the :ref:`Logging Framework <t3coreapi:logging>` located in :file:`var/log`
   or :file:`typo3temp/var/log` depending on the installation setup.

.. _troubleshooting-caching:

Caching
=======

.. _troubleshooting-caching-typo3temp:

Cached Files in typo3temp/
--------------------------

TYPO3 generates temporary "cached" files and PHP scripts in :file:`<var-path>/cache/`
(either :file:`typo3temp/var/cache` or :file:`var/cache` depending on the installation).
You can remove the entire :file:`<var-path>/cache` directory at any time; the directory
structure and all the caches will be re-written on the next time a visitor
accesses the site.

A shortcut to remove these caches can be found in the :guilabel:`Install Tool`,
under :guilabel:`Important Actions`. This might be useful in the event your
cache files become damaged and your system is not running correctly. The
Install Tool won't load any of these caches or any extension, so it
should be safe to use regardless of the corrupt state of the Caches.

Amongst other caches, under :file:`<var-path>/cache/code/core/`
you will find:

.. code-block:: bash
   :caption: <var-path>/cache/code/core/

   -rw-rw----   1 www-data   www-data   61555  2014-03-26 16:28   ext_localconf_8b0519db6112697cceedb50296df89b0ce04ff70.php
   -rw-rw----   1 www-data   www-data   81995  2014-03-26 16:28   ext_tables_c3638687920118a92ab652cbf23a9ca69d4a6469.php

These files contain all :file:`ext\_tables.php` and
:file:`ext\_localconf.php` files of the installed extensions
concatenated in the order they are loaded. Therefore including one of
these files would be the same as including potentially hundreds of PHP
files and should improve performance.

.. _troubleshooting-possible-problems-with-the-cached-files:

Possible Problems With the Cached Files
---------------------------------------

.. _troubleshooting-changing-the-absolute-path-to-typo3:

Changing the absolute path to TYPO3
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you change the path of the TYPO3 installation, you might receive similar
errors that include "Failed opening ..." or "Unable to access ...". The
problem is that absolute file paths are hard-coded inside the cached
files.

Fix: Clean the cache using the Install Tool: Go to "Important Actions"
and use the "Clear all caches" function. Then hit the page again.

.. _troubleshooting-changing-image-processing-settings:

Changing Image Processing Settings
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When you change the settings for Image Processing (in normal mode),
you must take into account that old images may still be in the
:file:`typo3temp/` folder and that they prevent new files from being
generated! This is especially important to know, if you are trying to
set up image processing for the very first time.

The problem is solved by clearing the files in the :file:`typo3temp/`
folder. Also make sure to clear the database table "cache\_pages".
