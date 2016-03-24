
.. include:: ../../Includes.txt


.. _namespaces:

Namespaces
==========

Since version 6.0, TYPO3 CMS uses PHP namespaces for all classes in the Core.

The general structure of namespaces is the following::

   \{VendorName}\{PackageName}\({CategoryName}\)*{ClassName}


For the Core, the *vendor name* is :code:`TYPO3\CMS` and the *package name* corresponds
to a system extension.

All classes must be located inside the :file:`Classes` folder at the root of the
(system) extension. The *category name* may contain several segments that correspond
to the path inside the :file:`Classes` folder.

Finally the *class name* is the same as the corresponding file name, without the
:file:`.php` extension.

"UpperCamelCase" is used for all segments.

.. tip::

   File :ref:`namespaces-migrations-ClassAliasMap` in the 6.2 core contains a full
   mapping of old to new class names, which will help you find your way around the new
   naming.


.. _namespaces-example:

Core example
------------

The good old :code:`t3lib_div` class has been renamed to::

   \TYPO3\CMS\Core\Utility\GeneralUtility

This means that the class is now found in the "core" system extension, in folder
:file:`Classes/Utility`, in a file named :file:`GeneralUtility.php`.


.. _namespaces-extensions:

Usage in extensions
-------------------

Extension developers are free to use their own vendor name. *Important:* It may consist of *one* segment only. Vendor names must start with an uppercase character and are usually written in UpperCamelCase style. In order to avoid problems with different filesystems, only the characters a-z, A-Z, 0-9 and the dash sign "-" are allowed for package names – don't use special characters::

   // good vendor name:
   \Webcompany

   // wrong vendor name:
   \Web\Company

.. attention::

   The vendor name :code:`TYPO3\CMS` is reserved and may not be used by extensions!

The package name corresponds to the extension key. Underscores in the extension
key are removed in the namespace and replaced by upper camel-case. So extension key::

   weird-name_examples

would become::

   Weird-nameExamples

in the namespace.

As mentioned above, all classes **must** be located in the :file:`Classes` folder inside
your extension. All sub-folders translate to a segment of the category name and the class
name is the file name without the :file:`.php` extension.

Looking at the "examples" extension, class::

   examples/Classes/Controller/DefaultController.php

corresponds to namespace::

   \Documentation\Examples\Controller\DefaultController

Inside the class, the namespace is declared as::

   <?php
   namespace Documentation\Examples\Controller;



.. _namespaces-extbase:

Namespaces in Extbase
---------------------

When registering components in Extbase, the vendor name must be used on top of the extension key.

For a backend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
       '<vendorName>.<ExtensionName>',
       // ...
   );


For a frontend module::

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       '<vendorName>.<ExtensionName>',
       // ...
   );


.. important::

   - Do not forget the dot after the vendor name.
   - Do not use dots inside the vendor name.


.. _namespaces-test:

Namespaces for test classes
---------------------------

As for ordinary classes, namespaces for test classes start with a vendor name
followed by the extension key.

All test classes reside in a :file:`Tests` folder and thus the third segment
of the namespace must be "Tests". Unit tests are located in a :file:`Unit` folder
which is the fourth segment of the namespace. Any further subfolders will
be subsequent segments.

So a test class in :file:`EXT:foo_bar_baz/Tests/Unit/Bla/` will have as namespace
:code:`\Vendor\FooBarBaz\Tests\Unit\Bla`.


.. _namespaces-instances:

Creating instances
------------------

When creating instances using :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`
the leading backslash must be omitted and all other backslashes escaped, even when using
single quotes. Thus the following code is correct::

   $contentObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);


There is no need to use :php:`require()` or :php:`include()` statements. All classes that follow
namespace conventions will automatically located and included by the autoloader.


.. _namespaces-references:

References
----------

For more information about PHP namespaces in general, you may want to refer to the
`PHP documentation <http://www.php.net/manual/en/language.namespaces.php>`_ and
in particular the `Namespaces FAQ <http://www.php.net/manual/en/language.namespaces.faq.php>`_.


