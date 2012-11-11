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
   :code:`t3lib_pageTree`) and :code:`SC_db_new`. The class :code:`SC_db_new` is a
   so-called "Script Class" - this will hold the code specifically for this
   script.You also find that the only code executed in the global scope
   is this::

         $SOBE = t3lib_div::makeInstance('SC_db_new');
         $SOBE->init();
         $SOBE->main();
         $SOBE->printContent();

#. When you examine the :code:`SC_db_new` class you find that the main() method
   is the one you would like to extend.

#. Finally you find that immediately after the definition of the two
   classes there is three lines of code which will provide you with the
   final piece of knowledge you need::

      if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['typo3/db_new.php'])) {
      	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['typo3/db_new.php']);
      }

   So now you know that the key to use is :code:`typo3/db_new.php` when you
   wish to define a script which should be included as the extension.

Let's see what happens then in the extension "examples":

#. First we have a class that extends the :code:`SC_db_new`
   (:file:`xclasses/class.tx_examples_scdbnew.php`)::

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

   $TYPO3_CONF_VARS['BE']['XCLASS']['typo3/db_new.php'] = t3lib_extMgm::extPath($_EXTKEY, 'xclasses/class.tx_examples_scdbnew.php');`

There is no "table of extendable classes" in this document because 1)
all classes are extendable and 2) the number of classes will grow as
TYPO3 is further developed and extensions are made and 3) finally you
cannot extend a class unless you know it exists and have analyzed some
of its internal structure (methods / variables) - so you'll have to
dig into the source anyway!

Therefore, if you wish to extend something, follow this suggestion for
an analysis of the situation and you'll end up with the knowledge
needed in order to extend that class and thereby extend TYPO3
*without* loosing backwards compatibility with future updates. Great.


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
class :code:`tslib_cObj` (found in the class file
:file:`typo3/sysext/cms/tslib/class.tslib_content.php` ).

The first thing to do is to create the extension class. So you create
a file in the :file:`typo3conf/` directory named
:file:`class.ux_tslib_content.php`. :code:`ux` is a prefix meaning "user-
extension". This file may look like this::

   <?php
   /**
    * User-Extension of tslib_cObj class.
    *
    * @author    Kasper Skårhøj <kasper@typo3.com>
    */

   class ux_tslib_cObj extends tslib_cObj {
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

The next thing is to configure TYPO3 to include this class file as
well after the original file :file:`tslib/class.tslib_content.php`::

   $TYPO3_CONF_VARS['FE']['XCLASS']['tslib/class.tslib_content.php']=
                              PATH_typo3conf . 'class.ux_tslib_content.php';

So when the file :file:`tslib/class.tslib_content.php` is included inside
of :file:`class.tslib\_pagegen.php`, the extension class is included
immediately from inside the :file:`tslib/class.tslib_content.php` file
(this is from the bottom of the file)::

   if (defined('TYPO3_MODE') &&
          $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php'])    {
       include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php']);
   }

The last thing which remains is to instantiate the class
:code:`ux_tslib_cObj` instead of :code:`tslib_cObj`. This is done automatically,
because everywhere :code:`tslib_cObj` is instantiated, it is first examined
if :code:`ux_tslib_cObj` exists and if so, that class is instantiated
instead!

This is done by instantiating the object with
:code:`t3lib_div::makeInstance()`::

   $cObj = t3lib_div::makeInstance('tslib_cObj');

Originally it looked like this::

   $cObj = new tslib_cObj;

Internally :code:`t3lib_div::makeInstance()` does something like::

   $cObj = class_exists('ux_tslib_cObj') ? new ux_tslib_cObj : new tslib_cObj;


.. important::

   When setting up the file to include, in particular from :file:`t3lib/`, notice
   the difference between :code:`$TYPO3_CONF_VARS["BE"]["XCLASS"][...]` and
   :code:`$TYPO3_CONF_VARS["FE"]["XCLASS"][...]`. The key :code:`FE` is used when the
   class is included by a front-end script (those initialized by
   :file:`tslib/index_ts.php` and :file:`tslib/showpic.php` - both also known as
   index.php and showpic.php in the root of the website), :code:`BE` is used by
   backend scripts (those initialized by :file:`typo3/init.php` or
   :file:`typo3/thumbs.php`). This feature allows you to include a different
   extension when the (:file:`t3lib/-`) class is used in the frontend and in the
   backend.

