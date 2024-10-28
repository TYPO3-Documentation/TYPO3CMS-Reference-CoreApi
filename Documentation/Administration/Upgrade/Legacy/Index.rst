.. include:: /Includes.rst.txt

.. _legacy:

==============
Legacy Upgrade
==============

Minor Upgrades  - Using The Core Updater
========================================

The "Install Tool" in the section "Important Actions" provides a function to
update the TYPO3 Core.

In the section "Important Actions" scroll down to "Core update" and click the
"Check for core updates" button. If the requirements are met, TYPO3 will
automatically install the new source code.

.. note::

   For the Core Updater to work, the following setup is required:

   *  It only works in Unix-like systems (including macOS).

   *  :file:`typo3_src` must be a symlink.

   *  This symlink needs to be writable (and deletable) by the web-server user.

   *  The document root needs to be writable.

   *  One path above document root (:file:`../`) needs to be writable (creation
      of new directories must be allowed).

   *  The :program:`tar` command must be available (for extracting the Source
      package).


.. _install-manually:

Major Upgrades - Symlink The Core
=================================

Go to https://typo3.org/download/ and download
the source package of the new TYPO3 version.

Extract the package on your web server and, in your TYPO3 document root,
adjust the :file:`typo3_src` symlink.

.. important::
   Make sure to upload the whole TYPO3 source directory including the
   :file:`vendor` directory, otherwise you will miss important dependency
   updates.

Disabling the Core Updater
--------------------------

The Core Updater functionality can be turned off, in order to avoid users using it,
i.e. if you use your own update mechanism.

This feature is already disabled when TYPO3 is installed via Composer.

To disable the Core updater, you can set this environment variable:

.. code-block:: none
   :caption: Environment variable

   TYPO3_DISABLE_CORE_UPDATER=1

For example in Apache:

.. code-block:: apacheconf
   :caption: typo3_root/public/.htaccess

   SetEnv TYPO3_DISABLE_CORE_UPDATER 1

or for NGINX:

.. code-block:: nginx
   :caption:  /usr/local/nginx/conf/nginx.conf

   server {
     location ~ path/to/it {
       include fastcgi_params;
       fastcgi_param TYPO3_DISABLE_CORE_UPDATER "1";
     }
   }

This will remove the button and all related functionality in the Install
Tool.

What's the Next Step?
=====================

In case you performed a *minor update*, e.g. from TYPO3 12.4.0 to 12.4.1, database
updates are usually *not* necessary, though you still have to
:ref:`remove the temporary cache files <clear_caches>`. After
that your update is finished.

.. note::

   Make sure to read the release notes of even the minor versions carefully. While
   great care is taken to keep the minor updates as easy as possible, (especially
   when releasing security updates) more steps might be necessary.

In case of a *major update*, e.g. from TYPO3 11.5 to 12.4, go ahead with the next
step!

Also check out any breaking changes listed in the :doc:`changelog <ext_core:Index>`
for the new version.
