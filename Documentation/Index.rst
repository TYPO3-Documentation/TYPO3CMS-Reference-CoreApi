.. include:: /Includes.rst.txt

.. _start:
.. _api-overview:

===============
TYPO3 Explained
===============

.. rst-class:: horizbuttons-tip-m

- :ref:`Configuration <configuration>`
- :ref:`Doctrine-dbal <database>`
- :ref:`FAL <fal>`
- :ref:`Internationalization <internationalization>`
- :ref:`PSR-15 middlewares <request-handling>`
- :ref:`Routing <request-handling>`
- :ref:`Security <security>`
- :ref:`Sites <sitehandling>`


:Version:
      |release|

:Language:
      en

:Description:
      Main TYPO3 core documentation

:Keywords:
      forEditors, forBeginners, forDevelopers, forAdmins, forAdvanced, security

:Copyright:
      Since 2000

:Authors:
      Core Team, Documentation Team & community (see :ref:`credits`)

:Email:
      documentation@typo3.org

:License:
      Open Publication License available from `www.opencontent.org/openpub/
      <http://www.opencontent.org/openpub/>`_

:Shortcut:
      `t3coreapi` is the usual alias for :ref:`h2document:cheat-sheet-intersphinx`.

.. rst-class:: horizbuttons-tip-xxl

- :ref:`Sitemap`


The content of this document is related to TYPO3 CMS,
a GNU/GPL CMS/Framework available from `www.typo3.org
<https://typo3.org/>`_

**Official Documentation**

This document is included as part of the official TYPO3 documentation.

If you find an error or something is missing, please create an `issue
<https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/new>`__
or make the change yourself. You can find out more about how to do this in
:ref:`contribute`.

**Core Manual**

This document is a Core Manual. Core Manuals address the built in
functionality of TYPO3 CMS and are designed to provide the reader with in-
depth information. Each Core Manual addresses a particular process or
function and how it is implemented within the TYPO3 source code. These
may include information on available APIs, specific configuration
options, etc.

Core Manuals are written as reference manuals. The reader should rely
on the Table of Contents to identify what particular section will best
address the task at hand.

**Table of Contents**

..   Note for editors:
..     temporarily removed from menu:
..   Introduction/Index


.. toctree::
   :hidden:

   Quicklinks

.. toctree::
   :maxdepth: 1

   Introduction/Index

.. toctree::
   :maxdepth: 2

   ExtensionArchitecture/Index


.. toctree::
   :caption: TYPO3 A-Z
   :maxdepth: 2

   ApiOverview/Authentication/Index
   ApiOverview/Autoloading/Index
   ApiOverview/AccessControl/Index
   ApiOverview/BackendLayout/Index
   ApiOverview/BackendModules/Index
   ApiOverview/BackendRouting/Index
   ApiOverview/BackendUserObject/Index
   ApiOverview/Bootstrapping/Index
   ApiOverview/CachingFramework/Index
   CodingGuidelines/Index
   ApiOverview/Configuration/Index
   ApiOverview/GlobalValues/Constants/Index
   ApiOverview/ContentElements/Index
   ApiOverview/Context/Index
   ApiOverview/ContextSensitiveHelp/Index
   ApiOverview/CropVariants/Index
   ApiOverview/Database/Index
   ApiOverview/Deprecation/Index
   ApiOverview/Fal/Index
   ApiOverview/DirectoryStructure/Index
   ApiOverview/Enumerations/Index
   ApiOverview/Environment/Index
   ApiOverview/ErrorAndExceptionHandling/Index
   ApiOverview/Hooks/Index
   ApiOverview/ExtensionScanner/Index
   ApiOverview/FlashMessages/Index
   ApiOverview/FormEngine/Index
   ApiOverview/FormProtection/Index
   ApiOverview/Http/Index
   ApiOverview/Icon/Index
   ApiOverview/Internationalization/Index
   ApiOverview/JavaScript/Index
   ApiOverview/LinkBrowser/Index
   ApiOverview/LockingApi/Index
   ApiOverview/Logging/Index
   ApiOverview/Mail/Index
   ApiOverview/Namespaces/Index
   ApiOverview/PageTypes/Index
   ApiOverview/PasswordHashing/Index
   ApiOverview/RequestHandling/Index
   ApiOverview/Rte/Index
   ApiOverview/Routing/Index
   Security/Index
   ApiOverview/Seo/Index
   ApiOverview/Services/Index
   ApiOverview/SessionStorageFramework/Index
   ApiOverview/SiteHandling/Index
   ApiOverview/SoftReferences/Index
   ApiOverview/CommandControllers/Index
   ApiOverview/SymfonyExpressionLanguage/Index
   ApiOverview/Categories/Index
   ApiOverview/Collections/Index
   ApiOverview/SystemLog/Index
   ApiOverview/SystemRegistry/Index
   ApiOverview/Typo3CoreEngine/Index
   Testing/Index
   ApiOverview/UpdateWizards/Index
   ApiOverview/Workspaces/Index
   ApiOverview/Xclasses/Index

.. toctree::
   :maxdepth: 1

   Sitemap
   About
   Targets


.. todo:: ApiOverview/Examples/


.. the following have been moved in the menu:

.. to ApiOverview/ContentElements/Index
..    - ApiOverview/FlexForms/Index
..    - ApiOverview/BackendLayout/Index

.. to ApiOverview/Configuration/Index
..    - ApiOverview/Yaml/Index
..    - ApiOverview/TypoScriptSyntax/Index
..    - ApiOverview/Tsconfig/Index
..    - ApiOverview/GlobalValues/Index
..    - ApiOverview/FeatureToggles/Index
..    - ApiOverview/UserSettingsConfiguration/Index

.. to ApiOverview/Seo/Index
..    - ApiOverview/MetaTagApi/Index
..    - ApiOverview/XmlSitemap/Index
..    - ApiOverview/PageTitleApi/Index
