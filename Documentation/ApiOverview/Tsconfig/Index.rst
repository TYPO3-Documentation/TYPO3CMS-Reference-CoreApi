.. include:: /Includes.rst.txt
.. index:: TSconfig
.. _tsconfig:

========
TSconfig
========

"User TSconfig" and "page TSconfig" are very flexible concepts for
adding fine-grained configuration to the backend of TYPO3 CMS. It is a text-
based configuration system where you assign values to keyword strings,
using the TypoScript syntax. The :ref:`TSconfig Reference <t3tsconfig:start>`
describes in detail how this works and what can be done with it.


.. index:: 
   User TSconfig
   TSconfig; User
.. _tsconfig-user:

User TSconfig
=============

User TSconfig can be set for each backend user and group.
Configuration set for backend groups is inherited by the user who is a
member of those groups. The available options typically cover user
settings like those found in the User Settings,
configuration of the "Admin Panel" (frontend), various backend tweaks
(lock user to IP, show shortcut frame, may user clear all cache?, etc.)
and backend module configuration
(overriding any configuration set for backend modules in Page
TSconfig).


.. index:: 
   Page TSconfig
   TSconfig; Page
.. _tsconfig-page:

Page TSconfig
=============

Page TSconfig can be set for each page in the page tree. Pages
inherit configuration from parent pages. The available
options typically cover backend module configuration, which means that
modules related to pages (typically those in the :guilabel:`WEB` main module)
can be configured for different behaviours in different branches of the tree.
It also includes configuration for the :ref:`FormEngine <FormEngine>` (Forms
to edit content in TYPO3) and the :ref:`DataHandler <datahandler-basics>`
(component that takes care of transforming and persisting data
structures) behaviours. Again, the point is that the configuration is
active for certain branches of the page tree which is very practical
in projects running many sites in the same page tree.


.. index:: pair: Page TSconfig; PHP

Get Page TSConfig via PHP in an extension
-----------------------------------------

When there is the necessity for fetching and loading PageTSconfig,
it is recommended for extension developers to make use of the PHP classes:

- :php:`TYPO3\CMS\Core\Configuration\Loader\PageTsConfigLoader`
- :php:`TYPO3\CMS\Core\Configuration\Parser\PageTsConfigParser`

Usage for fetching all available PageTS in one large string (not parsed yet)::

   $loader = GeneralUtility::makeInstance(PageTsConfigLoader::class);
   $tsConfigString = $loader->load($rootLine);

The string can then be put in proper TSconfig array syntax::

   $parser = GeneralUtility::makeInstance(
      PageTsConfigParser::class,
      $typoScriptParser,
      $hashCache
   );
   $pagesTSconfig = $parser->parse(
      $tsConfigString,
      $conditionMatcher
   );

