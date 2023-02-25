.. include:: /Includes.rst.txt
.. index:: TSconfig
.. _tsconfig:

========
TSconfig
========

"User TSconfig" and "page TSconfig" are very flexible concepts for
adding fine-grained configuration to the backend of TYPO3. It is a text-
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
modules related to pages (typically those in the :guilabel:`Web` main module)
can be configured for different behaviours in different branches of the tree.
It also includes configuration for the :ref:`FormEngine <FormEngine>` (Forms
to edit content in TYPO3) and the :ref:`DataHandler <datahandler-basics>`
(component that takes care of transforming and persisting data
structures) behaviours. Again, the point is that the configuration is
active for certain branches of the page tree which is very practical
in projects running many sites in the same page tree.


.. index:: pair: Page TSconfig; PHP

Get page TSConfig via PHP in an extension
-----------------------------------------

The page TSconfig for a specific page can be retrieved via the
:php:`\TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig()` method:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    // use TYPO3\CMS\Backend\Utility\BackendUtility;

    // Get the page TSconfig for the page with uid 42
    $thePageTsConfig = BackendUtility::getPagesTSconfig(42);
