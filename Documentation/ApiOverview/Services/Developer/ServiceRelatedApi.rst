.. include:: /Includes.rst.txt
.. index:: Services API; API
.. _services-developer-service-related-api:

============
Services API
============

This section describes the methods of the TYPO3 Core that are related
to the use of services.


.. index::
   Services API; ExtensionManagementUtility
   ExtensionManagementUtility; addService
   ExtensionManagementUtility; findService
.. _services-developer-service-related-api-extension-management-utility:

\\TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility
=======================================================

This extension management class contains three methods related to
services:

addService
  This method is used to register services with TYPO3 CMS. It checks for
  availability of a service with regards to OS dependency (if any) and
  fills the :code:`$GLOBALS['T3_SERVICES']` array, where information
  about all registered services is kept.

findService
  This method is used to find the appropriate service given a type and a
  subtype. It handles priority and quality rankings. It also checks for
  availability based on executables dependencies, if any.

  This method is normally called by
  :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService()`,
  so you shouldn't have to worry about calling it directly, but it can be useful to check if
  there's at least one service available.

deactivateService
  Marks a service as unavailable. It is called internally by
  :code:`addService()` and :code:`findService()` and should probably not
  be called directly unless you're sure of what you're doing.


.. index::
   Services API; GeneralUtility
   GeneralUtility; makeInstanceService
.. _services-developer-service-related-api-general-utility:

\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility
===========================================

This class contains a single method related to services, but the most
useful one, used to get an instance of a service.

makeInstanceService
  This method is used to get an instance of a service class of a given
  type and subtype. It calls on :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::findService()`
  to find the best possible service (in terms of priority and quality).

  As described above it keeps a registry of all instantiated service
  classes and uses existing instances whenever possible, in effect
  turning service classes into singletons.
