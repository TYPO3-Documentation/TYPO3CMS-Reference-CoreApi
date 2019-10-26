.. include:: Includes.txt

.. _start:
.. _api-overview:

===============
TYPO3 Core APIs
===============

.. rst-class:: horizbuttons-tip-m

- :ref:`Configuration <configuration>`
- :ref:`Doctrine-dbal <database>`
- :ref:`Internationalization <internationalization>`


:Version:
      |release|

:Language:
      en

:Description:
      Reference to the Core APIs of TYPO3, e.g. main classes, Extension API, RTE API.

:Keywords:
      tsref, typoscript, reference, forDevelopers, forAdvanced

:Copyright:
      Since 2000

:Author:
      Documentation Team

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
It has been approved by the TYPO3 Documentation Team following a peer-
review process. The reader should expect the information in this
document to be accurate - please report discrepancies to the
Documentation Team (documentation@typo3.org). Official documents are
kept up-to-date to the best of the Documentation Team's abilities.


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

   ApiOverview/Autoloading/Index
   ApiOverview/BackendUserObject/Index
   ApiOverview/Bootstrapping/Index
   ApiOverview/CachingFramework/Index
   CodingGuidelines/Index

.. toctree::
   :maxdepth: 3

   ApiOverview/Configuration/Index

.. toctree::
   :maxdepth: 2

   ApiOverview/ContentElements/Index
   ApiOverview/Database/Index
   DataFormats/Index
   ApiOverview/Enumerations/Index
   ApiOverview/ErrorAndExceptionHandling/Index
   ApiOverview/Hooks/Index
   ApiOverview/FlashMessages/Index
   ApiOverview/FormEngine/Index
   ApiOverview/FormProtection/Index
   ApiOverview/Http/Index
   ApiOverview/Icon/Index
   Internationalization/Index
   ApiOverview/JavaScript/Index
   ApiOverview/LinkBrowser/Index
   ApiOverview/Logging/Index
   ApiOverview/Mail/Index
   ApiOverview/Namespaces/Index
   PageTypes/Index
   Rte/Index
   ApiOverview/SessionStorageFramework/Index
   ApiOverview/SoftReferences/Index
   ApiOverview/Categories/Index
   ApiOverview/Collections/Index
   ApiOverview/SystemLog/Index
   ApiOverview/SystemRegistry/Index
   ApiOverview/Typo3CoreEngine/Index
   ApiOverview/UpdateWizards/Index
   ApiOverview/Workspaces/Index
   ApiOverview/Xclasses/Index

.. toctree::
   :maxdepth: 1
   :caption: meta


   Sitemap
   About
   Targets


.. todo:: ApiOverview/Examples/ : currently not in menu, merge into ...?

.. todo:: References contains links to services etc .., can be removed


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
..    - UserSettingsConfiguration/Index

.. to ApiOverview/Seo/Index
..    - ApiOverview/MetaTagApi/Index
..    - ApiOverview/XmlSitemap/Index
..    - ApiOverview/PageTitleApi/Index
