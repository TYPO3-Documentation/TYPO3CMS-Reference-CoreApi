

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


General functions
-----------------

There are a few core classes in TYPO3 which contain general
functionality. These classes are (typically) just a collection of
individual (static) functions you call non-instantiated, like [class
name]::[method name].

These are the most important classes to know about in TYPO3:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Class name
         Class name:
   
   Description
         Description:
   
   Usage
         Usage:


.. container:: table-row

   Class name
         t3lib\_DB
   
   Description
         **Database Abstraction Base API**
         
         All access to the database must go through this object. That is the
         first step towards DBAL compliance in your code. The class contains
         MySQL wrapper functions which can almost be search/replaced with your
         existing calls.
   
   Usage
         $GLOBALS['TYPO3\_DB'] in both frontend and backend


.. container:: table-row

   Class name
         t3lib\_cs
   
   Description
         **Character Set handling API**
         
         Contains native PHP code to handle character set conversion based on
         charset tables from Unicode.org. It is not certain that you will have
         to use this class directly but if you need to do charset conversion at
         any time you should use this class.
   
   Usage
         In backend, $GLOBALS['LANG']->csConvObj
         
         In frontend, $GLOBALS['TSFE']->csConvObj


.. container:: table-row

   Class name
         t3lib\_div
   
   Description
         **General Purpose Functions**
         
         A collection of multi-purpose PHP functions. Some are TYPO3 specific
         but not all.
   
   Usage
         t3lib\_div::
         
         (Non-instantiated!)


.. container:: table-row

   Class name
         t3lib\_BEfunc
   
   Description
         **Backend Specific Functions**
         
         Contains functions specific for the backend of TYPO3. You will
         typically need these when programming backend modules or other backend
         functionality.
         
         *This class is NOT available in the frontend!*
   
   Usage
         t3lib\_BEfunc::
         
         (Non-instantiated!)


.. container:: table-row

   Class name
         t3lib\_extMgm
   
   Description
         **Extension API functions**
         
         Functions for extensions to interface with the core system. Many of
         these functions are used in ext\_localconf.php and ext\_tables.php
         files of extensions. They let extensions register their features with
         the system.
         
         *See extension programming tutorials for more details.*
   
   Usage
         t3lib\_extMgm::
         
         (Non-instantiated!)


.. container:: table-row

   Class name
         t3lib\_iconWorks
   
   Description
         **Icons / Part of skinning API**
         
         Contains a few functions for getting the right icon for a database
         table record or the skinned version of any other icon.
         
         *This class is NOT available in the frontend!*
   
   Usage
         t3lib\_iconWorks::
         
         (Non-instantiated!)


.. container:: table-row

   Class name
         template
   
   Description
         **Backend Template Class**
         
         Contains functions for producing the layout of backend modules,
         setting up HTML headers, wrapping JavaScript sections correctly for
         XHTML etc.
   
   Usage
         $GLOBALS['TBE\_TEMPLATE'] or
         
         $GLOBALS['SOBE'] or
         
         $this->doc (inside of Script Classes)


.. ###### END~OF~TABLE ######

These classes are always included and available in the TYPO3 backend
and frontend (except "t3lib\_BEfunc" and "t3lib\_iconWorks").

The following pages will list methods from these classes in priority
of importance. You should at least acquaint yourself with all High-
priority functions since these are a part of the Coding Guidelines
requirements. In addition you might like to know about other functions
which are very often used since they might be very helpful to you
(they were to others!).


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   HighPriorityFunctions(cglRequirements)/Index
   FunctionsTypicallyUsedAndNiceToKnow/Index
   ProgrammingWithWorkspacesInMind/Index

