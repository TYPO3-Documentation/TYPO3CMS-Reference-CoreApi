..  include:: /Includes.rst.txt
..  index::
    ! $GLOBALS
    Global variables
    see: Global variables; $GLOBALS
..  _globals-variables:

========
$GLOBALS
========

..  confval:: TYPO3_CONF_VARS
    :name: globals-typo3-conf-vars
    :Path: $GLOBALS
    :type: array
    :Defined: :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
    :Frontend: yes

    TYPO3 configuration array. Please refer to the chapter :ref:`typo3ConfVars`
    where each option is described in detail.

    Most values in this array can be accessed through the tool
    :guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`.


..  confval:: TCA
    :name: globals-tca
    :Path: $GLOBALS
    :type: array
    :Defined: :php:`\TYPO3\CMS\Core\Core\Bootstrap::loadExtensionTables()`
    :Frontend: Yes, partly

    See :ref:`TCA Reference <t3tca:start>`


..  confval:: T3_SERVICES
    :name: globals-t3-services
    :Path: $GLOBALS
    :type: array
    :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalVariables()`
    :Frontend: Yes

    Global registration of :ref:`services <services-introduction>`.


..  confval:: TSFE
    :name: globals-tsfe
    :Path: $GLOBALS
    :type: TypoScriptFrontendController
    :Defined: :file:`typo3/sysext/core/ext_tables.php`
    :Frontend: yes

    ..  deprecated:: 13.4
        The class :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`
        and its global instance :php:`$GLOBALS['TSFE']` have been marked as
        deprecated. The class will be removed with TYPO3 v14.

    Contains an instantiation of :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`.

    ..  attention::

         Directly access :php:`$GLOBALS['TSFE']` only as a last resort. It is
         strongly discouraged if not absolutely necessary.

    Provides some public properties and methods which can be used by extensions.
    The public properties can also be used in TypoScript via
    :ref:`TSFE <t3tsref:data-type-gettext-tsfe>`.

    More information is available in :ref:`tsfe`.

..  confval:: TYPO3_USER_SETTINGS
    :name: globals-typo3-user-settings
    :Path: $GLOBALS
    :type: array
    :Defined: :file:`typo3/sysext/setup/ext_tables.php`

    Defines the form in the :guilabel:`User Settings`.

..  confval:: PAGES_TYPES
    :name: globals-pages-types
    :Path: $GLOBALS
    :type: array
    :Defined: :file:`typo3/sysext/core/ext_tables.php`
    :Frontend: (occasionally)

    $GLOBALS['PAGES_TYPES'] defines the various types of pages (:sql:`doktype`)
    the system can handle and what restrictions may apply to them.

    Here you can define which tables are allowed on a certain page types
    (:sql:`doktype`).

    The default configuration applies if the page type is not defined otherwise.

..  confval:: BE_USER
    :name: globals-be-users
    :Path: $GLOBALS
    :type: :php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
    :Defined: :php:`\TYPO3\CMS\Core\Core\Bootstrap::initializeBackendUser()`
    :Frontend: (depends)

    Backend user object. See :ref:`be-user`.


..  confval:: EXEC_TIME
    :name: globals-exec-time
    :Path: $GLOBALS
    :type: int
    :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
    :Frontend: yes

    Is set to :php:`time()` so that the rest of the script has a common value
    for the script execution time.

    ..  note::

        Should not be used anymore, rather use the
        :ref:`DateTime Aspect <context_api_aspects_datetime>`.


..  confval:: SIM_EXEC_TIME
    :name: globals-sim-exec-time
    :Path: $GLOBALS
    :type: int
    :Defined: :php:`\TYPO3\CMS\Core\Core\SystemEnvironmentBuilder::initializeGlobalTimeTrackingVariables()`
    :Frontend: yes

    Is set to :php:`$GLOBALS['EXEC_TIME']` but can be altered later in the script if we
    want to simulate another execution-time when selecting from e.g. a
    database (used in the frontend for preview of future and past dates)

    ..  note::

        Should not be used anymore, rather use the
        :ref:`DateTime Aspect <context_api_aspects_datetime>`.

..  confval:: LANG
    :name: globals-lang
    :Path: $GLOBALS
    :type: :php:`\TYPO3\CMS\Core\Localization\LanguageService`
    :Defined: is initialized via :php:`\TYPO3\CMS\Core\Localization\LanguageServiceFactory`
    :Frontend: no

    ..  attention::

         It is discouraged to use this variable directly. The
         :php:`LanguageServiceFactory` should be used instead to retrieve the
         :php:`LanguageService`.

    The :php:`LanguageService` can be used to fetch
    translations.

    More information about retrieving the
    :php:`LanguageService` is available in
    :ref:`extension-localization-php`.


..  index:: $GLOBALS; Admin Tools
..  _globals-exploring:

Exploring global variables
==========================

Many of the global variables described above can be inspected using the module
:guilabel:`System > Configuration`.

..  warning::
    This module is always viewed in the BE context. Variables defined
    only in the FE context will not be visible there.

..  note::

    This module is purely a browser. It does not let you change
    values.

    It also lets you browse a number of other global arrays as well as values
    defined in other syntaxes including YAML.

..  include:: /Images/AutomaticScreenshots/BackendModules/GlobalValuesConfiguration.rst.txt
