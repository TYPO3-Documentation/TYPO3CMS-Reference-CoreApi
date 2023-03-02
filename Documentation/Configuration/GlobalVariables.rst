.. include:: /Includes.rst.txt
.. index::
   ! $GLOBALS
   Global variables
   see: Global variables; $GLOBALS
.. _globals-variables:

========
$GLOBALS
========

.. versionchanged:: 12.0
   The global variable :php:`$GLOBALS['TBE_MODULES']` was removed. Setting it
   has no effect anymore. Use the
   :ref:`ModuleProvider <backend-modules-api>` instead.

.. confval:: LANG

   :Path: $GLOBALS
   :type: :php:`\TYPO3\CMS\Core\Localization\LanguageService`
   :Defined: is initialized by LanguageServiceFactory
   :Frontend: no

   The global array :php:`$GLOBALS['LANG']` is initialized by the Core.
   It can be used to fetch translations.
   It contains an instantiation of the
   :php:`\TYPO3\CMS\Core\Localization\LanguageService`.

   .. attention::

        The global array :php:`$GLOBALS['LANG']` is not available in all contexts,
        in particular the contexts where a logged in backend user is not
        available.

   More information about instantiating and using :php:`$GLOBALS['LANG']` is
   available in :ref:`extension-localization-php`.


.. confval:: TYPO3_CONF_VARS

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
   :Frontend: yes

   TYPO3 configuration array. Please refer to the chapter :ref:`typo3ConfVars`
   where each option is described in detail.

   Most values in this array can be accessed through the tool
   :guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`.


.. confval:: TCA

   :Path: $GLOBALS
   :type: array
   :Defined: :php:`\TYPO3\CMS\Core\Core\Bootstrap::loadExtensionTables()`
   :Frontend: Yes, partly

   See :ref:`TCA Reference <t3tca:start>`


.. confval:: T3_SERVICES

   :Path: $GLOBALS
   :type: array
   :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalVariables()`
   :Frontend: Yes

   Global registration of :ref:`services <services-introduction>`.


.. confval:: TBE_STYLES

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: (occasionally)

   Contains information related to BE skinning.

.. confval:: TSFE

   :Path: $GLOBALS
   :type: TypoScriptFrontendController
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: yes

   Contains an instantiation of :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`.

   .. attention::

        Directly access :php:`$GLOBALS['TSFE']` only as a last resort. It is
        strongly discouraged if not absolutely necessary.

   Provides some public properties and methods which can be used by extensions.
   The public properties can also be used in TypoScript via
   :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`.

   More information is available in :ref:`tsfe`.

.. confval:: TYPO3_USER_SETTINGS

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/setup/ext_tables.php`

   Defines the form in the :guilabel:`User Settings`.

.. confval:: PAGES_TYPES

   :Path: $GLOBALS
   :type: array
   :Defined: :file:`typo3/sysext/core/ext_tables.php`
   :Frontend: (occasionally)

   $GLOBALS['PAGES_TYPES'] defines the various types of pages (:sql:`doktype`)
   the system can handle and what restrictions may apply to them.

   Here you can define which tables are allowed on a certain page types
   (:sql:`doktype`).

   The default configuration applies if the page type is not defined otherwise.

.. confval:: BE_USER

   :Path: $GLOBALS
   :type: :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
   :Defined: :php:`\TYPO3\CMS\Core\Core\Bootstrap::initializeBackendUser()`
   :Frontend: (depends)

   Backend user object. See :ref:`be-user`.


.. confval:: EXEC_TIME

   :Path: $GLOBALS
   :type: int
   :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   :Frontend: yes

   Is set to :php:`time()` so that the rest of the script has a common value
   for the script execution time.

   .. note::

      Should not be used anymore, rather use the
      :ref:`DateTime Aspect <context_api_aspects_datetime>`.


.. confval:: SIM_EXEC_TIME

   :Path: $GLOBALS
   :type: int
   :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
   :Frontend: yes

   Is set to :php:`$GLOBALS['EXEC_TIME']` but can be altered later in the script if we
   want to simulate another execution-time when selecting from e.g. a
   database (used in the frontend for preview of future and past dates)

   .. note::

      Should not be used anymore, rather use the
      :ref:`DateTime Aspect <context_api_aspects_datetime>`.

.. confval:: LANG

   :Path: $GLOBALS
   :type: :php:`\TYPO3\CMS\Core\Localization\LanguageService`
   :Defined: is initialized via :php:`\TYPO3\CMS\Core\Localization\LanguageServiceFactory`
   :Frontend: no

   .. attention::

        It is discouraged to use this variable directly. The
        :php:`LanguageServiceFactory` should be used instead to retrieve the
        :php:`LanguageService`.

   The :php:`LanguageService` can be used to fetch
   translations.

   More information about retrieving the
   :php:`LanguageService` is available in
   :ref:`extension-localization-php`.


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
   defined in other syntaxes including YAML.

.. include:: /Images/AutomaticScreenshots/BackendModules/GlobalValuesConfiguration.rst.txt
