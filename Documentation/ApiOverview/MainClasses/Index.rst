.. include:: /Includes.rst.txt






.. _main-classes:

Main classes and methods
------------------------

There are a number of core classes in TYPO3 which contain general
functionality and are available most of or even all the time.
These classes are either static or exist as singletons stored in
global variables.

This table lists some of the most important classes to know about in TYPO3:

.. t3-field-list-table::
 :header-rows: 1

 - :Class,20: Class name
   :Description,50: Description
   :Usage,30: Usage

 - :Class: \\TYPO3\\CMS\\Core\\Database\\DatabaseConnection
   :Description:
         **Database Abstraction Base API**

         All access to the database must go through this object. That is the
         first step towards DBAL compliance in your code. The class contains
         MySQL wrapper functions which can almost be search/replaced with your
         existing calls.
   :Usage:
         Available as :code:`$GLOBALS['TYPO3_DB']` in both frontend and backend


 - :Class: \\TYPO3\\CMS\\Core\\Charset\\CharsetConverter
   :Description:
         **Character Set handling API**

         Contains native PHP code to handle character set conversion based on
         charset tables from Unicode.org. You should use this class whenever
         you need to handle character set conversion or to perform multibyte-safe
         string operations (like getting the length, cropping, etc.).
   :Usage:
         In the backend, available as $GLOBALS['LANG']->csConvObj

         In the frontend, available as $GLOBALS['TSFE']->csConvObj


 - :Class: \\TYPO3\\CMS\\Core\\Utility\\GeneralUtility
   :Description:
         **General Purpose Functions**

         A collection of multi-purpose PHP functions. Some are TYPO3 specific
         but not all.

         There are more specific utility classes in :file:`EXT:core/Classes/Utility`.
   :Usage:
         Static class, call methods using :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::`


 - :Class: \\TYPO3\\CMS\\Backend\\Utility\\BackendUtility
   :Description:
         **Backend Specific Functions**

         Contains functions specific to the TYPO3 backend. You will
         typically need these when programming backend modules or other backend
         functionality.

         *This class is NOT available in the frontend!*
   :Usage:
         Static class, call methods using :code:`\TYPO3\CMS\Backend\Utility\BackendUtility::`


 - :Class: \\TYPO3\\CMS\\Core\\Utility\\ExtensionManagementUtility
   :Description:
         **Extension API functions**

         Functions for extensions to interface with the core system. Many of
         these functions are used in `ext\_localconf.php` and `ext\_tables.php`
         files of extensions. They let extensions register their features with
         the system.
   :Usage:
         Static class, call methods using :code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::`


 - :Class: \\TYPO3\\CMS\\Backend\\Utility\\IconUtility
   :Description:
         **Icons / Part of skinning API**

         Contains a few functions for getting the right icon for a database
         table record or the skinned version of any other icon.

         *This class is NOT available in the frontend!*
   :Usage:
         Static class, call methods using :code:`\TYPO3\CMS\Backend\Utility\IconUtility::`


 - :Class: \\TYPO3\\CMS\\Backend\\Template\\DocumentTemplate
   :Description:
         **Backend Template Class**

         Contains functions for producing the layout of backend modules,
         setting up HTML headers, wrapping JavaScript sections correctly for
         XHTML, etc.
   :Usage:
         Available as :code:`$GLOBALS['TBE_TEMPLATE']`, :code:`$GLOBALS['SOBE']` or
         :code:`$this->doc` (inside of BE modules)

These classes are always included and available in the TYPO3 backend
and frontend (except :code:`\TYPO3\CMS\Backend\Utility\BackendUtility` and :code:`\TYPO3\CMS\Backend\Utility\IconUtility`).

The next sections highlight a selection of methods from these classes.
They were chosen for their general importance with regards to the whole
of TYPO3. You should at least acquaint yourself with all these high-
priority functions, in order to write code the TYPO3 way.
These lists also include some other methods selected for their usefulness.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   HighPriorityFunctions/Index
   UsefulFunctions/Index


