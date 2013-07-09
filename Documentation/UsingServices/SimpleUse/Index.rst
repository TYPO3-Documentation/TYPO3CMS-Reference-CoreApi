.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Simple use
^^^^^^^^^^

The most basic use is when you just want an object that handles a
given service type::

   if (is_object($serviceObj = t3lib_div::makeInstanceService('textLang'))) {
     $language = $serviceObj->guessLanguage($text);
   }

In this example a service of type 'textLang' is requested. If such a
service is indeed available an object will be returned. Then the
service type 'textLang' has a function guessLanguage() which is used.

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
one. More details in "Service API" below.

If several services are available, the one with the highest priority
(or quality if priority are equals) will be used.

It's also possible to get an instance of a specific service by
requesting its key directly instead of just requesting a service type.
The call would then look something like::

   if (is_object($serviceObj = t3lib_div::makeInstanceService('tx_myservice_sv1'))) {
     // Do something with the object
     ...
   }

