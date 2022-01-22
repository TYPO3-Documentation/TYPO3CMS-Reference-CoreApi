.. include:: /Includes.rst.txt
.. index::
   ! $GLOBALS
   Global variables
   see: Global variables; $GLOBALS
.. _globals-variables:

========
$GLOBALS
========

.. note::

   To make the table below a bit more compact, namespaces were left out. Here
   are the fully qualified class names referred to below:

   - "SystemEnvironmentBuilder" = :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder`
   - "Bootstrap" = :php:`\TYPO3\CMS\Core\Core\Bootstrap`
   - "PackageManager" = :php:`\TYPO3\CMS\Core\Package\PackageManager`


.. confval:: TYPO3_CONF_VARS

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
   :Frontend: yes

   TYPO3 configuration array. Please refer to the chapter :ref:`typo3ConfVars`
   where each option is described in detail.

   Most values in this array can be accessed through the tool
   :guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`.


.. confval:: EXEC_TIME

   :Path: $GLOBALS
   :type: int
   :Defined: :php:`SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   :Frontend: yes

   Is set to :php:`time()` so that the rest of the script has a common value
   for the script execution time.

   .. note::

      Should not be used anymore, rather use the
      :ref:`DateTime Aspect <context_api_aspects_datetime>`.


.. confval:: SIM_EXEC_TIME

   :Path: $GLOBALS
   :type: int
   :Defined: :php:`SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   :Frontend: yes

   Is set to :php:`$GLOBALS['EXEC_TIME']` but can be altered later in the script if we
   want to simulate another execution-time when selecting from e.g. a
   database (used in the frontend for preview of future and past dates)

   .. note::

      Should not be used anymore, rather use the
      :ref:`DateTime Aspect <context_api_aspects_datetime>`.


.. confval:: PAGES_TYPES

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: (occasionally)


.. confval:: TCA

   :Path: $GLOBALS
   :type: array
   :Defined: :php:`Bootstrap::loadExtensionTables()`
   :Frontend: Yes, partly

   See :ref:`TCA Reference<t3tca:start>`


.. confval:: TBE_MODULES

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: (occasionally)

   The backend main/sub-module structure. See section elsewhere plus
   source code of class :php:`\TYPO3\CMS\Backend\Module\ModuleLoader` which also includes some
   examples.

.. confval:: TBE_STYLES

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: (occasionally)

   Contains information related to BE skinning.


.. confval:: T3_SERVICES

   :Path: $GLOBALS
   :type: array
   :Defined: :php:`SystemEnvironmentBuilder::initializeGlobalVariables()`
   :Frontend: Yes

   Global registration of :ref:`services <services-introduction>`.



.. confval:: BE_USER

   :Path: $GLOBALS
   :type: TYPO3\CMS\Core\Authentication\BackendUserAuthentication
   :Defined: :php:`Bootstrap::initializeBackendUser()`
   :Frontend: (depends)

   Backend user object. See :ref:`be-user`.


.. confval:: TBE_MODULES_EXT

   :Path: $GLOBALS
   :type: array
   :Defined: [In :file:`ext_tables.php` files of extensions]
   :Frontend: (occasionally)

   Used to store information about modules from extensions that should be
   included in "function menus" of real modules. See the Extension API
   for details.

   This variable *may* be set in a script prior to
   the bootstrap process so it is optional.

.. confval:: TCA_DESCR

   :Path: $GLOBALS
   :type: array
   :Defined: [:file:`tables.php` files]
   :Frontend: No

   Can be set to contain file references to local lang files containing
   :php:`TCA_DESCR` labels. See section about :ref:`Context Sensitive Help <csh>`.

   This variable *may* be set in a script prior to
   the bootstrap process so it is optional.

.. index:: $GLOBALS; Admin Tools
.. _globals-exploring:

Exploring global variables
==========================

Many of the global variables described above can be inspected using the module
:guilabel:`System > Configuration`.

.. warning::
   This module is always viewed in the BE context. Variables defined
   only in the FE context will not be visible there.

.. note::

   This module is purely a browser. It does not let you change
   values.

   It also lets you browse a number of other global arrays as well as values
   defined in other syntax like YAML.

.. include:: /Images/AutomaticScreenshots/BackendModules/GlobalValuesConfiguration.rst.txt
