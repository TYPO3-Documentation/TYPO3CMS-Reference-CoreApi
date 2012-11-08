.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Implementing a service
^^^^^^^^^^^^^^^^^^^^^^

The best way to get started when implementing a service is to use the
Extension Kickstarter. It will help you create the skeleton of your
service. In the Kickstarter you start by setting the general
information and declaring that your extension is of type “Service”:

|img-3| Then move to the “Services” section if the left-hand menu and
define a first service. Your screen might look something like this:

|img-4|

Apart from the standard extension declaration file (
:code:`ext\_emconf.php` ) and extension's icon ( :code:`ext\_icon.gif`
), the Kickstarter will create the following files:

- :code:`ext\_localconf.php` where the service is declared

- :code:`sv1/class.tx\_myext\_sv1.php` where the code of the service
  resides

As can be seen the naming convention for services is very close to the
one used for FE plug-ins, using “sv” instead of “pi”.


Service registration
""""""""""""""""""""

Registering a service is done inside the :code:`ext\_localconf.php`
file. Let's look at what is inside. ::

   <?php
   if (!defined ('TYPO3_MODE')) {
           die ('Access denied.');
   }

   t3lib_extMgm::addService($_EXTKEY, 'textLang' /* sv type */, 'tx_babelfish_sv1' /* sv key */,
                   array(
                           'title' => 'Babelfish',
                           'description' => 'Guess alien languages by using a babelfish',

                           'subtype' => '',

                           'available' => true,
                           'priority' => 60,
                           'quality' => 80,

                           'os' => '',
                           'exec' => '',

                           'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_babelfish_sv1.php',
                           'className' => 'tx_babelfish_sv1',
                   )
           );
   ?>

A service is registered with TYPO3 by calling
:code:`t3lib\_extMgm::addService()` . This method takes the following
parameters:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Parameter
         Parameter:

   Data type
         Data type:

   Description
         Description:


.. container:: table-row

   Parameter
         $extKey

   Data type
         string

   Description
         The key of the extension containing the service.


.. container:: table-row

   Parameter
         $serviceType

   Data type
         string

   Description
         Service type of the service.


.. container:: table-row

   Parameter
         $serviceKey

   Data type
         string

   Description
         Unique key for the service. By default, the Kickstarter creates the
         key as “tx\_myext\_sv1” for the first service, “tx\_myext\_sv2” for
         the second service, etc. This may be changed freely, but the key
         should be explicit of the service's function.


.. container:: table-row

   Parameter
         $info

   Data type
         array

   Description
         Additional information about the service. This is described below.


.. ###### END~OF~TABLE ######

The additional information array defines the main properties of a
service:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:

   Data type
         Data type:

   Description
         Description:

   Default
         Default:


.. container:: table-row

   Property
         title

   Data type
         string

   Description
         The title of the service.

   Default


