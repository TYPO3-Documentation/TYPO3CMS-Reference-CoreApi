.. include:: /Includes.rst.txt
.. _services:
.. _services-introduction:
.. _services-introduction-good-reasons:
.. _services-introduction-good-reasons-implementation:
.. _services-introduction-good-reasons-extensibility:
.. _services-using-services:
.. _services-using-services-service-chain:
.. _services-using-services-precedence:
.. _services-using-services-simple:
.. _services-using-services-subtypes:
.. _services-configuration:
.. _services-configuration-registration-changes:
.. _services-configuration-service-configuration:
.. _services-configuration-service-type-configuration:
.. _services-developer:
.. _services-developer-implementing:
.. _services-developer-implementing-registration:
.. _services-developer-implementing-php:
.. _services-developer-new-service-type:
.. _services-developer-service-api:
.. _services-developer-service-api-implementation:
.. _services-developer-service-api-getters:
.. _services-developer-service-api-error:
.. _services-developer-service-api-general:
.. _services-developer-service-api-io-tools:
.. _services-developer-service-api-io-input-output:
.. _services-developer-service-related-api:
.. _services-developer-service-related-api-extension-management-utility:
.. _services-developer-service-related-api-general-utility:


========================
Deprecated: Services API
========================

.. deprecated:: 11.3
   The AbstractService class and therefore the Service API has been deprecated
   with TYPO3 11.3.

Migration
=========

Remove any usage of this class in your extension. In case you currently
extend :php:`AbstractService` for use in an authentication service, which
might be the most common scenario, you have to change your service class
to extend from :php:`AbstractAuthenticationService` instead.

In case you currently extend :php:`AbstractService` for another kind of
service, which is rather unlikely, you have to implement the necessary
methods in your service class yourself.

However, even better would be to completely migrate away from the Service API
(look for :php:`GeneralUtility::makeInstanceService()`),
since the Core will deprecate the related methods as well.
