.. include:: ../Includes.txt

.. _api-overview:

============
API Overview
============

The TYPO3 API is first and foremost documented inside the source
code. It would be impossible to maintain documentation at more than
one location given the fact that things change and sometimes fast.
This chapter describes the most important elements of the API.

.. note::

   The source is the documentation! (General wisdom)

This page lists all subchapters. You will also find them in the menu.

For more information about the order of these chapters, see the
note at the bottom.


**Table of Contents:**

.. toctree::
   :titlesonly:
   :maxdepth: 1

   DirectoryStructure/Index
   Namespaces/Index
   GlobalValues/Index

   Typo3CoreEngine/Index
   Database/Index
   FormEngine/Index

   BackendOverview/Index

   ConfigurationOverview/Index

   Autoloading/Index
   Bootstrapping/Index

   Fal/Index
   Context/Index
   Internationalization/Index
   SiteHandling/Index
   Workspaces/Index
   CachingFramework/Index
   LockingApi/Index
   Services/Index
   SystemRegistry/Index
   Mail/Index
   FlashMessages/Index
   Environment/Index
   Http/Index
   Icon/Index
   FeatureToggles/Index
   SoftReferences/Index
   SessionStorageFramework/Index
   Rte/Index
   PageTypes/Index
   ContextSensitiveHelp/Index

   SystemLog/Index
   Logging/Index
   ErrorAndExceptionHandling/Index

   Authentication/Index
   FormProtection/Index
   PasswordHashing/Index

   Categories/Index
   Collections/Index
   Enumerations/Index

   UpdateWizards/Index
   ExtensionScanner/Index

   Hooks/Index
   Xclasses/Index

   SeoOverview/Index

   Examples/Index


More subtopics in

* :ref:`backend`
* :ref:`configuration`
* :ref:`seo`
* :ref:`examples`


.. note::

   **About the order of the subchapters**

   The order is loosely based on the following:

   #. Basic topics like namespaces, directory names, global variables
   #. Central core functionality like TCE, database functions
   #. Several topics, more general or basic first, more relevant first

   In general, we try to group similar chapters together, e.g. :ref:`syslog`
   and :ref:`logging`.