.. container:: table-row

   Property
         description

   Data type
         string

   Description
         The description. If it makes sense it should contain information about

         - the quality of the service (if it's better or not than normal)

         - the OS dependency

         - the dependency on external programs (perl, pdftotext, etc.)

   Default


.. container:: table-row

   Property
         subtype

   Data type
         string / comma list

   Description
         The subtype is not predefined. Its usage is defined by the API of the
         service type.

         **Example:** ::

            'subtype' => 'jpg,tif',

   Default


.. container:: table-row

   Property
         available

   Data type
         boolean

   Description
         Defines if the service is available or not. This means that the
         service will be ignored if available is set to false.

         It makes no sense to set this to false, but it can be used to make a
         quick check if the service works on the system it installed:

         **Examples:** ::

              // is the curl extension available we need
            'available' => function_exists('curl_exec'),

         Only quick checks are appropriate here. More extensive checks should
         be performed when the service is requested and the service class is
         initialized.

   Default
         true


.. container:: table-row

   Property
         priority

   Data type
         integer

   Description
         The priority of the service. A service of higher priority will be
         selected first.Can be reconfigured with :code:`$TYPO3\_CONF\_VARS` .

         Use a value from 0 to 100. Higher values are reserved for
         reconfiguration by :code:`$TYPO3\_CONF\_VARS` . The default value is
         50 which means that the service is well implemented and gives normal
         (good) results.

         Imagine that you have two solutions, a pure PHP one and another that
         depends on an external program. The PHP solution should have a
         priority of 50 and the other solution a lower one. PHP-only solutions
         should have a higher priority since they are more convenient in terms
         of server setup. But if the external solution gives better results you
         should set both to 50 and set the quality value to a higher value.

   Default
         50 (0-100)


.. container:: table-row

   Property
         quality

   Data type
         integer/float

   Description
         Among services with the same priority, the service with the highest
         quality by the same priority will be preferred.

         The use of the quality range is defined by the service type. Integer
         or floats can be used. The default range is 0-100 and the default
         value for a normal (good) quality service is 50.

         The value of the quality should represent the capacities of the
         services. Consider a service type that implements the detection of a
         language used in a text. Let's say that one service can detect 67
         languages and another one only 25. These values could be used directly
         as quality values.

   Default
         50 (0-100)


.. container:: table-row

   Property
         os

   Data type
         string

   Description
         Defines which operating system is needed to run this service.

         **Examples:** ::

              // runs only on UNIX
            'os' => 'UNIX',

              // runs only on Windows
            'os' => 'WIN',

              // no special dependency
            'os' => '',

   Default


.. container:: table-row

   Property
         exec

   Data type
         string / comma list

   Description
         List of external programs which are needed to run the service.
         Absolute paths are allowed but not recommended, because the programs
         are searched for automatically by t3lib\_exec. Leave empty if no
         external programs are needed.

         **Examples:** ::

            'exec' => 'perl',

            'exec' => 'pdftotext',

   Default


.. container:: table-row

   Property
         classFile

   Data type
         string

   Description
         Created by the kickstarter

         **Example:** ::

            t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_myextkey_sv1.php'

   Default


.. container:: table-row

   Property
         className

   Data type
         string

   Description
         Created by the kickstarter

         **Example:** ::

            'tx_myextkey_sv1'

   Default


.. ###### END~OF~TABLE ######


Skeleton service class
""""""""""""""""""""""

The Kickstarter will generate a skeleton PHP class for each service
defined. The example above will generate file
:code:`sv1/class.tx\_babelfish\_sv1.php` , which contains the
following sample code::

   /**
    * Service "Babelfish" for the "babelfish" extension.
    *
    * @author      Zaphod Beeblebrox <zaphod@goldenheart.com>
    * @package     TYPO3
    * @subpackage  tx_babelfish
    */
   class tx_babelfish_sv1 extends t3lib_svbase {
           var $prefixId = 'tx_babelfish_sv1';             // Same as class name
           var $scriptRelPath = 'sv1/class.tx_babelfish_sv1.php';  // Path to this script relative to the extension dir.
           var $extKey = 'babelfish';      // The extension key.

           /**
            * [Put your description here]
            *
            * @return      [type]          ...
            */
           function init() {
                   $available = parent::init();

                   // Here you can initialize your class.

                   // The class have to do a strict check if the service is available.
                   // The needed external programs are already checked in the parent class.

                   // If there's no reason for initialization you can remove this function.

                   return $available;
           }

           /**
            * [Put your description here]
            * performs the service processing
            *
            * @param       string          Content which should be processed.
            * @param       string          Content type
            * @param       array           Configuration array
            * @return      boolean
            */
           function process($content='', $type='', $conf=array())  {

                   // Depending on the service type there's not a process() function.
                   // You have to implement the API of that service type.

                   return false;
           }
   }

This sample code shows how a service class must inherit from the
:code:`t3lib\_svbase` base class, which is described in more details
below. It provides a skeleton for the :code:`init()` method which is
the single most important method for a service, as it defines – at
runtime – whether a given service is really available or not. This
method is also discussed in more details below.

The skeleton :code:`process()` method is just an example of what you
might want to implement in your service depending on the API of the
service type. In the example Kickstarter input above, the “babelfish”
service was declared as a “textLang” type of service. In this case the
specific service type API indeed consists of just the
:code:`process()` method.

The sample code generated by the Kickstarter may change in the future.

