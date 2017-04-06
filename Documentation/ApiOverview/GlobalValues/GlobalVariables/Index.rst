.. include:: ../../../Includes.txt






.. _globals-variables:

Global variables
^^^^^^^^^^^^^^^^

.. note::
   Variables in italics *may* be set in a script prior to
   the bootstrap process so they are optional.

.. note::

   To make the table below a bit more compact, namespaces were left out. Here
   are the fully qualified class names referred to below:

   - "SystemEnvironmentBuilder" = :code:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
   - "Bootstrap" = :code:`\TYPO3\CMS\Core\Core\Bootstrap`
   - "PackageManager" = :code:`\TYPO3\CMS\Core\Package\PackageManager`


.. t3-field-list-table::
 :header-rows: 1

 - :Variable,20: Global variable
   :Defined,20: Defined in
   :Description,50: Description
   :FE,10: Avail. in FE


 - :Variable:
         $TYPO3\_CONF\_VARS
   :Defined:
         :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
   :Description:
         TYPO3 configuration array. Please refer to file typo3/sysext/core/Configuration/DefaultConfigurationDescription.php
         where each option is described in detail as comments. The same comments are also available
         in the Install Tool under the menu "All Configuration".
   :FE:
         Yes


 - :Variable:
         $TYPO3\_LOADED\_EXT
   :Defined:
         PackageManager::loadPackageManagerStatesFromCache()
         PackageManager::initializeCompatibilityLoadedExtArray()
   :Description:
         Array with all loaded extensions listed with a set of paths. You can
         check if an extension is loaded by the function
         :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($key)` where :code:`$key` is the extension key.
   :FE:
         Yes


 - :Variable:
         $TYPO3\_DB
   :Defined:
         Bootstrap::initializeTypo3DbGlobal()
   :Description:
         An instance of the TYPO3 DB wrapper class, :code:`\TYPO3\CMS\Core\Database\DatabaseConnection`.
         Formerly (before 8.2) this object had to be used for all interaction with the database.

         .. attention::

            You should NOT use this anymore. Use Doctrine instead!

   :FE:
         Yes


 - :Variable:
         $EXEC\_TIME
   :Defined:
         SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()
   :Description:
         Is set to :code:`time()` so that the rest of the script has a common value
         for the script execution time.
   :FE:
         YES


 - :Variable:
         $SIM\_EXEC\_TIME
   :Defined:
         SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()
   :Description:
         Is set to :code:`$EXEC_TIME` but can be altered later in the script if we
         want to simulate another execution-time when selecting from e.g. a
         database (used in the frontend for preview of future and past dates)
   :FE:
         Yes


 - :Variable:
         $PARSETIME\_START
   :Defined:
         SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()
   :Description:
         Time in milliseconds right after inclusion of the configuration.
   :FE:
         No


 - :Variable:
         $PAGES\_TYPES
   :Defined:
         typo3/sysext/core/ext_tables.php
   :Description:
         See :ref:`page-types`
   :FE:
         (occasionally)


 - :Variable:
         $TCA
   :Defined:
         Bootstrap::loadExtensionTables()
   :Description:
         See :ref:`TCA Reference<t3tca:start>`
   :FE:
         Yes, partly


 - :Variable:
         $TBE\_MODULES
   :Defined:
         typo3/sysext/core/ext_tables.php
   :Description:
         The backend main/sub-module structure. See section elsewhere plus
         source code of class :code:`\TYPO3\CMS\Backend\Module\ModuleLoader` which also includes some
         examples.
   :FE:
         (occasionally)


 - :Variable:
         $TBE\_STYLES
   :Defined:
         typo3/sysext/core/ext_tables.php
   :Description:
         Contains information related to BE skinning. (will be removed on CMS 9)
   :FE:
         (occasionally)


 - :Variable:
         $T3\_SERVICES
   :Defined:
         SystemEnvironmentBuilder::initializeGlobalVariables()
   :Description:
         Global registration of services.
   :FE:
         Yes


 - :Variable:
         $T3\_VAR
   :Defined:
         SystemEnvironmentBuilder::initializeGlobalVariables()
   :Description:
         Space for various internal global data storage in TYPO3. Each key in
         this array is a data space for an application. Keys currently defined
         for use is:

         ['callUserFunction'] + ['callUserFunction\_classPool']: Used by
         :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction` to store singleton objects.

         ['getUserObj'] : Used by :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj` to store singleton
         objects.

         ['RTEobj'] : Used to hold the current RTE object if any. See
         :code:`\TYPO3\CMS\Backend\Utility\BackendUtility`.

         ['ext'][ *extension-key* ] : Free space for extensions.
   :FE:
         Yes



 - :Variable:
         $BE\_USER
   :Defined:
         Bootstrap::initializeBackendUser()
   :Description:
         Backend user object. See :ref:`be-user`.
   :FE:
         (depends)


 - :Variable:
         *$TBE\_MODULES\_EXT*
   :Defined:
         [In ext\_tables.php files of extensions]
   :Description:
         Used to store information about modules from extensions that should be
         included in "function menus" of real modules. See the Extension API
         for details.
   :FE:
         (occasionally)


 - :Variable:
         *$TCA\_DESCR*
   :Defined:
         [tables.php files]
   :Description:
         Can be set to contain file references to local lang files containing
         :code:`TCA_DESCR` labels. See section about Context Sensitive Help.
   :FE:
         No


.. _globals-exploring:

Exploring global variables
""""""""""""""""""""""""""

Many of the global variables described above can be inspected using the
Admin Tools > Configuration module.

.. warning::
   This module is always viewed in the BE context. Variables defined
   only in the FE context will not be visible there.

.. figure:: ../../../Images/ConfigurationModule.png
   :alt: The Configuration module in Admin Tools

   Viewing the :code:`$TCA` array using the Admin Tools > Configuration module

