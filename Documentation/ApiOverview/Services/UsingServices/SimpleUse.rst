.. include:: /Includes.rst.txt


.. _services-using-services-simple:

==========
Simple Use
==========

The most basic use is when you just want an object that handles a
given service type:

.. code-block:: php

	if (is_object($serviceObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('textLang'))) {
		$language = $serviceObject->guessLanguage($text);
	}

In this example a service of type "textLang" is requested. If such a
service is indeed available an object will be returned. Then the
:code:`guessLanguage()` - which would be part of the "textLang" service
type public API - is called.

There's no certainty that an object will be returned, for a number of
reasons:

- there might be no service of the requested type installed

- the service deactivated itself during registration because it
  recognized it can't run on your platform

- the service was deactivated by the system because of certain checks

- during initialization the service checked that it can't run and
  deactivated itself

Note that when a service is requested, the instance created is stored
in a global registry. If that service is requested again during the
same code run, the stored instance will be returned instead of a new
one. More details in :ref:`Service API <services-developer-service-api>`.

If several services are available, the one with the highest priority
(or quality if priority are equals) will be used.
