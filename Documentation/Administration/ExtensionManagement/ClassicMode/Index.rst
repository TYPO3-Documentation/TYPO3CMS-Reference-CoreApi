..  include:: /Includes.rst.txt

..  _extensions-classic-mode-management:
..  _extensions-legacy-management:

====================================
Installing Extensions - Classic mode
====================================

.. _extension-manager:
.. _extension-package-manager:
.. _extension-install:

Installing an Extension using the Extension Manager
===================================================

In the backend:

..  rst-class:: bignums

1.  Go to :guilabel:`Admin Tools > Extensions`
2.  In the Docheader, select :guilabel:`Get Extensions`
3.  Click :guilabel:`Update now`

    The button is on the top right.

4.  Enter the name of the extension in the search field
5.  Click on :guilabel:`Go`
6.  Click on the Action icon on the left for the extension:

    :guilabel:`Import and Install`

    Now the extension is installed, but not activated. To activate:

7.  Choose :guilabel:`Installed Extensions` in the Docheader
8.  Click on the icon with a :guilabel:`+` sign for your extension
    in the :guilabel:`A/D` column.

..  _uninstall-extension-without-composer:

Uninstall an Extension Without Composer
=======================================

If you installed TYPO3 via composer you should uninstall Extensions via composer.

..  _uninstall-extension-without-composer-dependencies:

Check Dependencies
------------------

First find out, which other extensions and functions of your TYPO3 installation
are dependent on the extension you want to uninstall. You can find out about
the dependencies by checking the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`__. Look for
the extension you want to uninstall and the others you have installed. Read
in each extensions manual the sections 'Dependencies' and 'Reverse dependencies'.

Check whether any referrals have been made to the extension in any setup, config
or other TypoScript files. Check if you included a plugin from the extension
in your web site. Think of the results of removing them and finally do it.

If you are working locally or on a test server you might as well try to
uninstall the extension. The Extension Manager warns you about dependencies that
are written in an extensions :file:`ext_emconf.php` constraints section.
Note however that you depend on the extensions developers faithfully noting
all dependencies in this config file.

If you get an exception and cannot access the Extension Manager anymore because
of it, you can uninstall / install extensions manually with
:file:`PackageStates.php` as a last resort, see
:ref:`uninstall-extension-manually`

..  tip::
    Be sure not to uninstall extensions by trial and error on production
    systems, especially not under time pressure.

..  _uninstall-extension-backend:

Uninstall / Deactivate Extension via TYPO3 Backend
--------------------------------------------------

..  include:: /Images/AutomaticScreenshots/ExtensionManager/UninstallExtension.rst.txt


Log into the TYPO3 Backend and open the module
:guilabel:`Admin tools > Extensions`. From the menu choose
:guilabel:`Install extensions`. You get an overview about installed extensions.

On the left side you see an icon, which shows the status of each extension,
and what you can do:

*   Extension Install Icon with plus sign: The extension is
    not installed. (Click once to install)
*   Extension Uninstall Icon with minus sign: The extension is installed
    and running. (Click once to uninstall)

Next to the extension you want to uninstall click on Extension UnInstall Icon.
After some seconds the icon changes to the grey Extension Install Icon.

..  _remove-extension-backend:

Remove an Extension via the TYPO3 Backend
--------------------------------------------------

After successfully uninstalling an extension via the Extension Manager you
can permanently remove the extension by clicking on the waste-basket symbol
"Remove" beside the extensions entry in the Extension Manager.

..  _uninstall-extension-manually:

Uninstalling an Extension Manually
----------------------------------

At times an extension causes a problem and the TYPO3 Backend can not
be opened anymore due to it. In such a case the extension can be uninstalled
manually. This is not common practise but a last resort.

This can be done by removing the extensions configuration from the file
:file:`PackageStates.php`

..  rst-class:: bignums

#.  Open the file :file:`typo3conf/PackageStates.php`
#.  Search for your ext_key in the array.

    ..  code-block:: php
        :caption: typo3conf/PackageStates.php

        'ext_key' => [
              'packagePath' => 'typo3conf/ext/ext_key/',
        ],
        //...

#. Remove the entry.

..  _remove-extension-manually:

Removing an extension manually
------------------------------

Removing an extension manually is not common practice and should only be done
as a last resort. You should only remove an extension that you uninstalled
successfully. Make a backup first. Then you can permanently remove an extension
by removing its folder at :file:`typo3conf/ext/[extensionname]`. The
corresponding database tables can be removed in the
:guilabel:`Admin Tools > Maintenance > Analyze Database Structure`.
