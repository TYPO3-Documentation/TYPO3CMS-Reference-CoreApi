.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt



.. _xclasses-example:

Examples
^^^^^^^^


.. _xclasses-example-interface:

Example - Adding a small feature in the interface
"""""""""""""""""""""""""""""""""""""""""""""""""

Say you wish to add a little section with help text in the bottom of
the "New" dialog:

.. figure:: ../../../Images/XclassNewElementWizard.png
   :alt: Adding an element to the new record wizard

   The help section is added at the bottom of the new record wizard.

#. Find out that the script in question is :file:`typo3/db_new.php` (right-
   click frame, select "Properties" and look at URL).

#. Then examine the scripts for its classes and methods. In this case
   you'll find two classes in the file; "localPageTree" (extends
   :code:`\TYPO3\CMS\Backend\Tree\View\PageTreeView`)
   and :code:`\TYPO3\CMS\Backend\Controller\NewRecordController`.
   The class :code:`\TYPO3\CMS\Backend\Controller\NewRecordController` is a
   so-called "Script Class" - this will hold the code specifically for this
   script.You also find that the only code executed in the global scope
   is this::

         $SOBE = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Controller\\NewRecordController');
         $SOBE->init();
         $SOBE->main();
         $SOBE->printContent();

#. When you examine the :code:`\TYPO3\CMS\Backend\Controller\NewRecordController` class you find that the main() method
   is the one you would like to extend.

Let's see what happens then in the extension "examples":

#. First we have a class that extends the :code:`\TYPO3\CMS\Backend\Controller\NewRecordController`
   (:file:`Classes/Xclass/NewRecordController.php`)::

      function regularNew() {
      	parent::regularNew();
      	$this->code .= $this->doc->section(
      		$GLOBALS['LANG']->sL('LLL:EXT:examples/locallang.xml:help'),
      		$GLOBALS['LANG']->sL('LLL:EXT:examples/locallang.xml:make_choice'),
      		0,
      		1
      	);
      }

#. The XCLASS is then registered in the extension's :file:`ext_localconf.php`
   file::

       $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\Controller\\NewRecordController'] = array(
       	'className' => 'Documentation\\Examples\\Xclass\\NewRecordController'
       );

All classes are thus extendable.


.. _xclasses-sc-classes:

Notes on SC\_\* classes (script classes)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

There is one more thing to note about especially the SC\_\* classes in
the backend:

#. **Global vars:** They use a lot of variables from the global scope.
   This is due to historical reasons; The code formerly resided in the
   global scope and a quick conversion into classes demanded this
   approach. Future policy is to keep as many variables internal as
   possible and if any of these SC\_\* classes are developed further in
   the future, some of the globals might on that occasion be
   internalized.

#. **Large methods:** There are typically a :code:`init()`, :code:`main()` and
   :code:`printContent()` method in the SC-classes. Each of these, in particular
   the :code:`main()` method may grow large. Processing stuff in the start and
   end of the methods is easy - you just call parent::[methodname]() from
   your extension. But if you want to extend or process something in the
   middle of one of these methods, it would be necessary to call a dummy
   method at that point in the parent class. Such a dummy method would
   then be used for processing in *your* class, but would not affect the
   general use of the parent class. Such dummy-method calls are not
   widely included yet, but will be as suggestions for them appears. And
   you are very welcome to give in such suggestions.I'll just give an
   example to illustrate what I mean::

      class SC_example {
          function main() {
              $number = 100;
              echo 'The number is ' . $number;
          }
      }


   This class prints the text "The number is 100". If you wish to do some
   calculations to the $number-variable before it is printed, you are
   forced to simply include the whole original main-method in your
   extension script. Here it would be no problem because the method is 2
   lines long. But it could be 200 lines! So what you do is that you
   suggest to the TYPO3 development to call a "harmless" dummy method in
   the :code:`main()` method... ::

      class SC_example {
          function main() {
              $number = 100;
              $number = $this->processNumber($number);
              echo 'The number is ' . $number;
          }
          function processNumber($theNumber) {
              return $theNumber;
          }
      }


   ... and then you extend the class as follows::

      class ux_SC_example extends SC_example {
      	function processNumber() {
      		return($theNumber < 100) ? 'less than 100' : 'greater than 100';
      	}
      }

   ... and now the :code:`main()` method would print "The number is greater than
   100" instead. Notice that you'll have to make such suggestions for
   dummy method calls because we will include them only as people need
   them.


.. _xclasses-example-fe:

Extending a FE class
""""""""""""""""""""

Say you wish to make an addition to the stdWrap method found in the
class :code:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`.

The first thing to do is to create the overriding class, in an extension.
This file may look like this::

   <?php
   namespace Foo\Bar\Xclass;
   /**
    * User-Extension of \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer class.
    *
    * @author    Kasper Skårhøj <kasper@typo3.com>
    */

   class CustomContentObjectRenderer extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer {
       function stdWrap($content,$conf) {
               // Call the real stdWrap function in the parent class:
           $content = parent::stdWrap($content,$conf);
               // Process according to my user-defined property:
           if ($conf['userDefined_wrapInRed']) {
               $content='<font color="red">' . $content . '</font>';
           }
           return $content;
       }
   }
   ?>


The next thing is to configure TYPO3 to use this class to override
:code:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`::

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'] = array(
   	'className' => 'Foo\\Bar\\Xclass\\CustomContentObjectRenderer'
   );


Whenever class :code:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`
is instantiated, it will automatically be overridden by
:code:`\Foo\Bar\Xclass\CustomContentObjectRenderer` as long as
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` is used
to create instances::

   $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');

and not like this::

   $cObj = new \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