.. _namespaces-migrations-ClassAliasMap:

ClassAliasMap.php
-----------------

*Tip:*
File :file:`typo3/sysext/core/Migrations/Code/ClassAliasMap.php` in the 6.2 core
contains a full mapping of old to new class names, which will help you find your
way around the new naming. I looks like this::

   <?php
   return array(
      't3lib_cli'                => 'TYPO3\\CMS\\Core\\Controller\\CommandLineController',
      'extDirect_DataProvider_ContextHelp'    => 'TYPO3\\CMS\\ContextHelp\\ExtDirect\\ContextHelpDataProvider',
      't3lib_userAuth'           => 'TYPO3\\CMS\\Core\\Authentication\\AbstractUserAuthentication',
      't3lib_beUserAuth'         => 'TYPO3\\CMS\\Core\\Authentication\\BackendUserAuthentication',
      't3lib_autoloader'         => 'TYPO3\\CMS\\Core\\Core\\ClassLoader',
      't3lib_cache_backend_AbstractBackend'   => 'TYPO3\\CMS\\Core\\Cache\\Backend\\AbstractBackend',
      't3lib_cache_backend_ApcBackend'        => 'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend',
      't3lib_cache_backend_Backend'           => 'TYPO3\\CMS\\Core\\Cache\\Backend\\BackendInterface',
      't3lib_cache_backend_FileBackend'       => 'TYPO3\\CMS\\Core\\Cache\\Backend\\FileBackend',
      't3lib_cache_backend_MemcachedBackend'  => 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend',
      't3lib_cache_backend_NullBackend'       => 'TYPO3\\CMS\\Core\\Cache\\Backend\\NullBackend',
      't3lib_cache_backend_PdoBackend'        => 'TYPO3\\CMS\\Core\\Cache\\Backend\\PdoBackend',
      't3lib_cache_backend_PhpCapableBackend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\PhpCapableBackendInterface',
      't3lib_cache_backend_RedisBackend'      => 'TYPO3\\CMS\\Core\\Cache\\Backend\\RedisBackend',
      't3lib_cache_backend_TransientMemoryBackend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\TransientMemoryBackend',
      't3lib_cache_backend_DbBackend'         => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
      't3lib_cache'              => 'TYPO3\\CMS\\Core\\Cache\\Cache',
      't3lib_cache_Factory'      => 'TYPO3\\CMS\\Core\\Cache\\CacheFactory',
      't3lib_cache_Manager'      => 'TYPO3\\CMS\\Core\\Cache\\CacheManager',
      't3lib_cache_Exception'    => 'TYPO3\\CMS\\Core\\Cache\\Exception',
      't3lib_cache_exception_ClassAlreadyLoaded' => 'TYPO3\\CMS\\Core\\Cache\\Exception\\ClassAlreadyLoadedException',
      't3lib_cache_exception_DuplicateIdentifier' => 'TYPO3\\CMS\\Core\\Cache\\Exception\\DuplicateIdentifierException',
      't3lib_cache_exception_InvalidBackend'  => 'TYPO3\\CMS\\Core\\Cache\\Exception\\InvalidBackendException',
      't3lib_cache_exception_InvalidCache'    => 'TYPO3\\CMS\\Core\\Cache\\Exception\\InvalidCacheException',
      't3lib_cache_exception_InvalidData'     => 'TYPO3\\CMS\\Core\\Cache\\Exception\\InvalidDataException',
      't3lib_cache_exception_NoSuchCache'     => 'TYPO3\\CMS\\Core\\Cache\\Exception\\NoSuchCacheException',
      't3lib_cache_frontend_AbstractFrontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\AbstractFrontend',
      't3lib_cache_frontend_Frontend'         => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\FrontendInterface',
      't3lib_cache_frontend_PhpFrontend'      => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\PhpFrontend',
      't3lib_cache_frontend_StringFrontend'   => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\StringFrontend',
      't3lib_cache_frontend_VariableFrontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
      't3lib_cs'                 => 'TYPO3\\CMS\\Core\\Charset\\CharsetConverter',
      't3lib_collection_AbstractRecordCollection' => 'TYPO3\\CMS\\Core\\Collection\\AbstractRecordCollection',
      't3lib_collection_Collection'           => 'TYPO3\\CMS\\Core\\Collection\\CollectionInterface',
      't3lib_collection_Editable'             => 'TYPO3\\CMS\\Core\\Collection\\EditableCollectionInterface',
      't3lib_collection_Nameable'             => 'TYPO3\\CMS\\Core\\Collection\\NameableCollectionInterface',
      't3lib_collection_Persistable'          => 'TYPO3\\CMS\\Core\\Collection\\PersistableCollectionInterface',
      't3lib_collection_RecordCollection'     => 'TYPO3\\CMS\\Core\\Collection\\RecordCollectionInterface',
      't3lib_collection_RecordCollectionRepository' => 'TYPO3\\CMS\\Core\\Collection\\RecordCollectionRepository',
      't3lib_collection_Sortable'             => 'TYPO3\\CMS\\Core\\Collection\\SortableCollectionInterface',
      't3lib_collection_StaticRecordCollection' => 'TYPO3\\CMS\\Core\\Collection\\StaticRecordCollection',
      't3lib_flexformtools'                   => 'TYPO3\\CMS\\Core\\Configuration\\FlexForm\\FlexFormTools',
      't3lib_matchCondition_abstract'         => 'TYPO3\\CMS\\Core\\Configuration\\TypoScript\\ConditionMatching\\AbstractConditionMatcher',
      't3lib_DB'                              => 'TYPO3\\CMS\\Core\\Database\\DatabaseConnection',
      't3lib_PdoHelper'                       => 'TYPO3\\CMS\\Core\\Database\\PdoHelper',
      't3lib_DB_postProcessQueryHook'         => 'TYPO3\\CMS\\Core\\Database\\PostProcessQueryHookInterface',
      't3lib_db_PreparedStatement'            => 'TYPO3\\CMS\\Core\\Database\\PreparedStatement',
      't3lib_DB_preProcessQueryHook'          => 'TYPO3\\CMS\\Core\\Database\\PreProcessQueryHookInterface',
      't3lib_queryGenerator'     => 'TYPO3\\CMS\\Core\\Database\\QueryGenerator',
      't3lib_fullsearch'         => 'TYPO3\\CMS\\Core\\Database\\QueryView',
      't3lib_refindex'           => 'TYPO3\\CMS\\Core\\Database\\ReferenceIndex',
      't3lib_loadDBGroup'        => 'TYPO3\\CMS\\Core\\Database\\RelationHandler',
      't3lib_softrefproc'        => 'TYPO3\\CMS\\Core\\Database\\SoftReferenceIndex',
      't3lib_sqlparser'          => 'TYPO3\\CMS\\Core\\Database\\SqlParser',
      't3lib_extTables_PostProcessingHook'      => 'TYPO3\\CMS\\Core\\Database\\TableConfigurationPostProcessingHookInterface',
      't3lib_TCEmain'            => 'TYPO3\\CMS\\Core\\DataHandling\\DataHandler',
      't3lib_TCEmain_checkModifyAccessListHook' => 'TYPO3\\CMS\\Core\\DataHandling\\DataHandlerCheckModifyAccessListHookInterface',
      't3lib_TCEmain_processUploadHook'         => 'TYPO3\\CMS\\Core\\DataHandling\\DataHandlerProcessUploadHookInterface',
      't3lib_browseLinksHook'    => 'TYPO3\\CMS\\Core\\ElementBrowser\\ElementBrowserHookInterface',
      't3lib_codec_JavaScriptEncoder' => 'TYPO3\\CMS\\Core\\Encoder\\JavaScriptEncoder',
      't3lib_error_AbstractExceptionHandler'    => 'TYPO3\\CMS\\Core\\Error\\AbstractExceptionHandler',
      't3lib_error_DebugExceptionHandler'       => 'TYPO3\\CMS\\Core\\Error\\DebugExceptionHandler',
      't3lib_error_ErrorHandler' => 'TYPO3\\CMS\\Core\\Error\\ErrorHandler',
      't3lib_error_ErrorHandlerInterface'       => 'TYPO3\\CMS\\Core\\Error\\ErrorHandlerInterface',
      't3lib_error_Exception'    => 'TYPO3\\CMS\\Core\\Error\\Exception',
      't3lib_error_ExceptionHandlerInterface'   => 'TYPO3\\CMS\\Core\\Error\\ExceptionHandlerInterface',
      't3lib_error_http_AbstractClientErrorException' => 'TYPO3\\CMS\\Core\\Error\\Http\\AbstractClientErrorException',
      't3lib_error_http_AbstractServerErrorException' => 'TYPO3\\CMS\\Core\\Error\\Http\\AbstractServerErrorException',
      't3lib_error_http_BadRequestException'    => 'TYPO3\\CMS\\Core\\Error\\Http\\BadRequestException',
      't3lib_error_http_ForbiddenException'     => 'TYPO3\\CMS\\Core\\Error\\Http\\ForbiddenException',
      't3lib_error_http_PageNotFoundException'  => 'TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException',
      't3lib_error_http_ServiceUnavailableException' => 'TYPO3\\CMS\\Core\\Error\\Http\\ServiceUnavailableException',
      't3lib_error_http_StatusException'        => 'TYPO3\\CMS\\Core\\Error\\Http\\StatusException',
      't3lib_error_http_UnauthorizedException'  => 'TYPO3\\CMS\\Core\\Error\\Http\\UnauthorizedException',
      't3lib_error_ProductionExceptionHandler'  => 'TYPO3\\CMS\\Core\\Error\\ProductionExceptionHandler',
      't3lib_exception'          => 'TYPO3\\CMS\\Core\\Exception',
      't3lib_extjs_ExtDirectApi' => 'TYPO3\\CMS\\Core\\ExtDirect\\ExtDirectApi',
      't3lib_extjs_ExtDirectDebug'     => 'TYPO3\\CMS\\Core\\ExtDirect\\ExtDirectDebug',
      't3lib_extjs_ExtDirectRouter'    => 'TYPO3\\CMS\\Core\\ExtDirect\\ExtDirectRouter',
      't3lib_extMgm'             => 'TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility',
      't3lib_formprotection_Abstract'  => 'TYPO3\\CMS\\Core\\FormProtection\\AbstractFormProtection',
      't3lib_formprotection_BackendFormProtection'     => 'TYPO3\\CMS\\Core\\FormProtection\\BackendFormProtection',
      't3lib_formprotection_DisabledFormProtection'    => 'TYPO3\\CMS\\Core\\FormProtection\\DisabledFormProtection',
      't3lib_formprotection_InvalidTokenException'     => 'TYPO3\\CMS\\Core\\FormProtection\\Exception',
      't3lib_formprotection_Factory' => 'TYPO3\\CMS\\Core\\FormProtection\\FormProtectionFactory',
      't3lib_formprotection_InstallToolFormProtection' => 'TYPO3\\CMS\\Core\\FormProtection\\InstallToolFormProtection',
      't3lib_frontendedit'       => 'TYPO3\\CMS\\Core\\FrontendEditing\\FrontendEditingController',
      't3lib_parsehtml'          => 'TYPO3\\CMS\\Core\\Html\\HtmlParser',
      't3lib_parsehtml_proc'     => 'TYPO3\\CMS\\Core\\Html\\RteHtmlParser',
      'TYPO3AJAX'                => 'TYPO3\\CMS\\Core\\Http\\AjaxRequestHandler',
      't3lib_http_Request'       => 'TYPO3\\CMS\\Core\\Http\\HttpRequest',
      't3lib_http_observer_Download' => 'TYPO3\\CMS\\Core\\Http\\Observer\\Download',
      't3lib_stdGraphic'         => 'TYPO3\\CMS\\Core\\Imaging\\GraphicalFunctions',
      't3lib_admin'              => 'TYPO3\\CMS\\Core\\Integrity\\DatabaseIntegrityCheck',
      't3lib_l10n_exception_FileNotFound'    => 'TYPO3\\CMS\\Core\\Localization\\Exception\\FileNotFoundException',
      't3lib_l10n_exception_InvalidParser'   => 'TYPO3\\CMS\\Core\\Localization\\Exception\\InvalidParserException',
      't3lib_l10n_exception_InvalidXmlFile'  => 'TYPO3\\CMS\\Core\\Localization\\Exception\\InvalidXmlFileException',
      't3lib_l10n_Store'         => 'TYPO3\\CMS\\Core\\Localization\\LanguageStore',
      't3lib_l10n_Locales'       => 'TYPO3\\CMS\\Core\\Localization\\Locales',
      't3lib_l10n_Factory'       => 'TYPO3\\CMS\\Core\\Localization\\LocalizationFactory',
      't3lib_l10n_parser_AbstractXml' => 'TYPO3\\CMS\\Core\\Localization\\Parser\\AbstractXmlParser',
      't3lib_l10n_parser'        => 'TYPO3\\CMS\\Core\\Localization\\Parser\\LocalizationParserInterface',
      't3lib_l10n_parser_Llphp'  => 'TYPO3\\CMS\\Core\\Localization\\Parser\\LocallangArrayParser',
      't3lib_l10n_parser_Llxml'  => 'TYPO3\\CMS\\Core\\Localization\\Parser\\LocallangXmlParser',
      't3lib_l10n_parser_Xliff'  => 'TYPO3\\CMS\\Core\\Localization\\Parser\\XliffParser',
      't3lib_lock'               => 'TYPO3\\CMS\\Core\\Locking\\Locker',
      't3lib_mail_Mailer'        => 'TYPO3\\CMS\\Core\\Mail\\Mailer',
      't3lib_mail_MailerAdapter' => 'TYPO3\\CMS\\Core\\Mail\\MailerAdapterInterface',
      't3lib_mail_Message'       => 'TYPO3\\CMS\\Core\\Mail\\MailMessage',
      't3lib_mail_MboxTransport' => 'TYPO3\\CMS\\Core\\Mail\\MboxTransport',
      't3lib_mail_Rfc822AddressesParser' => 'TYPO3\\CMS\\Core\\Mail\\Rfc822AddressesParser',
      't3lib_mail_SwiftMailerAdapter' => 'TYPO3\\CMS\\Core\\Mail\\SwiftMailerAdapter',
      't3lib_message_AbstractMessage' => 'TYPO3\\CMS\\Core\\Messaging\\AbstractMessage',
      't3lib_message_AbstractStandaloneMessage' => 'TYPO3\\CMS\\Core\\Messaging\\AbstractStandaloneMessage',
      't3lib_message_ErrorpageMessage' => 'TYPO3\\CMS\\Core\\Messaging\\ErrorpageMessage',
      't3lib_FlashMessage'       => 'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
      't3lib_FlashMessageQueue'  => 'TYPO3\\CMS\\Core\\Messaging\\FlashMessageQueue',
      't3lib_PageRenderer'       => 'TYPO3\\CMS\\Core\\Page\\PageRenderer',
      't3lib_Registry'           => 'TYPO3\\CMS\\Core\\Registry',
      't3lib_Compressor'         => 'TYPO3\\CMS\\Core\\Resource\\ResourceCompressor',
      't3lib_svbase'             => 'TYPO3\\CMS\\Core\\Service\\AbstractService',
      't3lib_Singleton'          => 'TYPO3\\CMS\\Core\\SingletonInterface',
      't3lib_TimeTrackNull'      => 'TYPO3\\CMS\\Core\\TimeTracker\\NullTimeTracker',
      't3lib_timeTrack'          => 'TYPO3\\CMS\\Core\\TimeTracker\\TimeTracker',
      't3lib_tree_Tca_AbstractTcaTreeDataProvider' => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\AbstractTableConfigurationTreeDataProvider',
      't3lib_tree_Tca_DatabaseTreeDataProvider' => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\DatabaseTreeDataProvider',
      't3lib_tree_Tca_DatabaseNode'             => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\DatabaseTreeNode',
      't3lib_tree_Tca_ExtJsArrayRenderer'       => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\ExtJsArrayTreeRenderer',
      't3lib_tree_Tca_TcaTree'   => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\TableConfigurationTree',
      't3lib_tree_Tca_DataProviderFactory'      => 'TYPO3\\CMS\\Core\\Tree\\TableConfiguration\\TreeDataProviderFactory',
      't3lib_tsStyleConfig'      => 'TYPO3\\CMS\\Core\\TypoScript\\ConfigurationForm',
      't3lib_tsparser_ext'       => 'TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService',
      't3lib_TSparser'           => 'TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser',
      't3lib_TStemplate'         => 'TYPO3\\CMS\\Core\\TypoScript\\TemplateService',
      't3lib_utility_Array'      => 'TYPO3\\CMS\\Core\\Utility\\ArrayUtility',
      't3lib_utility_Client'     => 'TYPO3\\CMS\\Core\\Utility\\ClientUtility',
      't3lib_exec'               => 'TYPO3\\CMS\\Core\\Utility\\CommandUtility',
      't3lib_utility_Command'    => 'TYPO3\\CMS\\Core\\Utility\\CommandUtility',
      't3lib_utility_Debug'      => 'TYPO3\\CMS\\Core\\Utility\\DebugUtility',
      't3lib_diff'               => 'TYPO3\\CMS\\Core\\Utility\\DiffUtility',
      't3lib_basicFileFunctions' => 'TYPO3\\CMS\\Core\\Utility\\File\\BasicFileUtility',
      't3lib_extFileFunctions'   => 'TYPO3\\CMS\\Core\\Utility\\File\\ExtendedFileUtility',
      't3lib_extFileFunctions_processDataHook' => 'TYPO3\\CMS\\Core\\Utility\\File\\ExtendedFileUtilityProcessDataHookInterface',
      't3lib_div'                => 'TYPO3\\CMS\\Core\\Utility\\GeneralUtility',
      't3lib_utility_Http'       => 'TYPO3\\CMS\\Core\\Utility\\HttpUtility',
      't3lib_utility_Mail'       => 'TYPO3\\CMS\\Core\\Utility\\MailUtility',
      't3lib_utility_Math'       => 'TYPO3\\CMS\\Core\\Utility\\MathUtility',
      't3lib_utility_Monitor'    => 'TYPO3\\CMS\\Core\\Utility\\MonitorUtility',
      't3lib_utility_Path'       => 'TYPO3\\CMS\\Core\\Utility\\PathUtility',
      't3lib_utility_PhpOptions' => 'TYPO3\\CMS\\Core\\Utility\\PhpOptionsUtility',
      't3lib_utility_VersionNumber'    => 'TYPO3\\CMS\\Core\\Utility\\VersionNumberUtility',
      // Establish an alias for Flow/Package interoperability
      'TYPO3\\Flow\\Core\\ClassLoader' => 'TYPO3\\CMS\\Core\\Core\\ClassLoader',
   );

   //
