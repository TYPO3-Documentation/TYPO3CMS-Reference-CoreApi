.. include:: /Includes.rst.txt
.. index:: Extension Manager
.. _extension-manager:

Extension management
====================

Extensions are managed from the Extension Manager inside TYPO3 by
"admin" users. The module is located at **ADMIN TOOLS > Extensions**
and offers a menu with options to see loaded extensions (those that
are installed or activated), available extensions on the server and
the possibility to import extensions from online resources, typically
the TER (TYPO3 Extension Repository) located at typo3.org.

.. include:: /Images/AutomaticScreenshots/AdminTools/ExtensionManager.rst.txt

The interface is really easy to use. You just click the +/- icon to
the left of an extension in order to install it and follow the
instructions.


.. index:: Extensions; Installation
.. _extension-package-manager:
.. _extension-install:

Installing extensions
^^^^^^^^^^^^^^^^^^^^^

There are only two (possibly three) steps involved in using extensions with TYPO3:

#. You must *import* it.

   This simply means to copy the extensions files into the correct directory into.
   More commonly you import an extension directly from the online TYPO3 Extension Repository (TER)
   using the Extension Manager. When an extension is found located in one of the extension locations,
   it is  *available* to the system.

   The Extension Manager (EM) should take care of this process, including updates to
   newer versions if needed.

   Another convenient way to install extensions is offered by using Composer (https://getcomposer.org/)
   along with the TYPO3 Composer Repository (https://composer.typo3.org/). The TYPO3 Composer Repository
   includes all TYPO3 extensions that are uploaded to TER.

#. You must *load* it.

   In :ref:`legacy installations not based on Composer <t3start:legacyinstallation>`
   an extension is loaded only if it is listed in the
   :file:`PackageStates.php` file. Extensions are loaded in the order they appear in this list.
   In :ref:`Composer installations <t3start:install>`, all extensions in the
   :file:`composer.json` are considered as active.

   An enabled extension is always global to the TYPO3 Installation - you cannot disable
   an extension from being loaded in a particular branch of the page tree. The EM takes
   care of enabling extensions. It's highly recommended that the EM is doing
   this, because the EM will make sure the priorities, dependencies and
   conflicts are managed according to the extension characteristics,
   including clearing of the cache-files if any.

#. You *might* be able to configure it.

   Certain extensions may allow you to configure some settings. **ADMIN TOOLS > Settings > Extension configuration**
   provides an interface to configure extensions that provide configuration settings. Any
   settings - if present - configured for an extension are available as
   an array in the variable :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][extensionKey]` and
   thus reside in :file:`typo3conf/LocalConfiguration.php`.

Loaded extensions can be fetched with :php:`TYPO3\CMS\Core\Package\PackageManager::getActivePackages()`,
available in both frontend and backend of TYPO3.

This will return an array of :php:`TYPO3\CMS\Core\Package\Package` objects,
containing the data structure for each extension. These include the properties:

.. t3-field-list-table::
 :header-rows: 1

 - :Key,20: Key
   :Description,60: Description

 - :Key:
         packageKey
   :Description:
         The package key (or extension key).

 - :Key:
         packagePath
   :Description:
         Path to the package. Can be used to determine, if the extension is
         local or global scope.

 - :Key:
         composerManifest
   :Description:
         A large array containing the composer manifest. (the
         :file:`composer.json` of the extension, if it exists)

 - :Key:
         packageMetaData
   :Description:
         Properties of the :file:`ext_emconf.php` configuration of the
         extension, like its constraints (depends, suggests, conflicts),
         version, title, description, …,


The order of the registered extensions in this array corresponds to
the order they were listed in :file:`PackageStates.php` in legacy installations.

