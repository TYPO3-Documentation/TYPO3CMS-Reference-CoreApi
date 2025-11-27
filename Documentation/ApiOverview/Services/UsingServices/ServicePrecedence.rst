.. include:: /Includes.rst.txt
.. index:: Services API; Service precedence
.. _services-using-services-precedence:

==================
Service precedence
==================

Several services may be declared to do the same job. What will
distinguish them is two intrinsic properties of services: priority and
quality. Priority tells TYPO3 CMS which service should be called first.
Normal priorities vary between 0 and 100, but can exceptionally be set
to higher values (no maximum). When two services of equal priority are
found, the system will use the service with the best quality.

The priority is used to define a call order for services. The default
priority is 50. The service with the highest priority is called first.
The priority of a service is defined by its developer, but may be
reconfigured (see :ref:`Configuration <services-configuration>`). It is thus very easy to add
a new service that comes before or after an existing service, or to
change the call order of already registered services.

The quality should be a measure of the worthiness of the job performed
by the service. There may be several services who can perform the same
task (e.g. extracting meta data from a file), but one may be able to
do that much better than the other because it is able to use a third-
party application. However if that third-party application is not
available, neither will this service. In this case TYPO3 CMS can fall back
on the lower quality service which will still be better than nothing.
Quality varies between 0-100.

More considerations about priority and quality can be found in the
:ref:`Developer's Guide <services-developer>`.

The "Installed Services" report of the :guilabel:`Administration > Reports` module
provides an overview of all installed services and their priority
and quality. It also shows whether a given service is available
or not.

.. include:: /Images/AutomaticScreenshots/Services/ServicesReport.rst.txt
