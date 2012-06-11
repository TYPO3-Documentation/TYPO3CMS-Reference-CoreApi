

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


Introduction
^^^^^^^^^^^^

Practically all important scripts have their main code encapsulated in
a class (typically named SC\_[scriptname] and instantiated as the
global object $SOBE) and almost all libraryclasses used in TYPO3 -
both frontend and backend - can be extended by user defined classes.
Extension of TYPO3 PHP classes may also be referred to as an "XCLASS
extension".

Extending TYPO3s PHP classes is recommended mostly for special needs
in individual projects. This is due to the limitation that a class can
only be extended once. Thus, if many extensions try to extend the same
class, only one of them will succeed and in turn the others will not
function correctly.

So, extending classes is a great option for individual projects where
special "hacks" are needed. But generally it is a poor way of
programming TYPO3 extensions in which case you should look for a
system hook or request a system hook to be made for your purpose if
generally meaningful.

Configuring user-classes works like this:

#. In (ext\_)localconf.php you configure for either frontend or backend
   that you wish to include a file with the extension of the class. This
   inclusion is usually done in the end of the class-file itself based on
   a lookup in TYPO3\_CONF\_VARS.

#. Whenever the class is instantiated as an object, the source code
   checks if a user-extension of that class exists. If so, then  *that*
   class (or an extension of the extended class) is instantiated and not
   the “normal” (parent) class.Getting the correct instance of a class is
   done by using the function t3lib\_div::makeInstance() instead of "new
   ..." when an object is created.


((generated))
"""""""""""""

Example
~~~~~~~

Say you wish to make an addition to the stdWrap method found in the
class “tslib\_cObj” (found in the class file
:code:`typo3/sysext/cms/tslib/class.tslib\_content.php` ).

The first thing to do is to create the extension class. So you create
a file in the typo3conf/ directory named
“class.ux\_tslib\_content.php”. “ux” is a prefix meaning “user-
extension”. This file may look like this:

::

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
well after the original file tslib/class.tslib\_content.php:

::

   $TYPO3_CONF_VARS['FE']['XCLASS']['tslib/class.tslib_content.php']=
                              PATH_typo3conf . 'class.ux_tslib_content.php';

So when the file “tslib/class.tslib\_content.php” is included inside
of class.tslib\_pagegen.php, the extension class is included
immediately from inside the “tslib/class.tslib\_content.php” file
(this is from the bottom of the file):

::

   if (defined('TYPO3_MODE') && 
          $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php'])    {
       include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php']);
   }

The last thing which remains is to instantiate the class
ux\_tslib\_cObj instead of tslib\_cObj. This is done automatically,
because everywhere tslib\_cObj is instantiated, it is first examined
if ux\_tslib\_cObj exists and if so, that class is instantiated
instead!

This is done by instantiating the object with
"t3lib\_div::makeInstance()":

::

   $cObj = t3lib_div::makeInstance('tslib_cObj');

Originally it looked like this:

::

   $cObj = new tslib_cObj;

Internally "t3lib\_div::makeInstance()" does this:

::

   $cObj = class_exists('ux_tslib_cObj') ? new ux_tslib_cObj : new tslib_cObj;


IMPORTANT
"""""""""

When setting up the file to include, in particular from t3lib/, notice
the difference between $TYPO3\_CONF\_VARS["BE"]["XCLASS"][...] and
$TYPO3\_CONF\_VARS["FE"]["XCLASS"][...]. The key “FE” is used when the
class is included by a front-end script (those initialized by
tslib/index\_ts.php and tslib/showpic.php - both also known as
index.php and showpic.php in the root of the website), “BE” is used by
backend scripts (those initialized by typo3/init.php or
typo3/thumbs.php). This feature allows you to include a different
extension when the (t3lib/-) class is used in the frontend and in the
backend.

