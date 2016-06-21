.. include:: ../../Includes.txt
.. include:: Images.txt


|img-5| Service-related API
^^^^^^^^^^^^^^^^^^^^^^^^^^^

This section describes the methods of the TYPO3 core that are related
to the use of services.


t3lib\_extMgm
"""""""""""""

This extension management class contains three methods related to
services:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         addService

   Description
         This method is used to register services with TYPO3. It checks for
         availability of service with regards to OS dependency (if any) and
         fills the :code:`$GLOBALS['T3\_SERVICES']` array, where information
         about all registered services is kept.


.. container:: table-row

   Method
         findService

   Description
         This method is used to find the appropriate service given a type and a
         subtype. It handles priority and quality rankings. It also checks for
         availability based on executables dependencies, if any.

         This method is normally called by
         :code:`t3lib\_div::makeInstanceService()` , so you shouldn't have to
         worry about calling it directly, but it can be useful to check if
         there's at least one service available.


.. container:: table-row

   Method
         deactivateService

   Description
         Marks a service as unavailable. It is called internally by
         :code:`addService()` and :code:`findService()` and should probably not
         be called directly unless you're sure of what you're doing.


.. ###### END~OF~TABLE ######


t3lib\_div
""""""""""

This class contains a single method related to services, but the most
useful one, used to get an instance of a service.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Method
         Method:

   Description
         Description:


.. container:: table-row

   Method
         makeInstanceService

   Description
         This method is used to get an instance of a service class of a given
         type and subtype. It calls on :code:`t3lib\_extMgm::findService()` to
         find the best possible service (in terms of priority and quality).

         As described above it keeps a registry of all instantiated service
         classes and uses existing instances whenever possible, in effect
         turning service classes into singletons.


.. ###### END~OF~TABLE ######

14


